<?php

class Hp_CommentModelComment extends JModelLegacy
{
	public function getListComments($itemId, $itemType, $title = '')
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		$query->select('c.*')
				->select('(SELECT COUNT(id) FROM #__hp_comments WHERE item_type = "'.$itemType.'" AND item_id = '.(int) $itemId.') AS count_comment')
				->from('#__hp_comments c')
				->select('u.username')
				->join('LEFT', '#__users u ON c.created_by = u.id')
				->where('c.item_type = ' . $db->quote($itemType))
				->where('c.item_id = ' . $itemId)
				->where('c.parent_id = 0')
				->where('c.state = 1')
				->order('c.id ASC')
			;
// 		echo $query->dump();
// 		echo str_replace('#__', 'jos_', $query);
		
		$db->setQuery($query);
		$rs = $db->loadObjectList();
		
		if ($db->getErrorMsg())
			die ($db->getErrorMsg());
		
		// load sub comment
		foreach ($rs as & $comment)
		{
			$query->clear()
					->select('c.*, ' . $db->quote($title) . ' AS item_title')
					->from('#__hp_comments c')
					->select('u.username')
					->join('LEFT', '#__users u ON c.created_by = u.id')
// 					->where('c.item_type = ' . $db->quote($itemType))
// 					->where('c.item_id = ' . $itemId)
					->where('c.parent_id = ' . $comment->id)
// 					->where('c.state = 1')
					->order('c.id ASC')
				;
			
			$db->setQuery($query);
			$comment->subComments = $db->loadObjectList();
		}
		
		return $rs;
	}

	public function save($itemId, $itemType, $parentId, $content, $guest = array())
	{
		$obj = new JObject();
		
		$user = JFactory::getUser();
		
		$obj->parent_id = $parentId;
		$obj->item_id	= $itemId;
		$obj->item_type = $itemType;
		$obj->content	= $content;
		$obj->state		= 0;
		$obj->created	= date('Y-m-d H:i:s');
		$obj->created_by = $user->id;
		
		$user = JFactory::getUser();
		
		if ($user->guest)
		{
			$obj->guest_fullname = $guest['fullname'];
			$obj->guest_email = $guest['email'];
			$obj->guest_website = $guest['website'];
			
			$posterEmail = $guest['email'];
			$posterFullname = $guest['fullname'];
		}
		else
		{
			$posterEmail = $user->email;
			$posterFullname = $user->name;
		}
		
		$db = JFactory::getDbo();
		$result = $db->insertObject('#__hp_comments', $obj, 'id');
		
		if (!$result)
			return array('error' => 1, 'msg' => $db->getErrorMsg ());
		
		$commentId = $db->insertid();
		
		$owner = $this->getOwner($commentId);
		$adminInfo = $this->getAdminInfo();
		
		/* variables */
		$vars = array('fullname', 'content', 'created', 'created_by', 'owner');
		$values = array(
							'fullname' => $posterFullname,
							'content' => $content,
							'created' => $obj->created,
							'created_by' => $posterFullname,
							'owner' => $owner->username,
							'item_type' => $itemType,
							'item_title' => $owner->comment_for
					);
		
		$emailTemplate = new EmailTemplate();
		
		//TODO send email to poster
		$emailTemplate->getContent('comment_send_to_poster.php', $values);
		$emailTemplate->send($posterEmail);
		
		//TODO send email to owner
		$values['fullname'] = $owner->name;
		
		$emailTemplate->getContent('comment_send_to_owner.php', $values);
		$emailTemplate->send($owner->email);
		
		//TODO send email to amdin
		$values['fullname'] = $adminInfo->name;
		
		$emailTemplate->getContent('comment_send_to_admin.php', $values);
		$emailTemplate->send($adminInfo->email);
		
		return $result;
	}
	
	protected function getAdminInfo()
	{
		// Initialise variables.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
		
		$query->select('*')
				->from('#__users')
				->where('username = "admin"')
		;
		
		$db->setQuery($query);
		
		return $db->loadObject();
	}
	
	protected function getOwner($id)
	{
		// Initialise variables.
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);
		
		// Select the required fields from the table.
		$query->select('id');
		$query->from($db->quoteName('#__hp_comments').' AS a');
		
		// select title
		$strCase = ' CASE a.item_type';
		
		$strCase .= ' WHEN "user" THEN (SELECT username FROM #__users WHERE id = a.item_id)';
		$strCase .= ' WHEN "service" THEN (SELECT name FROM #__hp_business_service WHERE id = a.item_id)';
		$strCase .= ' WHEN "article" THEN (SELECT title FROM #__hp_business_content WHERE id = a.item_id)';
		$strCase .= ' WHEN "album" THEN (SELECT name FROM #__hp_albums WHERE id = a.item_id)';
		$strCase .= ' END AS comment_for';
		
		// select username
		$strCase = ' CASE a.item_type';
		$strCase .= ' WHEN "user" THEN (SELECT username FROM #__users WHERE id = a.item_id)';
		$strCase .= ' WHEN "service" THEN (SELECT username FROM #__users WHERE id = (SELECT created_by FROM #__hp_business_service WHERE id = a.item_id))';
		$strCase .= ' WHEN "article" THEN (SELECT username FROM #__users WHERE id = (SELECT created_by FROM #__hp_business_content WHERE id = a.item_id))';
		$strCase .= ' WHEN "album" THEN (SELECT username FROM #__users WHERE id = (SELECT created_by FROM #__hp_albums WHERE id = a.item_id))';
		$strCase .= ' END AS username';
		
		$query->select($strCase);
		
		// select name
		$strCase = ' CASE a.item_type';
		$strCase .= ' WHEN "user" THEN (SELECT name FROM #__users WHERE id = a.item_id)';
		$strCase .= ' WHEN "service" THEN (SELECT name FROM #__users WHERE id = (SELECT created_by FROM #__hp_business_service WHERE id = a.item_id))';
		$strCase .= ' WHEN "article" THEN (SELECT name FROM #__users WHERE id = (SELECT created_by FROM #__hp_business_content WHERE id = a.item_id))';
		$strCase .= ' WHEN "album" THEN (SELECT name FROM #__users WHERE id = (SELECT created_by FROM #__hp_albums WHERE id = a.item_id))';
		$strCase .= ' END AS name';
		
		// select email
		$strCase = ' CASE a.item_type';
		$strCase .= ' WHEN "user" THEN (SELECT email FROM #__users WHERE id = a.item_id)';
		$strCase .= ' WHEN "service" THEN (SELECT email FROM #__users WHERE id = (SELECT created_by FROM #__hp_business_service WHERE id = a.item_id))';
		$strCase .= ' WHEN "article" THEN (SELECT email FROM #__users WHERE id = (SELECT created_by FROM #__hp_business_content WHERE id = a.item_id))';
		$strCase .= ' WHEN "album" THEN (SELECT email FROM #__users WHERE id = (SELECT created_by FROM #__hp_albums WHERE id = a.item_id))';
		$strCase .= ' END AS email';
		
		$query->select($strCase);
		
		$query->where('id = ' . $id);
		
		$db->setQuery($query);
		
		return $db->loadObject();
	}
}