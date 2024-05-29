<?php
/**
 * @package   Nicepage Website Builder
 * @author    Nicepage https://www.nicepage.com
 * @copyright Copyright (c) 2016 - 2019 Nicepage
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */

namespace NP\Builder;

defined('_JEXEC') or die;

use \JURI;
/**
 * Class ProductDataBuilder
 */
class SiteProductDataBuilder extends DataBuilder
{
    private $_item;
    private $_data;

    /**
     * ProductDataBuilder constructor.
     *
     * @param object $item Article object
     */
    public function __construct($item)
    {
        $this->_item = $item;
        $base = array(
            'product-title' => $this->title(),
            'product-title-link' => $this->titleLink(),
            'product-desc' => $this->content(),
            'product-image' => $this->image(),
            'product-gallery' => $this->gallery(),
            'product-variations' => $this->variations(),
            'product-tabs' => $this->tabs(),
            'product-json' => $this->getJson(),
            'product-id' => $this->getId(),
        );
        $this->_data = array_merge($base, $this->quantity(), $this->button(), $this->price());
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_item->id;
    }

    /**
     * @return string
     */
    public function getJson()
    {
        return htmlspecialchars(json_encode($this->_item));
    }

    /**
     * Get product data
     *
     * @return array
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * Get product title
     *
     * @return mixed
     */
    public function title()
    {
        return $this->_item->title;
    }

    /**
     * Get product content
     *
     * @return false|string|string[]|null
     */
    public function content()
    {
        $desc = $this->_item->description;
        return $this->excerpt($desc, 150, '...', true);
    }

    /**
     * Get product title link
     *
     * @return string
     */
    public function titleLink()
    {
        return JURI::root() . 'index.php?option=com_nicepage&view=product&page_id=[[pageId]]&product_name=product-' . $this->_item->id . '"';
    }

    /**
     * Get product image
     *
     * @return string
     */
    public function image()
    {
        $imageSource = '';
        if (property_exists($this->_item, 'images') && count($this->_item->images) > 0) {
            $imageSource = str_replace('[[site_path_editor]]', JURI::root(true), $this->_item->images[0]->url);
        }
        return $imageSource;
    }

    /**
     * Get product gallery
     *
     * @return array
     */
    public function gallery()
    {
        $images = array();
        if (property_exists($this->_item, 'images')) {
            for ($i = 0; $i < count($this->_item->images); $i++) {
                $url = str_replace('[[site_path_editor]]', JURI::root(true), $this->_item->images[$i]->url);
                array_push($images, $url);
            }
        }
        return $images;
    }

    /**
     * Get product quantity
     *
     * @return array
     */
    public function quantity()
    {
        return array('product-quantity-notify' => '', 'product-quantity-label' => '', 'product-quantity-html' => '');
    }

    /**
     * Get product button
     *
     * @return array
     */
    public function button()
    {
        return array('product-button-text' => 'product-template', 'product-button-link' => $this->titleLink(), 'product-button-html' => '');
    }

    /**
     * Get product price
     *
     * @return array
     */
    public function price()
    {
        if (property_exists($this->_item, 'fullPrice')) {
            $price = $this->_item->fullPrice;
        } else {
            $price = $this->_item->price;
        }
        $price = str_replace('$', '_dollar_symbol_', $price);
        return array(
            'product-price' => $price,
            'product-old-price' => '',
        );
    }

    /**
     * Get product variations
     *
     * @return array
     */
    public function variations()
    {
        $variations = array();
        return $variations;
    }

    /**
     * Get product tabs
     *
     * @return array
     */
    public function tabs() {
        $tabs = array();
        return $tabs;
    }
}
