<?php
/**
 * @version		$Id: contact.php 20982 2011-03-17 16:12:00Z chdemko $
 * @package		Joomla.Site
 * @subpackage	Contact
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

class Jnt_HanhPhucControllerOrder extends JController 
{
    public function confirm_delivered()
    {
	$post = JRequest::get('post');
	
	$model = $this->getModel('Order');
	
	$saveResult = $model->confirmDelivered($post);
	
	if ($saveResult)
	{
	    $url = JRoute::_('index.php?option=com_jnt_hanhphuc&view=user_man_order_items&order_id=' . $post['order_id'], false);
	    
	    $this->setRedirect($url, 'Cập nhật thông tin thành công');
	    
	    return true;
	}
	
	die;
    }

    protected function isLoggedIn($task = '') {
		$user = JFactory::getUser();
		
		if($user->guest) {
			$returnURL = JRoute::_('index.php?option=com_jnt_hanhphuc&task=order.'.$task.(!empty($step) ? '&step='.$step : ''));
			$returnURL = base64_encode($returnURL);
			$this->setRedirect(JRoute::_('index.php?option=com_users&view=login&return='.$returnURL), 'Bạn cần login trước khi thanh toán!');
			return false;
		}
		return true;
	}
	public function checkout() {
		if(!$this->isLoggedIn('checkout')) return false;
		
		$this->setRedirect(JRoute::_('index.php?option=com_jnt_hanhphuc&view=cart_shipinfo'));
		return true;
	}
	
	public function shippingInfoSubmit() {
		if(!$this->isLoggedIn('shippingInfoSubmit')) return false;
		
		$session = JFactory::getSession();
		
		$shippingAddress = JRequest::getVar('address', array());
		$shippingAddress = (object)$shippingAddress;
		$session->set(SESSION_PAY_SHHIPPING_INFO_KEY, $shippingAddress);
		
		$this->setRedirect(JRoute::_('index.php?option=com_jnt_hanhphuc&view=cart_checkout'));
		return true;
	}
	
	public function choicePayMethodSubmit() {
		$payMethod = JRequest::getInt('payment_method', 0);
		if(!$payMethod) {
			$this->setRedirect(JRoute::_('index.php?option=com_jnt_hanhphuc&view=cart_checkout'));
			return false;
		}
		$session = JFactory::getSession();
		$session->set(SESSION_PAY_METHOD_KEY, $payMethod);
		
		$this->setRedirect(JRoute::_('index.php?option=com_jnt_hanhphuc&view=cart_confirm'));
		return true;
	}
	
	public function confirm() {
		
		if(!$this->isLoggedIn('confirm')) return false;
		
		//TODO: #nttuyen Luu tru hoa don vao day??
		$cartModel = $this->getModel('Cart', 'Jnt_HanhPhucModel');
		$order = $cartModel->getOrder();
		
		$user = JFactory::getUser();
		$db = JFactory::getDbo();
		
		$orderData = array();
		$orderData['user_id'] 				= $user->id;
		$orderData['username'] 				= $user->username;
		$orderData['total_price'] 			= $order->totalPrice;
		$orderData['price'] 				= $order->price;
		$orderData['payment_method'] 		= $order->payInfo->type;
		$orderData['payment_method_name'] 	= $order->payInfo->typeName;
		$orderData['payment_info']			= '';
		$orderData['order_note'] 			= '';
		$orderData['ipaddress'] 			= $_SERVER['REMOTE_ADDR'];
		$orderData['address'] 				= $order->shippingAddress->address;
		$orderData['city'] 					= $order->shippingAddress->city;
		$orderData['district'] 				= $order->shippingAddress->district;
		$orderData['phone'] 				= $order->shippingAddress->mobile;
		$orderData['email'] 				= $order->shippingAddress->email;
		$orderData['state'] 				= 0;
//		$orderData['checked_out'] 			= JFactory::getDate()->toMySQL();
//		$orderData['checked_out_by'] 		= $user->id;
		$orderData['created'] 				= JFactory::getDate()->toMySQL();
		$orderData['created_by'] 			= $user->id;
		$orderData['modified'] 				= null;
		$orderData['modified_by'] 			= null;
		$orderData = (object)$orderData;
		$db->insertObject('#__hp_order', $orderData);
		$orderData->id = $db->insertid();
		
//		var_dump($order->items); die;
		
		$orderItemDatas = array();
		foreach($order->items as $orderItem) {
		    
			$orderItemData = array();
			$orderItemData['order_id'] 			= $orderData->id;
			$orderItemData['item_id'] 			= $orderItem->id;
			$orderItemData['business_id'] 		= $orderItem->business_id;
//			$orderItemData['business_name'] 	= $orderItem->businessProfile->business_name;
//			$orderItemData['service_id'] 		= $orderItem->category;
//			$orderItemData['service_name'] 		= $orderItem->name;
			$orderItemData['qty'] 				= $orderItem->qty;
			$orderItemData['origin_price'] 		= $orderItem->price;
			$orderItemData['price'] 			= $orderItem->current_price;
			$orderItemData['created'] 			= JFactory::getDate()->toMySQL();
			$orderItemData['created_by'] 		= $user->id;
			$orderItemData['modified'] 			= null;
			$orderItemData['modified_by'] 		= null;
			
			$orderItemData = (object)$orderItemData;
			
			$db->insertObject('#__hp_order_items', $orderItemData);
			
			if ($db->getErrorMsg())
			    die ($db->getErrorMsg ());
			
			$orderItemDatas[] = $orderItemData;
		}
		
		// remove shopping cart
		require_once JPATH_COMPONENT.DS.'helpers'.DS.'shoppingcart.class.php';
		$basket = new ShoppingBasket();
		$basket->emptyBasket();
		
		//TODO #nttuyen After save order, what will redirect to
		$this->setRedirect(JRoute::_(JURI::base()), 'Bạn đã đặt hàng thành công!');
		return true;
	}
}