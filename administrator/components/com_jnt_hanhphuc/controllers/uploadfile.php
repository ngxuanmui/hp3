<?php
defined ( '_JEXEC' ) or die ();

jimport ( 'joomla.application.component.controller' );

class Jnt_HanhphucControllerUploadFile extends JController {
	public function handle() {
		// required upload handler helper
		require_once JPATH_COMPONENT_ADMINISTRATOR . DS . 'helpers' . DS . 'uploadhandler.php';
		
		$userId = JFactory::getUser ()->id;
		
		$session = JFactory::getSession ();
		$sessionId = $session->getId ();
		
		// make dir
		$tmpImagesDir = JPATH_ROOT . DS . 'tmp' . DS . $userId . DS . $sessionId . DS;
		$tmpUrl = JURI::root () . 'tmp/' . $userId . '/' . $sessionId . '/';
		
		@mkdir ( $tmpImagesDir, 0777, true );
		
		$uploadOptions = array (
				'upload_dir' => $tmpImagesDir,
				'upload_url' => $tmpUrl,
				'script_url' => JRoute::_ ( 'index.php?option=com_jnt_hanhphuc&task=uploadfile.handle', false ) 
		);
		
		$uploadHandler = new UploadHandler ( $uploadOptions, false );
		
		// $session->set('files', null);
		
		$files = $session->get ( 'files', array () );
		
		if ($session->get ( 'request_method' ) == 'delete') {
			$fileDelete = $uploadHandler->delete ( false );
			
			// search file
			$key = array_search ( $fileDelete, $files );
			
			// unset in $files
			unset ( $files [$key] );
			
			$session->set ( 'files', $files );
			$session->set ( 'request_method', null );
			
			exit ();
		}
		
		if ($_POST) {
			$file = $uploadHandler->post ();
			
			$files [] = $file;
			
			$session->set ( 'files', $files );
		}
		
		exit ();
	}
	public function close() {
		$session = JFactory::getSession ();
		
		$files = $session->get ( 'files' );
		
		echo json_encode ( $files );
		
		$session->set ( 'files', null );
		
		exit ();
	}
}