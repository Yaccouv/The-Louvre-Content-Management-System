<?php
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

class TplIcmPraiseHelper {
    public static function getProducts()
    {
        $jsonFile = dirname(__FILE__) . '/ecommerce/products.json';
        if (!file_exists($jsonFile)) {
            return array();
        }
        ob_start();
        include_once dirname(__FILE__) . '/ecommerce/products.json';
        $productsJson = ob_get_clean();
        $result = json_decode($productsJson, true);
        return $result ? $result['products'] : array();
    }

    public static function getProductByName($name) {
        $products = self::getProducts();
        foreach ($products as $product) {
            if (('product-' . $product['id']) === $name) {
                return $product;
            }
        }
        return null;
    }

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
        $products = self::getProducts();
        if (count($products) < 1) {
            return '';
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
}
