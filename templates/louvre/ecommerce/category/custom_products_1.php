<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

$result = '';
$document = Factory::getDocument();

$productsStyles = <<<STYLES
<style>
.u-section-1 .u-sheet-1 {
  min-height: 600px;
}
.u-section-1 .u-repeater-1 {
  min-height: 520px;
  grid-template-columns: repeat(3, 33.3333%);
  height: auto;
  grid-gap: 0px;
  margin: 40px auto 40px 0;
}
.u-section-1 .u-repeater-item-1 {
  background-image: none;
}
.u-section-1 .u-container-layout-1 {
  padding: 30px;
}
.u-section-1 .u-image-1 {
  height: 301px;
  margin-top: 0;
  margin-bottom: 0;
}
.u-section-1 .u-text-1 {
  margin: 20px 0 0;
}
.u-section-1 .u-product-price-1 {
  margin: 20px auto 0;
}
.u-section-1 .u-btn-1 {
  border-style: solid;
  text-transform: uppercase;
  font-size: 0.875rem;
  margin: 20px auto 0;
}
.u-section-1 .u-repeater-item-2 {
  background-image: none;
}
.u-section-1 .u-container-layout-2 {
  padding: 30px;
}
.u-section-1 .u-image-2 {
  height: 301px;
  margin-top: 0;
  margin-bottom: 0;
}
.u-section-1 .u-text-2 {
  margin: 20px 0 0;
}
.u-section-1 .u-product-price-2 {
  margin: 20px auto 0;
}
.u-section-1 .u-btn-2 {
  border-style: solid;
  text-transform: uppercase;
  font-size: 0.875rem;
  margin: 20px auto 0;
}
.u-section-1 .u-repeater-item-3 {
  background-image: none;
}
.u-section-1 .u-container-layout-3 {
  padding: 30px;
}
.u-section-1 .u-image-3 {
  height: 301px;
  margin-top: 0;
  margin-bottom: 0;
}
.u-section-1 .u-text-3 {
  margin: 20px 0 0;
}
.u-section-1 .u-product-price-3 {
  margin: 20px auto 0;
}
.u-section-1 .u-btn-3 {
  border-style: solid;
  text-transform: uppercase;
  font-size: 0.875rem;
  margin: 20px auto 0;
}
.u-section-1 .u-repeater-item-4 {
  background-image: none;
}
.u-section-1 .u-container-layout-4 {
  padding: 30px;
}
.u-section-1 .u-image-4 {
  height: 301px;
  margin-top: 0;
  margin-bottom: 0;
}
.u-section-1 .u-text-4 {
  margin: 20px 0 0;
}
.u-section-1 .u-product-price-4 {
  margin: 20px auto 0;
}
.u-section-1 .u-btn-4 {
  border-style: solid;
  text-transform: uppercase;
  font-size: 0.875rem;
  margin: 20px auto 0;
}
.u-section-1 .u-repeater-item-5 {
  background-image: none;
}
.u-section-1 .u-container-layout-5 {
  padding: 30px;
}
.u-section-1 .u-image-5 {
  height: 301px;
  margin-top: 0;
  margin-bottom: 0;
}
.u-section-1 .u-text-5 {
  margin: 20px 0 0;
}
.u-section-1 .u-product-price-5 {
  margin: 20px auto 0;
}
.u-section-1 .u-btn-5 {
  border-style: solid;
  text-transform: uppercase;
  font-size: 0.875rem;
  margin: 20px auto 0;
}
.u-section-1 .u-repeater-item-6 {
  background-image: none;
}
.u-section-1 .u-container-layout-6 {
  padding: 30px;
}
.u-section-1 .u-image-6 {
  height: 301px;
  margin-top: 0;
  margin-bottom: 0;
}
.u-section-1 .u-text-6 {
  margin: 20px 0 0;
}
.u-section-1 .u-product-price-6 {
  margin: 20px auto 0;
}
.u-section-1 .u-btn-6 {
  border-style: solid;
  text-transform: uppercase;
  font-size: 0.875rem;
  margin: 20px auto 0;
}
@media (max-width: 1199px) {
  .u-section-1 .u-sheet-1 {
    min-height: 509px;
  }
  .u-section-1 .u-repeater-1 {
    min-height: 429px;
    grid-template-columns: repeat(3, 33.333333333333336%);
    margin-right: initial;
    margin-left: initial;
  }
}
@media (max-width: 991px) {
  .u-section-1 .u-sheet-1 {
    min-height: 1066px;
  }
  .u-section-1 .u-repeater-1 {
    min-height: 986px;
    grid-template-columns: repeat(2, 50%);
    margin-right: initial;
    margin-left: initial;
  }
}
@media (max-width: 767px) {
  .u-section-1 .u-repeater-1 {
    grid-template-columns: 100%;
    margin-right: initial;
    margin-left: initial;
  }
  .u-section-1 .u-container-layout-1 {
    padding-left: 10px;
    padding-right: 10px;
  }
  .u-section-1 .u-image-1 {
    height: 506px;
  }
  .u-section-1 .u-container-layout-2 {
    padding-left: 10px;
    padding-right: 10px;
  }
  .u-section-1 .u-image-2 {
    height: 506px;
  }
  .u-section-1 .u-container-layout-3 {
    padding-left: 10px;
    padding-right: 10px;
  }
  .u-section-1 .u-image-3 {
    height: 506px;
  }
  .u-section-1 .u-container-layout-4 {
    padding-left: 10px;
    padding-right: 10px;
  }
  .u-section-1 .u-image-4 {
    height: 506px;
  }
  .u-section-1 .u-container-layout-5 {
    padding-left: 10px;
    padding-right: 10px;
  }
  .u-section-1 .u-image-5 {
    height: 506px;
  }
  .u-section-1 .u-container-layout-6 {
    padding-left: 10px;
    padding-right: 10px;
  }
  .u-section-1 .u-image-6 {
    height: 506px;
  }
}
@media (max-width: 575px) {
  .u-section-1 .u-image-1 {
    height: 365px;
  }
  .u-section-1 .u-image-2 {
    height: 365px;
  }
  .u-section-1 .u-image-3 {
    height: 365px;
  }
  .u-section-1 .u-image-4 {
    height: 365px;
  }
  .u-section-1 .u-image-5 {
    height: 365px;
  }
  .u-section-1 .u-image-6 {
    height: 365px;
  }
}

