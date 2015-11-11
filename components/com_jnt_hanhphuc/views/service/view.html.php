<?php
/**
 * @version		$Id: view.html.php 21018 2011-03-25 17:30:03Z infograf768 $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * HTML Article View class for the Content component
 *
 * @package		Joomla.Site
 * @subpackage	com_content
 * @since		1.5
 */
class Jnt_HanhPhucViewService extends JView {
    protected $businessInfo;
    protected $serviceInfo;

	function display($tpl = null) {
		$bid = JRequest::getInt('bid', 0);
		$catId = JRequest::getInt('id', 0);
		
        // Get the view data.
        $introModel = JModel::getInstance('Intro','Jnt_HanhPhucModel');
        
        $this->serviceInfo = $this->get('ServiceInfo');
		
		$this->businessInfo = $introModel->getBusinessInfo($this->serviceInfo->business_id);
		
		$this->_prepareDocument();
        
		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 */
	protected function _prepareDocument()
	{
		$serviceInfo = $this->serviceInfo;
		
		$title = $serviceInfo->name . ' - ' . $serviceInfo->uname;
		
		$this->document->setTitle($title);
		
		if ($serviceInfo->metadesc)
		{
			$this->document->setDescription($serviceInfo->metadesc);
		}
		
		if ($serviceInfo->metakey)
		{
			$this->document->setMetadata('keywords', $serviceInfo->metakey);
		}
	}
}
