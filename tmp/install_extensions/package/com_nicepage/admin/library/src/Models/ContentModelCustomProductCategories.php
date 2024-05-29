<?php
/**
 * @package   Nicepage Website Builder
 * @author    Nicepage https://www.nicepage.com
 * @copyright Copyright (c) 2016 - 2019 Nicepage
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
 */

namespace NP\Models;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use \VmModel;

class ContentModelCustomProductCategories extends ContentModelVirtuemart
{
    /**
     * Constructor
     */
    public function __construct()
    {
        
    }

    /**
     * Get all categories
     *
     * @return array
     */
    public function getCategories() {
        $result = array();

        if (!$this->_vmInit()) {
            return $result;
        }

        $model = VmModel::getModel('category');
        $categories = $model->getCategoryTree('', 0, false, '', '', '', false, '');
        foreach ($categories as $category) {
            $categoryDate = $this->_getCategoryDate($category);
            $created = $categoryDate['created_on'] ? Factory::getDate($categoryDate['created_on'])->format('U') * 1000 : null;
            $updated = $categoryDate['modified_on'] ? Factory::getDate($categoryDate['modified_on'])->format('U') * 1000 : null;
            array_push(
                $result,
                array(
                    'categoryId' => $category->category_parent_id ?: null,
                    'id' => (string) $category->virtuemart_category_id,
                    'title' => $category->category_name,
                    'created' => $created,
                    'updated' => $updated,
                )
            );
        }
        return $result;
    }

    /**
     * Get date of category
     *
     * @param object $category Category
     *
     * @return mixed|null
     */
    private function _getCategoryDate($category)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true)
            ->select(
                [
                    $db->quoteName('created_on'),
                    $db->quoteName('modified_on'),
                ]
            )
            ->from($db->quoteName('#__virtuemart_categories'))
            ->where($db->quoteName('virtuemart_category_id') . ' = '. (int)$category->virtuemart_category_id);
        $db->setQuery($query);
        return $db->loadAssoc();
    }
}
