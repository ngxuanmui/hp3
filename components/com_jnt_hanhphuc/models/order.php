<?php

class Jnt_HanhphucModelOrder extends JModelLegacy
{
    public function confirmDelivered($post)
    {
	$db = JFactory::getDbo();
	$query = $db->getQuery(true);
	
	$delivered = array();
	
	if (!empty($post['delivered']))
	    $delivered = $post['delivered'];
	
	foreach ($delivered as $d)
	{
	    $query->clear();
	    
	    $query->update('#__hp_order_items')
		    ->set('delivered = 1')
		    ->where('id = ' . $d)
		    ->where('business_id = ' . JFactory::getUser()->id);
	    
	    $db->setQuery($query);
	    $db->query();
	    
	    if ($db->getErrorMsg())
		die ($db->getErrorMsg ());
	}
	
	// Upload file
	$jFileInput = new JInput($_FILES);
	$file = $jFileInput->get('jform', array(), 'array');
	
	$filepath = JPATH_ROOT . DS . 'upload' . DS . 'orders' . DS . $post['order_id'] . DS;
	
	@mkdir($filepath, 0777, true);
	
	$uploadResult = false;
	
	if (!empty($file['name']['file_upload']))
	    $uploadResult = JFile::upload( $file['tmp_name']['file_upload'], $filepath . $file['name']['file_upload'] );
	
	if ($uploadResult)
	{
	    // Update to files
	    $fileName = $file['name']['file_upload'];
	    
	    $query->clear()
		    ->insert('#__files')
		    ->columns('item_id, item_type, file_upload, description, created')
		    ->values($post['order_id'] . ', "order", ' . $db->quote($fileName) . ', ' . $db->quote($post['description']) . ', ' . $db->quote(date('Y-m-d H:i:s')))
	    ;
	    
	    $db->setQuery($query);
	    $db->query();
	    
	    if ($db->getErrorMsg())
		die ($db->getErrorMsg());
	}
	
	// Update note
	$note = trim($post['business_note']);
	
	if (!empty($note))
	{
	    $query->clear()
		    ->insert('#__hp_order_notes')
		    ->columns('order_id, business_id, note, created')
		    ->values($post['order_id'] . ',' . JFactory::getUser()->id . ',' . $db->quote($note) . ',' . $db->quote(date('Y-m-d H:i:s')))
	    ;
	    
	    $db->setQuery($query);
	    $db->query();
	    
	    if ($db->getErrorMsg())
		die ($db->getErrorMsg());
	}
	
	return true;
    }
}