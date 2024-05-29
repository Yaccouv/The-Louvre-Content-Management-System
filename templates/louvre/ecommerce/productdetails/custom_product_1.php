<?php
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;

$document = Factory::getDocument();

$productStyles = <<<STYLES
<style>
.u-section-1 .u-sheet-1 {
  min-height: 595px;
}
.u-section-1 .u-product-1 {
  min-height: 495px;
  margin-top: 50px;
  margin-bottom: 50px;
}
.u-section-1 .u-container-layout-1 {
  padding: 30px;
}
.u-section-1 .u-gallery-1 {
  width: 540px;
  height: 433px;
  margin: 0 auto 0 0;
}
.u-section-1 .u-over-slide-1 {
  min-height: 100px;
  padding: 10px;
}
.u-section-1 .u-over-slide-1 {
  min-height: 100px;
  padding: 10px;
}
.u-section-1 .u-carousel-thumbnails-1 {
  padding-right: 10px;
  padding-top: 0;
  padding-left: 0;
}
.u-section-1 .u-carousel-thumbnail-1 {
  width: 100px;
  height: 100px;
}
.u-section-1 .u-carousel-thumbnail-2 {
  width: 100px;
  height: 100px;
}
.u-section-1 .u-carousel-control-1 {
  position: absolute;
  left: 110px;
  width: 40px;
  height: 40px;
  background-image: none;
}
.u-section-1 .u-carousel-control-2 {
  position: absolute;
  width: 40px;
  height: 40px;
  background-image: none;
  left: auto;
  right: 0;
}
.u-section-1 .u-text-1 {
  margin: -353px auto 0 598px;
}
.u-section-1 .u-product-price-1 {
  margin: 30px auto 0 598px;
}
.u-section-1 .u-text-2 {
  margin: 30px auto 0 598px;
}
.u-section-1 .u-btn-1 {
  border-style: solid;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 2px;
  margin: 30px auto 78px 598px;
  padding: 10px 43px 10px 42px;
}
@media (max-width: 1199px) {
  .u-section-1 .u-sheet-1 {
    min-height: 519px;
  }
  .u-section-1 .u-product-1 {
    height: auto;
    min-height: 419px;
  }
  .u-section-1 .u-gallery-1 {
    width: 471px;
    height: 357px;
  }
  .u-section-1 .u-text-1 {
    width: auto;
    margin-top: -328px;
    margin-left: 515px;
  }
  .u-section-1 .u-product-price-1 {
    margin-left: 515px;
  }
  .u-section-1 .u-text-2 {
    width: auto;
    margin-right: 0;
    margin-left: 515px;
  }
  .u-section-1 .u-btn-1 {
    margin-bottom: 0;
    margin-left: 515px;
  }
}
@media (max-width: 991px) {
  .u-section-1 .u-product-1 {
    min-height: 926px;
  }
  .u-section-1 .u-gallery-1 {
    width: 660px;
    height: 553px;
  }
  .u-section-1 .u-text-1 {
    margin-top: 40px;
    margin-left: 110px;
  }
  .u-section-1 .u-product-price-1 {
    margin-top: 20px;
    margin-left: 110px;
  }
  .u-section-1 .u-text-2 {
    margin-left: 110px;
  }
  .u-section-1 .u-btn-1 {
    margin-top: 27px;
    margin-left: 110px;
  }
}
@media (max-width: 767px) {
  .u-section-1 .u-sheet-1 {
    min-height: 898px;
  }
  .u-section-1 .u-product-1 {
    margin-bottom: -68px;
    min-height: 798px;
  }
  .u-section-1 .u-container-layout-1 {
    padding-left: 10px;
    padding-right: 10px;
  }
  .u-section-1 .u-gallery-1 {
    width: 520px;
    height: 415px;
  }
  .u-section-1 .u-text-1 {
    margin-right: 287px;
    margin-left: 0;
  }
  .u-section-1 .u-product-price-1 {
    margin-left: 0;
  }
  .u-section-1 .u-text-2 {
    margin-right: auto;
    margin-left: 0;
  }
  .u-section-1 .u-btn-1 {
    margin-left: 0;
  }
}
@media (max-width: 575px) {
  .u-section-1 .u-sheet-1 {
    min-height: 681px;
  }
  .u-section-1 .u-product-1 {
    margin-bottom: 50px;
    min-height: 581px;
  }
  .u-section-1 .u-gallery-1 {
    width: 320px;
    height: 209px;
  }
  .u-section-1 .u-text-1 {
    margin-top: 35px;
    margin-right: 0;
  }
}

</style>
STYLES;
$document->addCustomTag($productStyles);

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
echo '<!--component_settings-->' . json_encode($settings) . '<!--/component_settings-->';
$lang = checkAndGetLanguage();
$index = 0;
${'title' . $index} = $product['title'];
${'titleLink' . $index} = '';
${'content' . $index} = $product['description'];

$app = Factory::getApplication();
$imagePath = Uri::root(true) . '/templates/' . $app->getTemplate() . '/';
$fullImage = '';
$galleryImages = array();
if (isset($product['images']) && count($product['images']) > 0) {
    $images = $product['images'];
    $fullImage = $imagePath . $images[0]['url'];
    for($i = 0; $i < count($images); $i++) {
        array_push($galleryImages, $imagePath . $images[$i]['url']);
    }
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

//$btnProps = $product->getButtonProps(true);
${'productButtonText' . $index} = ''; //$btnProps['text'];
//${'productButtonLink' . $index} = $btnProps['link'];
${'productButtonHtml' . $index} = ''; //$btnProps['html'];

?>
<?php
include_once dirname(dirname(__FILE__)) . '/productTemplate_0_custom_product_1.php';
?>
