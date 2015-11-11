<?php
/**
 * @version		$Id: default.php 21020 2011-03-27 06:52:01Z infograf768 $
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.DS.'helpers');

// $paymentMethods = FrontJntHanhphucHelper::getPaymentMethods();

// var_dump($paymentMethods->get('payment_method_1'));

// Create shortcuts to some parameters.
?>

<?php
/**
 * @version		$Id: default.php 21020 2011-03-27 06:52:01Z infograf768 $
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.DS.'helpers');

?>

<script type="text/javascript">
<!--
jQuery(function(){
	jQuery("#frm_shipping").validate(
			{
				messages: {
					'address[address]': "Vui lòng nhập vào địa chỉ",
					'address[city]': "Vui lòng chọn Tỉnh/Thành phố",
					'address[district]': "Vui lòng chọn Quận/Huyện",
					'address[mobile]': "Vui lòng nhập vào Điện thoại"
				}
			}
	);

	jQuery("#address_city").change(function(){
        value = jQuery(this).val();
        jQuery.get(
        	BASE_URL + 'index.php?option=com_jnt_hanhphuc&task=location.getLocations&type=district&parent_column=province_id&parent='+value, 
        	function(data){
                $input = "";
                jQuery(data).each(function(index, element){
                    $input += "<option value=\""+element.value+"\">";
                    $input += element.text;
                    $input += "</option>";
                });
                jQuery("#address_district").html($input);
            }, 
            "json"
        );
    });
});
//-->
</script>


<div class="container">
    <div class="float-left left-side">
		<div class="sub-container list-services shopping-cart relative">
			<h2>Thông tin giỏ hàng</h2>
			
			<div>
		    	<?php
		    	$items = $this->order->items;
		    	if($items):
		    	?>
		    	<table class="gridtable" width="650">
		    		<thead>
		    			<tr>
			    			<th>Dịch vụ</th>
			    			<th>Doanh nghiệp cung cấp</th>
			    			<th width="50" nowrap="nowrap">Số lượng</th>
			    			<th width="120">Giá</th>
		    			</tr>
		    		</thead>
		    		<tbody>
			    	<?php foreach($items as $item): ?>
			    		<tr>
			    			<td><?php echo $item->name?></td>
			    			<td><?php echo $item->businessProfile->business_name?></td>
			    			<td class="txt-right"><?php echo $item->qty?></td>
			    			<td class="txt-right"><?php echo $item->current_price?></td>
			    		</tr>
			    	<?php endforeach;?>
		    		</tbody>
		    	</table>
		    	<?php else:?>
		    		<p>Bạn chưa có sản phẩm nào trong giỏ hàng</p>
		    	<?php endif;?>
		    </div>
		    <div>
		    	<?php if($this->order->price > 0):?>
		    		Tổng giá: <?php echo $this->order->price?>
		    	<?php endif;?>
		    </div>
		    
		    <div class="clr"></div>
		    
		    <div>
		    	<h2>Địa chỉ nhận hàng:</h2>
		    	<form id="frm_shipping" class="frm-shipping form-validate" action="<?php echo JRoute::_('index.php?option=com_jnt_hanhphuc&task=order.shippingInfoSubmit')?>" method="post">
		    		<input type="hidden" name="option" value="com_jnt_hanhphuc"/>
		    		<input type="hidden" name="task" value="order.shippingInfoSubmit"/>
		    		
		    		<ul>
		    			<li>
		    				<label for="address_address">Địa chỉ:</label>
		    				<input id="address_address" type="text" name="address[address]" required />
		    			</li>
		    			
		    			<li>
		    				<label for="address_city">Tỉnh/Thành Phố:</label>
		    				<select id="address_city" name="address[city]" required>
		    					<option value="">- Lựa chọn -</option>
		    					<?php foreach ($this->provinces as $p): ?>
		    					<option value="<?php echo $p->id; ?>"><?php echo $p->title; ?></option>
		    					<?php endforeach; ?>
		    				</select>
		    			</li>
		    			
		    			<li>
		    				<label for="address_district">Quận/Huyện:</label>
		    				<select id="address_district" name="address[district]" required>
		    					<option value="">- Lựa chọn -</option>
		    				</select>
		    			</li>
		    			
		    			<li>
		    				<label for="address_email">Email:</label>
		    				<input id="address_email" type="text" name="address[email]"/>
		    			</li>
		    			
		    			<li>
		    				<label for="address_mobile">Điện thoại:</label>
		    				<input id="address_mobile" type="text" name="address[mobile]" required />
		    			</li>
		    			
		    			<li>
		    				<label>&nbsp;</label>
		    				<input class="button" type="submit" value="Tiếp tục thanh toán"/>
		    			</li>
		    		</ul>
		    		
		    		
		    	</form>
		    </div>
		</div>
	</div>
	<div class="float-right right-side">
		<?php echo JEUtil::loadModule('right', 'module-padding'); ?>
    </div>
</div>

<div class="clr"></div>