</style>
STYLES;
$document->addCustomTag($productsStyles);

ob_start(); ?>
    
<?php
$backToTop = ob_get_clean();

ob_start();
?>
    
<?php
$popupDialogs= ob_get_clean();

$settings = array(
    'hideHeader' => false,
    'hideFooter' => false,
    'bodyClass' => 'u-body u-xl-mode',
    'bodyStyle' => "",
    'localFontsFile' => "",
    'backToTop' => $backToTop,
    'popupDialogs' => $popupDialogs,
);
$result .= '<!--component_settings-->' . json_encode($settings) . '<!--/component_settings-->';

$funcsInfo = array(
   array('repeatable' => true, 'name' => 'custom_productsTemplate_0_custom_products_1', 'itemsExists' => true),

);

$funcsStaticInfo = array(

);

$lang = checkAndGetLanguage();

$app = Factory::getApplication();
$limitstart = $app->input->get('offset', 'start');
if ($limitstart !== 'start') {
    $result = '';
}

if (count($funcsInfo)) {
    foreach ($funcsInfo as $funcInfo) {
        if (!$funcInfo['itemsExists']) {
            ob_start();
            include dirname(dirname(dirname(__FILE__))) . '/ecommerce/' . $funcInfo['name'] . '.php';
            $result .= ob_get_clean();
            continue;
        }
        $iterator = 0;
        $iterator++;

        $productsOptions = array();
        $paginationProps = null;
        if (file_exists(dirname(dirname(dirname(__FILE__))) . '/ecommerce/' . $funcInfo['name'] . '_start.php')) {
            ob_start();
            include dirname(dirname(dirname(__FILE__))) . '/ecommerce/' . $funcInfo['name'] . '_start.php';
            $startHtml = ob_get_clean();
            if (preg_match('/<\!--products_options_json--><\!--([\s\S]+?)--><\!--\/products_options_json-->/', $startHtml, $matches)) {
                $productsOptions = json_decode($matches[1], true);
                $startHtml = str_replace($matches[0], '', $startHtml);
            }
            $result .= $startHtml;
        }
        $productsCount = isset($productsOptions['count']) ? (int) $productsOptions['count'] : '';

        if ($productsCount) {
            $limit = (int) ($limitstart === 'start' ? 0 : $limitstart);
            $paginationProps = array(
                'allPosts' => count($products),
                'offset' => $limit,
                'postsPerPage' => $productsCount,
            );
            $products = array_slice($products, $limit, $productsCount);
        }

        foreach ($products as $itemIndex => $product) {
            $index = 0;
            ${'title' . $index} = $product['title'];
            ${'titleLink' . $index} = '';
            ${'content' . $index} = $product['description'];

            $app = Factory::getApplication();
            $imagePath = Uri::root(true) . '/templates/' . $app->getTemplate() . '/';
            $fullImage = '';
            if (isset($product['images']) && count($product['images']) > 0) {
                $images = $product['images'];
                $fullImage = $imagePath . $images[0]['url'];
            }
            ${'image' . $index} = $fullImage;

            ${'productId' . $index} = $product['id'];
            ${'productJson' . $index} = htmlspecialchars(json_encode($product));

            ${'productRegularPrice' . $index} = $product['fullPrice'];
            ${'productOldPrice' . $index} = $product['fullPriceOld'];

            ${'productCategories' . $index} = $product['categoriesData'];

            ${'productOutOfStock' . $index} = $product['outOfStock'];

            $currentDate = (int) (microtime(true) * 1000);
            if (isset($product['created'])) {
                $createdDate = $product['created'];
            } else {
                $createdDate = $currentDate;
            }
            $milliseconds30Days = 30 * (60 * 60 * 24 * 1000); // 30 days in milliseconds
            $isNew = false;
            if (($currentDate - $createdDate) <= $milliseconds30Days) {
                $isNew = true;
            }
            ${'productIsNew' . $index} = $isNew;

            $price = 0;
            if (isset($product['price'])) {
                $price = (float) $product['price'];
            }
            $oldPrice = 0;
            if (isset($product['oldPrice'])) {
                $oldPrice = (float) $product['oldPrice'];
            }
            $sale = '';
            if ($price && $oldPrice && $price < $oldPrice) {
                $sale = '-' . (int)(100 - ($price * 100 / $oldPrice)) . '%';
            }
            ${'productIsSale' . $index} = $sale;

            //$btnProps = $product->getButtonProps();
            ${'productButtonText' . $index} = '';//$btnProps['text'];
            //${'productButtonLink' . $index} = $btnProps['link'];
            ${'productButtonHtml' . $index} = ''; //$btnProps['html'];
            ob_start();
            include dirname(dirname(dirname(__FILE__))) . '/ecommerce/' . $funcInfo['name'] . '.php';
            $result .= ob_get_clean();
        }

        if (file_exists(dirname(dirname(dirname(__FILE__))) . '/ecommerce/' . $funcInfo['name'] . '_end.php')) {
            ob_start();
            include dirname(dirname(dirname(__FILE__))) . '/ecommerce/' . $funcInfo['name'] . '_end.php';
            $result .= ob_get_clean();
        }

    }
}

if (count($funcsStaticInfo)) {
    for ($i = 0; $i < count($funcsStaticInfo); $i++) {
        ob_start();
        include_once dirname(dirname(dirname(__FILE__))) . '/ecommerce/' . $funcsStaticInfo[$i]['name'] . '.php';
        $result .= ob_get_clean();
    }
}

if ($limitstart !== 'start') {
    header('Content-Type: text/html');
    exit($result);
} else {
    echo $result;
}
