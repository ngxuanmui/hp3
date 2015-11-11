<?php
/**
 * @package                Joomla.Site
 * @subpackage	Templates.beez_20
 * @copyright        Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license                GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined ( '_JEXEC' ) or die ();

jimport ( 'joomla.filesystem.file' );

// JHtml::_('behavior.framework', true);

// Remove generator
$this->setGenerator ( '' );

// Remove Mootools
// $this->_script = $this->_scripts = array();

$doc = JFactory::getDocument ();

$doc->addStyleSheet($this->baseurl.'/templates/'.$this->template.'/css/jui/bootstrap.min.css');

// $doc->addStyleSheet($this->baseurl.'/templates/system/css/system.css');
// $doc->addStyleSheet($this->baseurl.'/templates/'.$this->template.'/css/layout.css', $type = 'text/css');
// $doc->addStyleSheet($this->baseurl.'/templates/'.$this->template.'/css/styles.css', $type = 'text/css');


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
	xml:lang="<?php echo $this->language; ?>"
	lang="<?php echo $this->language; ?>"
	dir="<?php echo $this->direction; ?>">
<head>
<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">


<jdoc:include type="head" />

	<!--[if IE 7]>
<link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/ie7only.css" rel="stylesheet" type="text/css" />
<![endif]-->


	<link rel="stylesheet"
		href="<?php echo $this->baseurl.'/templates/'.$this->template.'/css/template.css'; ?>">

		<script type="text/javascript">
	jQuery.noConflict();

	var BASE_URL = '<?php echo JURI::base(); ?>';
</script>


</head>

<body>

	<div class="container">
		<div class="row">
	
			<div class="col-xs-4 col-md-3">
				<a href="<?php echo JURI::base(); ?>" title="Hạnh Phúc"> <img
					src="<?php echo JUri::base(true); ?>/templates/hp3/images/hanhphuc-logo.png"
					class="img-responsive" />
				</a>
			</div>
			
			<div class="col-xs-14 col-md-9 hidden-xs">
				<jdoc:include type="modules" name="top" />
			</div>
		</div>
		
		<nav class="navbar">
			
				<div class="navbar-header">
					<div class="navbar-toggle collapsed" style="float: none;">
						<div class="pull-left">
							<input type="text" placeholder="Tìm kiếm ..."></input>
						</div>
						<button class="pull-right" data-toggle="collapse"
							data-target="#navbar" aria-expanded="false" aria-controls="navbar">
							Show Menu</button>
					</div>
				</div>
				<div id="navbar" class="navbar-collapse collapse">
					<jdoc:include type="modules" name="top-menu" />
				</div>
		</nav>

		<div id="top-sub-menu-container" class="relative">
			<jdoc:include type="modules" name="top-sub-menu" />
		</div>
		
		<div id="breadcrumbs">
			<jdoc:include type="modules" name="position-2" />
		</div>
		
		<div id="main-content">
			<jdoc:include type="message" />
			<jdoc:include type="component" />
		</div>
		
		
	</div>
	
	<div class="container footer">
			<p>Thông tin bản quyền</p>
			<p>&copy; 2012 - Hanhphuc.vn</p>
		</div>

	<a href="#0" class="cd-top">Top</a>

	<script
		src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/javascript/back_to_top/main.js"></script>

	<script
		src="<?php echo $this->baseurl ?>/media/jquery.bxslider/jquery.bxslider.min.js"></script>
		<!-- Latest compiled and minified JavaScript -->
		
		<jdoc:include type="modules" name="debug" />

</body>
</html>
