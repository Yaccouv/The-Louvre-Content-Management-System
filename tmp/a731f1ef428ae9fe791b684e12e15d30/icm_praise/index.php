<?php

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\HTML\HTMLHelper;

$indexDir = dirname(__FILE__);
require_once $indexDir . '/functions.php';

HTMLHelper::_('jquery.framework');
HTMLHelper::_('bootstrap.framework');

$app = Factory::getApplication();
$config = $app->getConfig();
$sef = $app->get('sef', false);

$defaultLogo = getLogoInfo(array('src' => "/images/mm-logo-horizontal.png"));

// Create alias for $this object reference:
$document = $this;

$currentUrl = Uri::getInstance()->toString();
if ($sef)
{
    $document->setBase($currentUrl);
}

$metaGeneratorContent = 'Nicepage 5.20.7, nicepage.com';
if ($metaGeneratorContent) {
    $document->setMetaData('generator', $metaGeneratorContent);
}
$metaReferrer = 'true';
if ($metaReferrer) {
    $document->setMetaData('referrer', 'origin');
}

$templateUrl = $document->baseurl . '/templates/' . $document->template;
$faviconPath = "" ? $templateUrl . '/images/' . "" : '';

Core::load("Core_Page");
Core::load("Core_PageProperties");

// Initialize $view:
$this->view = new CorePage($this);

$pageProperties = new CorePageProperties($this);
$bodyClass = $pageProperties->getBodyClass('u-body u-xl-mode');
$bodyStyle = $pageProperties->getBodyStyle();
$backToTop = $pageProperties->getBackToTop();
$popupDialogs = $pageProperties->getPopupDialogs();
$showHeader = $pageProperties->showHeader();
$showFooter = $pageProperties->showFooter();
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <?php if ($faviconPath) : ?>
        <link href="<?php echo $faviconPath; ?>" rel="icon" type="image/x-icon" />
    <?php endif; ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta data-intl-tel-input-cdn-path="<?php echo $templateUrl; ?>/scripts/intlTelInput/" />
    
    
    <?php echo CoreStatements::head(); ?>
    <meta name="theme-color" content="#8cbcc6">
    <link rel="stylesheet" href="<?php echo $templateUrl; ?>/css/default.css" media="screen" type="text/css" />
    <?php if($this->view->isFrontEditing()) : ?>
        <link rel="stylesheet" href="<?php echo $templateUrl; ?>/css/frontediting.css" media="screen" type="text/css" />
    <?php endif; ?>
    <link rel="stylesheet" href="<?php echo $templateUrl; ?>/css/template.css" media="screen" type="text/css" />
    <link rel="stylesheet" href="<?php echo $templateUrl; ?>/css/media.css" id="theme-media-css" media="screen" type="text/css" />
    <?php if (isset($document->localFontsFile)) : ?><link rel="stylesheet" href="<?php echo $templateUrl; ?>/css/<?php echo $document->localFontsFile; ?>" media="screen" type="text/css" /><?php else : ?><?php endif; ?><link id="u-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i|Open+Sans:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i|Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i">
    <?php include_once "$indexDir/styles.php"; ?>
    <?php if ($this->params->get('jquery', '0') == '1') : ?>
        <script src="<?php echo $templateUrl; ?>/scripts/jquery.js"></script>
    <?php endif; ?>
    <script src="<?php echo $templateUrl; ?>/scripts/script.js"></script>
    <?php echo getProductsScript(); ?>
    
    <?php if ($this->params->get('jsonld', '0') == '1') : ?>
    <script type="application/ld+json">
{
	"@context": "http://schema.org",
	"@type": "Organization",
	"name": "<?php echo $config->get('sitename'); ?>",
	"sameAs": [
		"https://facebook.com/name",
		"https://twitter.com/name",
		"https://instagram.com/name"
	],
	"url": "<?php echo JUri::getInstance()->toString(); ?>",
	"logo": "<?php echo $defaultLogo['src']; ?>"
}
</script>
    <?php
    if ($currentUrl == Uri::base()) {
    ?>
        <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "WebSite",
      "name": "<?php echo $config->get('sitename'); ?>",
      "potentialAction": {
        "@type": "SearchAction",
        "target": "<?php echo JUri::base() . 'index.php?searchword={query' . '}&option=com_search'; ?>",
        "query-input": "required name=query"
      },
      "url": "<?php echo $currentUrl; ?>"
    }
    </script>
    <?php } ?>
    <?php endif; ?>
    <?php if ($this->params->get('metatags', '0') == '1') : ?>
        <?php
        renderSeoTags($document->seoTags);
        ?>
    <?php endif; ?>
    
    
    
</head>
<body <?php echo $bodyClass . $bodyStyle; ?>>

<?php
if ($showHeader) {
    $this->view->renderHeader($indexDir, $this->params);
}
?>
<?php $this->view->renderLayout(); ?>
<?php
if ($showFooter) {
    $this->view->renderFooter($indexDir, $this->params);
}
?>
<section class="u-backlink u-clearfix u-grey-80">
            <a class="u-link" href="https://nicepage.com/joomla-templates" target="_blank">
        <span>Joomla Templates</span>
            </a>
        <p class="u-text"><span>created with</span></p>
        <a class="u-link" href="https://nicepage.com/joomla-page-builder" target="_blank"><span>Joomla Page Builder</span></a>.
    </section>

<?php echo $backToTop; ?>
<?php echo $popupDialogs; ?>
</body>
</html>
