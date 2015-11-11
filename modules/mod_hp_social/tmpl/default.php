<?php
/**
 * @package		Hanhphuc.vn
 * @subpackage	mod_hp_social
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined ( '_JEXEC' ) or die ();

$userGuest = JFactory::getUser ()->guest;
?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=492429447479171&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>



<div>

	<div class="fb-facepile" data-app-id="Hanhphuc.vn"
		data-href="https://www.facebook.com/pages/Congdonghanhphuc/1472058766383857"
		data-width="200" data-height="500" data-max-rows="5"
		data-colorscheme="light" data-size="medium" data-show-count="true"></div>

	<div class="clr"></div>
</div>
