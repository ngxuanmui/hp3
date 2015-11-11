<?php

class Jnt_HanhphucModelGet_District extends JModelLegacy
{
	public function getItems()
	{
		// get district
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
	
		$provinceId = JRequest::getInt('id');
	
		$query->select('*')->from('#__location_district')->where('province_id = ' . $provinceId)->where('state = 1');
		$db->setQuery($query);
	
		$rs = $db->loadObjectList('id');
	
		if ($db->getErrorMsg())
			die ($db->getErrorMsg());
	
		return $rs;
	}
}