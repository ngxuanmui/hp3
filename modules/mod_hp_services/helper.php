<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_banners
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class modHP_ServicesHelper
{
	public static function &getListServices(&$params) {
        $return = array();
        $db = JFactory::getDbo();

        $cats = $params->get('catid', '');
        if(!empty($cats) && is_array($cats)) {
//            $cats = implode(', ', $cats);
            foreach($cats as $key => $cat) {
                $query = $db->getQuery(true);
                $query->select('s.*')
                    ->select('c.id as cat_id')
                    ->select('c.title as cat_title')
                    ->select('c.alias as cat_alias')
                    ->select('c.description as cat_description')
                    ->select('b.business_name as business_name')
                    ->from('#__hp_business_service s')
                    ->innerJoin('#__categories c ON s.category = c.id AND c.extension = \'com_jnt_hanhphuc\'')
                    ->join('LEFT', '#__hp_business_profile b ON b.user_id = s.business_id')
                    ->where('c.id = '.(int)$cat.'')
                    ->order('s.created desc');
                $db->setQuery($query, 0, 3);
                //var_dump($query->__toString());
                $objects = $db->loadObjectList();
                if(!empty($objects)) {
                    foreach($objects as $obj) {
                        if(empty($return[$obj->cat_id])){
                            $return[$obj->cat_id] = new stdClass();
                            $return[$obj->cat_id]->id = $obj->cat_id;
                            $return[$obj->cat_id]->title = $obj->cat_title;
                            $return[$obj->cat_id]->alias = $obj->cat_alias;
                            $return[$obj->cat_id]->services = array();
                        }
                        array_push($return[$obj->cat_id]->services, $obj);
                    }
                }
            }
        }
		return $return;
	}
}
