<?php

/**
 * @package     Joomla - > Site and Administrator payment info
 * @subpackage  com_j2store
 * @subpackage 	Trangell_Zarinpal
 * @copyright   trangell team => https://trangell.com
 * @copyright   Copyright (C) 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die('Restricted access');

require_once (JPATH_ADMINISTRATOR . '/components/com_j2store/library/plugins/payment.php');
if (!class_exists('checkHack')) {
	require_once( JPATH_PLUGINS . '/j2store/payment_payir/trangell_inputcheck.php');
}

class plgJ2StorePayment_payir extends J2StorePaymentPlugin {

	var $_element = 'payment_payir';

	function __construct(& $subject, $config) {
		parent::__construct($subject, $config);
		$this->loadLanguage('com_j2store', JPATH_ADMINISTRATOR);
	}

	function onJ2StoreCalculateFees($order) {
		$payment_method = $order->get_payment_method();
		if ($payment_method == $this->_element) {
			$total = $order->order_subtotal + $order->order_shipping + $order->order_shipping_tax;
			$surcharge = 0;
			$surcharge_percent = $this->params->get('surcharge_percent', 0);
			$surcharge_fixed = $this->params->get('surcharge_fixed', 0);
			if ((float) $surcharge_percent > 0 || (float) $surcharge_fixed > 0) { // percentage
				if ((float) $surcharge_percent > 0) {
					$surcharge += ($total * (float) $surcharge_percent) / 100;
				}
				if ((float) $surcharge_fixed > 0) {
					$surcharge += (float) $surcharge_fixed;
				}
				$name = $this->params->get('surcharge_name', JText::_('J2STORE_CART_SURCHARGE'));
				$tax_class_id = $this->params->get('surcharge_tax_class_id', '');
				$taxable = ($tax_class_id && $tax_class_id > 0) ? true : false;
				if ($surcharge > 0) {
					$order->add_fee($name, round($surcharge, 2), $taxable, $tax_class_id);
				}
			}
		}
	}

	function sendPayment($api, $amount, $redirect, $factorNumber = null) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://pay.ir/payment/send');
		curl_setopt($ch, CURLOPT_POSTFIELDS, "api=$api&amount=$amount&redirect=$redirect&factorNumber=$factorNumber");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$res = curl_exec($ch);
		curl_close($ch);
		return $res;
	}

	function verifyPayment($api, $transId) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://pay.ir/payment/verify');
		curl_setopt($ch, CURLOPT_POSTFIELDS, "api=$api&transId=$transId");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$res = curl_exec($ch);
		curl_close($ch);
		return $res;
	}

	function _prePayment($data) {
		$app = JFactory::getApplication();
		$vars = new JObject();
		$vars->order_id = $data['order_id'];
		$vars->orderpayment_id = $data['orderpayment_id'];
		$vars->orderpayment_amount = $data['orderpayment_amount'];
		$vars->orderpayment_type = $this->_element;
		$vars->button_text = $this->params->get('button_text', 'J2STORE_PLACE_ORDER');
		//============================================================================
		$vars->display_name = 'Pay.ir';
		$vars->api_key = $this->params->get('api_key', '');
		if ($vars->api_key == null || $vars->api_key == '') {
			$link = JRoute::_("index.php?option=com_j2store&view=carts");
			$app->redirect($link, '<h2>لطفا تنظیمات درگاه را بررسی کنید</h2>', $msgType = 'Error');
		} else {
			$Amount = round($vars->orderpayment_amount, 0); // Rials
			$CallbackURL = JRoute::_('index.php?option=com_j2store&view=checkout&task=confirmPayment&orderpayment_id=' . $vars->orderpayment_id . '&orderpayment_type=' . $vars->orderpayment_type, true, -1);

			$paymentStatus = $this->sendPayment($vars->api_key, $Amount, urlencode($CallbackURL), $vars->order_id);
			$result = json_decode($paymentStatus);
			if ($result->status) {
				$vars->payir = 'https://pay.ir/payment/gateway/' . $result->transId;
				$html = $this->_getLayout('prepayment', $vars);
				return $html;
			} else {
				$msg = 'خطا غیر منتظره رخ داده است';
				$link = JRoute::_("index.php?option=com_j2store&view=carts");
				$app->redirect($link, '<h2>ERR: ' . $msg . '</h2><br />' . $paymentStatus, $msgType = 'Error');
			}
		}
	}

	function _postPayment($data) {
		$app = JFactory::getApplication();
		$jinput = $app->input;
		$html = '';
		$orderpayment_id = $jinput->get->get('orderpayment_id', '0', 'INT');
		F0FTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_j2store/tables');
		$orderpayment = F0FTable::getInstance('Order', 'J2StoreTable')->getClone();
		//==========================================================================
		$api_key = $this->params->get('api_key', '');
		$status = $jinput->get('status', '', 'INT');
		$transId = $jinput->get('transId', '', 'INT');

		if ($orderpayment->load($orderpayment_id)) {
			$customer_note = $orderpayment->customer_note;
			if ($orderpayment->j2store_order_id == $orderpayment_id) {
				if ($status) {
					$verification = $this->verifyPayment($api_key, $transId);
					$data = json_decode($verification); // {"status":1,"amount":"1000"}
					if ($data->status) {
						$msg = 'تراکنش با موفقیت انجام شد';
						$app->enqueueMessage('کد رهگیری پرداخت: ' . $transId, 'message');
						$html = $this->saveStatus($msg, 1, $customer_note, 'ok', $transId, $orderpayment);
					} else {
						$msg = $data->errorMessage;
						$this->saveStatus($msg, 3, $customer_note, 'nonok', null, $orderpayment);
						$link = JRoute::_("index.php?option=com_j2store&view=carts");
						$app->redirect($link, '<h2>' . $msg . '</h2>', $msgType = 'Error');
					}
				} else {
					$msg = 'کاربر از انجام تراکنش منصرف شده است';
					$this->saveStatus($msg, 4, $customer_note, 'nonok', null, $orderpayment);
					$link = JRoute::_("index.php?option=com_j2store&view=carts");
					$app->redirect($link, '<h2>' . $msg . '</h2>', $msgType = 'Error');
				}
			} else {
				$msg = 'سفارش پیدا نشد';
				$link = JRoute::_("index.php?option=com_j2store&view=carts");
				$app->redirect($link, '<h2>' . $msg . '</h2>', $msgType = 'Error');
			}
		} else {
			$msg = 'سفارش پیدا نشد';
			$link = JRoute::_("index.php?option=com_j2store&view=carts");
			$app->redirect($link, '<h2>' . $msg . '</h2>', $msgType = 'Error');
		}
		return $html;
	}

	function _renderForm($data) {
		$user = JFactory::getUser();
		$vars = new JObject();
		$vars->onselection_text = $this->params->get('onselection', '');
		$html = $this->_getLayout('form', $vars);
		return $html;
	}

	function getPaymentStatus($payment_status) {
		$status = '';
		switch ($payment_status) {
			case '1': $status = JText::_('J2STORE_CONFIRMED');
				break;
			case '2': $status = JText::_('J2STORE_PROCESSED');
				break;
			case '3': $status = JText::_('J2STORE_FAILED');
				break;
			case '4': $status = JText::_('J2STORE_PENDING');
				break;
			case '5': $status = JText::_('J2STORE_INCOMPLETE');
				break;
			default: $status = JText::_('J2STORE_PENDING');
				break;
		}
		return $status;
	}

	function saveStatus($msg, $statCode, $customer_note, $emptyCart, $trackingCode, $orderpayment) {
		$html = '<br />';
		$html .= '<strong>' . 'Pay.ir' . '</strong>';
		$html .= '<br />';
		if (isset($trackingCode)) {
			$html .= "\n";
			$html .= $trackingCode . 'شماره پیگری ';
		}
		$html .= '<br />' . $msg;
		$orderpayment->customer_note = $customer_note . $html;
		$payment_status = $this->getPaymentStatus($statCode);
		$orderpayment->transaction_status = $payment_status;
		$orderpayment->order_state = $payment_status;
		$orderpayment->order_state_id = $this->params->get('payment_status', $statCode);

		if ($orderpayment->store()) {
			if ($emptyCart == 'ok') {
				$orderpayment->payment_complete();
				$orderpayment->empty_cart();
			}
		} else {
			$errors[] = $orderpayment->getError();
		}

		$vars = new JObject();
		$vars->message = $msg;
		$html = $this->_getLayout('message', $vars);
		$html .= $this->_displayArticle();
		return $html;
	}

	function getShippingAddress() {

		$user = JFactory::getUser();
		$db = JFactory::getDBO();

		$query = "SELECT * FROM #__j2store_addresses WHERE user_id={$user->id}";
		$db->setQuery($query);
		return $db->loadObject();
	}

}
