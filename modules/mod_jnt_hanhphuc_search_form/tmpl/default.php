<?php

// no direct access
defined('_JEXEC') or die;

$categories = $list['categories'];
$provinces = $list['provinces'];

$jinput = JFactory::getApplication()->input;
?>

<script type="text/javascript">
<!--
jQuery(function($){
	var $p = $('#province');
	
	$p.change(function(){
		
		$('#district').html('Vui lòng chờ ...');

		var $t = $(this);
		
		$.post(
				'index.php?option=com_jnt_hanhphuc&view=get_district&format=raw&district=<?php echo $jinput->get('district'); ?>',
				{ 'id': $t.val() },
				function(res){
					$('#district').html(res);
				}
		);
	});

	if ($p.val() != '')
		$p.change();
});
//-->
</script>

<p class="search-text">TÌM KIẾM DỊCH VỤ CƯỚI</p>

<div class="line-break-search">
	<span></span>
</div>

<form id="frm-search-service" method="get" action="<?php echo JRoute::_('index.php?Itemid=324'); ?>">
	<input type="hidden" name="option" value="com_jnt_hanhphuc" />
	<input type="hidden" name="view" value="search" />
		
	<p>
		Chú ý: <span>Chọn một trong các lựa chọn bên dưới rồi nhấn vào Tìm
			kiếm để tìm kiếm dịch vụ.</span>
	</p>
	<div>
		<select name="catid">
			<option value="">Chọn dịch vụ</option>
			<?php foreach ($categories as $cat): ?>
			<option value="<?php echo $cat->id; ?>" <?php if ($jinput->get('catid') == $cat->id) echo 'selected'; ?>><?php echo $cat->title; ?></option>
				<?php foreach ($cat->subCategories as $subCat): ?>
			<option value="<?php echo $subCat->id; ?>" <?php if ($jinput->get('catid') == $subCat->id) echo 'selected'; ?>>&nbsp; &nbsp; <?php echo $subCat->title; ?></option>
				<?php endforeach; ?>
			<?php endforeach; ?>
		</select>
		<select name="province" id="province">
			<option value="">Lựa chọn Tỉnh / Thành</option>
			<?php foreach ($provinces as $key => $val): ?>
			<option value="<?php echo $key; ?>" <?php if ($jinput->get('province') == $val->id) echo 'selected'; ?>><?php echo $val->title; ?></option>
			<?php endforeach; ?>
		</select>
		<span id="district">
			<select name="district">
				<option value="">Chọn Quận / Huyện</option>
			</select>
		</span>
	</div>

	<div>
		<input type="text" placeholder="Gõ tên nhà cung cấp dịch vụ" name="search" value="<?php echo $jinput->getString('search', ''); ?>">
		
		<button type="submit">Tìm kiếm dịch vụ</button>
	</div>

</form>