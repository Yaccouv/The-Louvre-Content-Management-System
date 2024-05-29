<?php
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

class TplLouvreHelper
{
    public static function siteproductsAjax() {
        $themeName = Factory::getApplication()->getTemplate();
        $products = self::getProducts();
        header('Content-Type: application/json');
        $result = json_encode($products);
        $root = str_replace('/', '\/', Uri::root() . 'templates/' . $themeName . '/');
        $result = str_replace(':"images', ':"' . $root . 'images', $result);
        exit($result);
    }

    public static function productsAjax() {
        $data = self::getProductsData();
        $allProducts = isset($data['products']) ? $data['products'] : array();
        $categories = isset($data['categories']) ? $data['categories'] : array();
        if (count($allProducts) < 1) {
            return '';
        }

        $products = self::getProductsByCatId($allProducts);
        foreach ($products as &$p) {
            $p['categoriesData'] = self::getCategoriesData($categories, $p['categories']);
        }

        ob_start();
        include_once dirname(__FILE__) . '/ecommerce/category/default.php';
        $result = ob_get_clean();
        return $result;
    }

    public static function productAjax() {
        $productName = Factory::getApplication()->input->get('product_name', '');
        if (!$productName) {
            return '';
        }

        $product = self::getProductByName($productName);
        if (!$product) {
            return '';
        }

        ob_start();
        include_once dirname(__FILE__) . '/ecommerce/productdetails/default.php';
        $result = ob_get_clean();
        return $result;
    }

    public static function getProductsData() {
        $jsonFile = dirname(__FILE__) . '/ecommerce/products.json';
        if (!file_exists($jsonFile)) {
            return array();
        }
        ob_start();
        include_once dirname(__FILE__) . '/ecommerce/products.json';
        $productsJson = ob_get_clean();
        $data = json_decode($productsJson, true);

        $result = array(
            'products' => array(),
            'categories' => array(),
        );

        if (!$data) {
            return $result;
        }

        if (isset($data['products'])) {
            $result['products'] =  $data['products'];
        }
        if (isset($data['categories'])) {
            $result['categories'] =  $data['categories'];
        }

        return $result;
    }

    public static function getProducts()
    {
        $data = self::getProductsData();
        return $data['products'];
    }

    public static function getProductByName($name) {
        $data = self::getProductsData();
        $allProducts = $data['products'];
        $allCategories = $data['categories'];
        foreach ($allProducts as $product) {
            if (('product-' . $product['id']) === $name) {
                $product['categoriesData'] = self::getCategoriesData($allCategories, $product['categories']);
                return $product;
            }
        }
        return null;
    }

    public static function getProductsByCatId($products) {
        $id = Factory::getApplication()->input->getCmd('catid', '');
        if (!$id) {
            return $products;
        }

        $result = array();
        foreach ($products as $product) {
            if (in_array($id, $product['categories'])) {
                array_push($result, $product);
            }
        }
        return $result;
    }

    public static function getCategoriesData($categories, $productCatIds) {
        $categoriesData = array();
        foreach ($categories as $category) {
            if (in_array($category['id'], $productCatIds)) {
                $themeName = Factory::getApplication()->getTemplate();
                $url = 'index.php?option=com_ajax&format=html&template=' . $themeName;
                $category['id'] = $url . '&method=products&product_name=product-list&catid=' . $category['id'];
                array_push($categoriesData, $category);
            }
        }
        if (count($categoriesData) < 1) {
            array_push($categoriesData, array('id' => 0, 'title' => 'Uncategorized'));
        }
        return $categoriesData;
    }
}
