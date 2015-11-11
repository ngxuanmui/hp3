<?php

class Hp_CommentControllerComment extends JControllerLegacy
{
	public function post()
	{
//		if (JFactory::getUser()->guest)
//		{
//			echo 'USER_NOT_LOGIN';
//			exit();
//		}
		
		$itemId		= JRequest::getInt('item_id');
		$itemType	= JRequest::getString('item_type');
		$parentId	= JRequest::getInt('parent_id');
		$content	= JRequest::getString('content');
		
		$guest = array();
		
		$guest['fullname'] = JRequest::getString('guest_fullname');
		$guest['email'] = JRequest::getString('guest_email');
		$guest['website'] = JRequest::getString('guest_website');
		
		$model = $this->getModel('Comment', 'Hp_CommentModel');
		
		$saveResult = $model->save($itemId, $itemType, $parentId, $content, $guest);
		
		if (is_array($saveResult) && $saveResult['error'] == 1)
			echo 'Error: ' . $saveResult['msg'];
		else
			echo 'OK';
		
		exit();
	}
}