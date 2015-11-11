<?php
$jinput = JFactory::getApplication()->input;

$district = $jinput->getInt('district', 0);
?>

<select name="district">
	<option value="">Chọn Quận / Huyện</option>
	<?php foreach ($this->items as $item): ?>
	<option value="<?php echo $item->id; ?>" <?php if ($district == $item->id) echo 'selected'; ?>><?php echo $item->title; ?></option>
	<?php endforeach; ?>
</select>