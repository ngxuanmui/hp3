<?php
/**
 * @package                Joomla.Site
 * @subpackage	Templates.beez_20
 * @copyright        Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license                GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.filesystem.file');

//JHtml::_('behavior.framework', true);

// Remove generator
$this->setGenerator('');

// Remove Mootools
//$this->_script = $this->_scripts = array();

$doc = JFactory::getDocument();

$doc->addStyleSheet($this->baseurl.'/templates/system/css/system.css');
$doc->addStyleSheet($this->baseurl.'/templates/'.$this->template.'/css/layout.css', $type = 'text/css');
$doc->addStyleSheet($this->baseurl.'/templates/'.$this->template.'/css/styles.css', $type = 'text/css');
$doc->addScript(JURI::base() . 'media/hp/jquery-1.8.3.min.js');
$doc->addScript(JURI::base() . 'media/hp/jquery.validate.js');
$doc->addScript(JURI::base() . 'media/hp/hp_main.js');
$doc->addScript(JURI::base() . 'media/jquery.bxslider/jquery.bxslider.min.js');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
<head>
<jdoc:include type="head" />

<!--[if IE 7]>
<link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/ie7only.css" rel="stylesheet" type="text/css" />
<![endif]-->


<script type="text/javascript">
	jQuery.noConflict();

	var BASE_URL = '<?php echo JURI::base(); ?>';
</script>

</head>

<body>
	
	<div class="container">
		<div id="header">
			<a href="<?php echo JURI::base(); ?>" id="logo" class="icons fltlft" title="Hạnh Phúc"></a>
			<div id="header-right" class="fltrgt">
				<jdoc:include type="modules" name="top" />
			</div>
		</div>
		<div id="top-menu" class="relative">
			<jdoc:include type="modules" name="top-menu" />
		</div>
		
		<div class="clr"></div>
		
		<div id="top-sub-menu-container" class="relative">
			<jdoc:include type="modules" name="top-sub-menu" />
		</div>
		
		<div class="clr"></div>
		
		<div class="main clr">
			<div id="breadcrumbs">
				<jdoc:include type="modules" name="position-2" />
			</div>
			<div class="content">
				<jdoc:include type="message" />
				<jdoc:include type="component" />
			</div>
		</div>
		<div class="footer">
			<p>Thông tin bản quyền</p>
			<p>&copy; 2012 - Hanhphuc.vn</p>
		</div>
	</div>
	
	<a href="#0" class="cd-top">Top</a>
	
	<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/javascript/back_to_top/main.js"></script>
	
	<jdoc:include type="modules" name="debug" />
</body>
</html>
