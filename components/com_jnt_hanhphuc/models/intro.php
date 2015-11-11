<?php
/**
 * @version		$Id: article.php 20810 2011-02-21 20:01:22Z dextercowley $
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.modelform');

/**
 * Content Component Article Model
 *
 * @package		Joomla.Site
 * @subpackage	com_content
 * @since 1.5
 */
class Jnt_HanhPhucModelIntro extends JModelForm {
    
    protected $data = null;
    
    public function getForm($data = array(), $loadData = true) {
        // Get the form.
		$form = $this->loadForm('com_jnt_hanhphuc.intro', 'intro', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}
        
        if(!$form->getValue('business_id')) {
            $form->setValue('business_id', null, JFactory::getUser()->id);
        }

		return $form;
    }
    
    /**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData()
	{
		return $this->getData();
	}
    
    public function getData($businessId = 0) {
        if($this->data) {
           return $this->data; 
        }
        
//         if(!$businessId) $businessId = JRequest::getInt('bid', 0);

        if(!$businessId)
        {
        	//         	$businessId = JRequest::getInt('bid', 0);
        
        	$businessId = JFactory::getUser()->id;
        }
        
        $db = JFactory::getDbo();
        $query = "SELECT * FROM #__hp_business_info WHERE business_id = '$businessId'";
        $db->setQuery($query);
        $this->data = $db->loadObject();
        
        return $this->data;
    }
    
    public function getBusinessInfo($businessId = 0) {
        if(!$businessId) 
        {
//         	$businessId = JRequest::getInt('bid', 0);

        	$businessId = JFactory::getUser()->id;
        }
        
        //Load from tbl user
        $businessInfo = JFactory::getUser($businessId);
        
        //Load profile
        $db = JFactory::getDbo();
//        $db->setQuery(
//            'SELECT profile_key, profile_value FROM #__user_profiles' .
//            ' WHERE user_id = '.(int) $businessId." AND profile_key LIKE 'profile.%'" .
//            ' ORDER BY ordering'
//        );
		
		$query = $db->getQuery(true);
		$query->select('*')->from('#__hp_business_profile p')->where('p.user_id = ' . $businessId);
		
		$query->select('n.nick_yahoo, n.nick_skype, n.nick_fb, n.nick_yahoo_alias, n.nick_skype_alias, n.nick_fb_alias');
		$query->join('LEFT', '#__hp_business_nicks n ON p.user_id = n.user_id');

		// join over location: province
		$query->select('province.title AS province_title')
		->join('INNER', '#__location_province province ON p.business_city = province.id')
		;
		
		// join over location: district
		$query->select('ward.title AS ward_title')
		->join('INNER', '#__location_ward ward ON p.business_district = ward.id')
		;
		
		$db->setQuery($query);
//        $results = $db->loadRowList();
		
		$result = $db->loadObject();

//        // Merge the profile data.
//        $profile = new stdClass();
//
//        foreach ($results as $v) {
//            $k = str_replace('profile.', '', $v[0]);
//            //$data->profile[$k] = $v[1];
//            $profile->$k = $v[1];
//        }
        $businessInfo->profile = $result;
        
        return $businessInfo;
    }
    
    public function getTable($name = 'Intro', $prefix = 'Jnt_HanhPhucTable', $options = array()) {
        parent::getTable($name, $prefix, $options);
    }
    
    /**
	 * Method to save the form data.
	 *
	 * @param	array		The form data.
	 * @return	mixed		The user id on success, false on failure.
	 * @since	1.6
	 */
	public function save($data) {
		$user = new JUser();
        
        //make object
        $info = new stdClass();
        
        foreach($data as $key => $value) {
            $info->$key = $value;
        }
        
        $db = JFactory::getDbo();
        
        if($info->id == 0) {
            $update = $db->insertObject('#__hp_business_info', $info);
        } else {
            $update = $db->updateObject('#__hp_business_info', $info, 'id');
        }
        
        if ($update)
        {
        	if ($info->id == 0)
        		$id = $db->insertid();
        	else
        		$id = $info->id;
        	
        	$info->id = $id;
        	
        	// update content
        	$content = $this->copyFilesOnSave($info->content, $info->id);
        	 
        	if ($content)
        		$info->content = $content;
        	
        	$update = $db->updateObject('#__hp_business_info', $info, 'id');
        }
    }
    
    private function copyFilesOnSave($content = '', $itemId = 0)
    {
    	if(!$content || !$itemId)
    		return false;
    
    	$date = date('Y') . DS . date('m') . DS . date('d');
    
    	$dest = JPATH_ROOT . DS . 'images' . DS . 'jnt_hanhphuc' . DS . 'intros' . DS . $itemId . DS;
    	@mkdir($dest, 0777, true);
    
    	$doc=new DOMDocument();
    
    	$doc->loadHTML($content);
    
    	// just to make xpath more simple
    	$xml=simplexml_import_dom($doc);
    
    	$images=$xml->xpath('//img');
    
    	$tmpSearch = array();
    	$tmpReplace = array();
    
    	foreach ($images as $img)
    	{
    		// Explode src to get file name
    		$imgSrc = explode('/', $img['src']);
    			
    		// Search & Replace
    		$tmpSearch[] = $img['src'];
    		$tmpReplace[] = 'images/jnt_hanhphuc/intros/' . $itemId . '/' . end($imgSrc);
    
    		$src = str_replace('/', DS, JPATH_ROOT.'/'.$img['src']);
    
    		if($imgSrc[0] == 'tmp')
    			JFile::copy($src, $dest.end($imgSrc));
    	}
    
    	$content = str_replace($tmpSearch, $tmpReplace, $content);
    
    	return $content;
    }
}
