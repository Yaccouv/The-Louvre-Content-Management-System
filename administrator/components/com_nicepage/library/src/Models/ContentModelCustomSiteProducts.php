<?php
/**
 * @package   Nicepage Website Builder
 * @author    Nicepage https://www.nicepage.com
 * @copyright Copyright (c) 2016 - 2019 Nicepage
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */

namespace NP\Models;

defined('_JEXEC') or die;

use NP\Builder\SiteProductDataBuilder;

class ContentModelCustomSiteProducts
{
    private $_options;

    /**
     * ContentModelCustomProducts constructor.
     *
     * @param array $options options
     */
    public function __construct($options = array())
    {
        $this->_options = $options;
    }

    /**
     * Get products
     *
     * @return array
     */
    public function getProducts() {
        $products = array();

        $items = null;
        if (isset($this->_options['siteProduct']) && $this->_options['siteProduct']) {
            $items = array($this->_options['siteProduct']);
        }

        if (isset($this->_options['siteProducts']) && $this->_options['siteProducts']) {
            $items = $this->_options['siteProducts'];
        }

        if (empty($items)) {
            return $products;
        }

        foreach ($items as $item) {
            $builder = new SiteProductDataBuilder($item);
            $product = $builder->getData();
            array_push($products, $product);
        }

        return $products;
    }
}
