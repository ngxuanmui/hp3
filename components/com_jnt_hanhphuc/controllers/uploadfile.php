<?php

defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

class Jnt_HanhphucControllerUploadFile extends JController 
{
    public function handle()
    {
		// required upload handler helper
		require_once JPATH_COMPONENT_ADMINISTRATOR . DS . 'helpers' . DS . 'uploadhandler.php';

		$userId = JFactory::getUser()->id;

		$session = JFactory::getSession();
		$sessionId = $session->getId();

		// make dir
		$tmpImagesDir = JPATH_ROOT . DS . 'tmp' . DS . $userId . DS . $sessionId . DS;
		$tmpUrl = 'tmp/'.$userId.'/'.$sessionId.'/';

		// unlink before create
		@unlink($tmpImagesDir);
		
		// create folder
		@mkdir($tmpImagesDir, 0777, true);

		$uploadOptions = array(	'upload_dir' => $tmpImagesDir, 
					'upload_url' => $tmpUrl, 
					'script_url' => JRoute::_('index.php?option=com_ntrip&task=uploadfile.handle', false)
					);

		$uploadHandler = new UploadHandler($uploadOptions, false);

	//	$session->set('files', null);

		$files = $session->get('files', array());

		if ($session->get('request_method') == 'delete')
		{
			$fileDelete = $uploadHandler->delete(false);

			// search file
			$key = array_search($fileDelete, $files);

			// unset in $files
			unset($files[$key]);

			$session->set('files', $files);
			$session->set('request_method', null);

			exit();
		}

		if ($_POST)
		{
			$file = $uploadHandler->post();

		$files[] = $file;

		$session->set('files', $files);
		}


		exit();
    }
    
    public function close()
    {
		$session = JFactory::getSession();

		$files = $session->get('files');

//		print_r($files);

		if (!empty($files))
		{
			foreach ($files as & $file)
			{
					
				$file['files'][0]->url = JURI::root() . $file['files'][0]->url;
				$file['files'][0]->thumbnail_url = JURI::root() . $file['files'][0]->thumbnail_url;
			}
		}
		
		echo json_encode($files);

		$session->set('files', null);

		exit();
    }
}