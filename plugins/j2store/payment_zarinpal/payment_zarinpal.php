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

require_once (JPATH_ADMINISTRATOR.'/components/com_j2store/library/plugins/payment.php');
if (!class_exists ('checkHack')) {
	require_once( JPATH_PLUGINS . '/j2store/payment_zarinpal/trangell_inputcheck.php');
}

class plgJ2StorePayment_zarinpal extends J2StorePaymentPlugin
{
    var $_element    = 'payment_zarinpal';

	function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage( 'com_j2store', JPATH_ADMINISTRATOR );
	}


	function onJ2StoreCalculateFees($order) {
		$payment_method = $order->get_payment_method ();

		if ($payment_method == $this->_element) {
			$total = $order->order_subtotal + $order->order_shipping + $order->order_shipping_tax;
			$surcharge = 0;
			$surcharge_percent = $this->params->get ( 'surcharge_percent', 0 );
			$surcharge_fixed = $this->params->get ( 'surcharge_fixed', 0 );
			if (( float ) $surcharge_percent > 0 || ( float ) $surcharge_fixed > 0) {
				// percentage
				if (( float ) $surcharge_percent > 0) {
					$surcharge += ($total * ( float ) $surcharge_percent) / 100;
				}

				if (( float ) $surcharge_fixed > 0) {
					$surcharge += ( float ) $surcharge_fixed;
				}

				$name = $this->params->get ( 'surcharge_name', JText::_ ( 'J2STORE_CART_SURCHARGE' ) );
				$tax_class_id = $this->params->get ( 'surcharge_tax_class_id', '' );
				$taxable = false;
				if ($tax_class_id && $tax_class_id > 0)
					$taxable = true;
				if ($surcharge > 0) {
					$order->add_fee ( $name, round ( $surcharge, 2 ), $taxable, $tax_class_id );
				}
			}
		}
	}

    function _prePayment( $data )
    {
		$app	= JFactory::getApplication();
        $vars = new JObject();
        $vars->order_id = $data['order_id'];
        $vars->orderpayment_id = $data['orderpayment_id'];
        $vars->orderpayment_amount = $data['orderpayment_amount'];
        $vars->orderpayment_type = $this->_element;
        $vars->button_text = $this->params->get('button_text', 'J2STORE_PLACE_ORDER');
        //============================================================================
		$vars->display_name = 'Zarinpal';
		$vars->merchant_id = $this->params->get('merchant_id', '');
		if ($vars->merchant_id == null || $vars->merchant_id == ''){
			$link = JRoute::_("index.php?option=com_j2store&view=carts" );
			$app->redirect($link, '<h2>لطفا تنظیمات درگاه زرین پال را بررسی کنید</h2>', $msgType='Error'); 
		}
		else{
			$Amount = round($vars->orderpayment_amount,0)/10; // Toman 
			$Description = 'خرید محصول از گیلگمش'; 
			$Email = ''; 
			$Mobile = ''; 
			$CallbackURL = JRoute::_('index.php?option=com_j2store&view=checkout&task=confirmPayment&orderpayment_id='.$vars->orderpayment_id . '&orderpayment_type=' . $vars->orderpayment_type, true, -1);
				
			try {
				$client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']); 	
//				 $client = new SoapClient('https://sandbox.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']); // for local
				$result = $client->PaymentRequest(
					[
					'MerchantID' => $vars->merchant_id,
					'Amount' => $Amount,
					'Description' => $Description,
					'Email' => $Email,
					'Mobile' => $Mobile,
					'CallbackURL' => $CallbackURL,
					]
				);
				
				$resultStatus = abs($result->Status); 
				if ($resultStatus == 100) {
//					var_dump($this->params); die;
					if ($this->params->get('zaringate', '') == 0){
						$vars->zarinpal= 'https://www.zarinpal.com/pg/StartPay/'.$result->Authority;
					}
					else {
						$vars->zarinpal= 'https://www.zarinpal.com/pg/StartPay/'.$result->Authority.'‫‪/ZarinGate‬‬';
					}
					$html = $this->_getLayout('prepayment', $vars);
					return $html;
				// Header('Location: https://sandbox.zarinpal.com/pg/StartPay/'.$result->Authority); 
			
				} else {
					$link = JRoute::_( "index.php?option=com_j2store&view=carts" );
					$app->redirect($link, '<h2>ERR: '. $resultStatus .'</h2>', $msgType='Error'); 
				}
			}
			catch(\SoapFault $e) {
				$msg= $this->getGateMsg('error'); 
				$link = JRoute::_( "index.php?option=com_j2store&view=carts" );
				$app->redirect($link, '<h2>'.$msg.'</h2>', $msgType='Error'); 
			}
		}
    }

	
	function _postPayment($data) {
		$app = JFactory::getApplication(); 
		$jinput = $app->input;
        $html = '';
		$orderpayment_id = $jinput->get->get('orderpayment_id', '0', 'INT');
        F0FTable::addIncludePath ( JPATH_ADMINISTRATOR . '/components/com_j2store/tables' );
		$orderpayment = F0FTable::getInstance ( 'Order', 'J2StoreTable' )->getClone ();
	    //$this->getShippingAddress()->phone_2; //mobile
		//==========================================================================
		$Authority = $jinput->get->get('Authority', '0', 'INT');
		$status = $jinput->get->get('Status', '', 'STRING');

	    if ($orderpayment->load ($orderpayment_id)){
			$customer_note = $orderpayment->customer_note;
			if($orderpayment->j2store_order_id == $orderpayment_id) {
				if (checkHack::checkString($status)){
					if ($status == 'OK') {
						try {
//							$client = new SoapClient('https://sandbox.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);   // for local
							 $client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);
							$result = $client->PaymentVerification(
								[
									'MerchantID' =>  $this->params->get('merchant_id', ''),
									'Authority' => $Authority,
									'Amount' => round($orderpayment->order_total,0)/10,
								]
							);
							$resultStatus = abs($result->Status); 
							if ($resultStatus == 100) {
								$msg= $this->getGateMsg($resultStatus); 
//								echo 'message ' . $msg; die;
								$app->enqueueMessage($result->RefID . ' کد پیگیری شما', 'message');	
								$html = $this->saveStatus($msg,1,$customer_note,'ok',$result->RefID,$orderpayment);	
							} 
							else {
								$msg= $this->getGateMsg($resultStatus); 
								$this->saveStatus($msg,3,$customer_note,'nonok',null,$orderpayment);// error
								$link = JRoute::_( "index.php?option=com_j2store&view=carts" );
								$app->redirect($link, '<h2>'.$msg.'</h2>', $msgType='Error'); 
							}
						}
						catch(\SoapFault $e) {
							$msg= $this->getGateMsg('error'); 
							$this->saveStatus($msg,3,$customer_note,'nonok',null,$orderpayment);
							$link = JRoute::_( "index.php?option=com_j2store&view=carts" );
							$app->redirect($link, '<h2>'.$msg.'</h2>', $msgType='Error'); 
						}
					}
					else {
						$msg= $this->getGateMsg(intval(17)); 
						$this->saveStatus($msg,4,$customer_note,'nonok',null,$orderpayment);
						$link = JRoute::_( "index.php?option=com_j2store&view=carts" );
						$app->redirect($link, '<h2>'.$msg.'</h2>', $msgType='Error'); 
					}
				}
				else {
					$msg= $this->getGateMsg('hck2'); 
					$this->saveStatus($msg,3,$customer_note,'nonok',null,$orderpayment);
					$link = JRoute::_( "index.php?option=com_j2store&view=carts" );
					$app->redirect($link, '<h2>'.$msg.'</h2>' , $msgType='Error'); 
				}
			}
			else {
				$msg= $this->getGateMsg('notff'); 
				$link = JRoute::_( "index.php?option=com_j2store&view=carts" );
				$app->redirect($link, '<h2>'.$msg.'</h2>' , $msgType='Error'); 
			}
	    }
		else {
			$msg= $this->getGateMsg('notff'); 
			$link = JRoute::_( "index.php?option=com_j2store&view=carts" );
			$app->redirect($link, '<h2>'.$msg.'</h2>' , $msgType='Error'); 
		}
		return $html;
	}

    function _renderForm( $data )
    {
    	$user = JFactory::getUser();
        $vars = new JObject();
        $vars->onselection_text = $this->params->get('onselection', '');
        $html = $this->_getLayout('form', $vars);
        return $html;
    }

	function getPaymentStatus($payment_status) {
    	$status = '';
    	switch($payment_status) {
			case '1': $status = JText::_('J2STORE_CONFIRMED'); break;
			case '2': $status = JText::_('J2STORE_PROCESSED'); break;
			case '3': $status = JText::_('J2STORE_FAILED'); break;
			case '4': $status = JText::_('J2STORE_PENDING'); break;
			case '5': $status = JText::_('J2STORE_INCOMPLETE'); break;
			default: $status = JText::_('J2STORE_PENDING'); break;	
    	}
    	return $status;
    }

	function saveStatus($msg,$statCode,$customer_note,$emptyCart,$trackingCode,$orderpayment){
		$html ='<br />';
		$html .='<strong>'.'Zarinpal'.'</strong>';
		$html .='<br />';
		if (isset($trackingCode)){
			$html .= "\n";
			$html .= $trackingCode .'شماره پیگری ';
		}
		$html .='<br />' . $msg;
		$orderpayment->customer_note =$customer_note.$html;
		$payment_status = $this->getPaymentStatus($statCode); 
		$orderpayment->transaction_status = $payment_status;
		$orderpayment->order_state = $payment_status;
		$orderpayment->order_state_id = $this->params->get('payment_status', $statCode); 
		
		if ($orderpayment->store()) {
			if ($emptyCart == 'ok'){
				$orderpayment->payment_complete ();
				$orderpayment->empty_cart();
			}
		}
		else
		{
			$errors[] = $orderpayment->getError();
		}
	
 		$vars = new JObject();
		$vars->message = $msg;
		$html = $this->_getLayout('message', $vars);
		$html .= $this->_displayArticle();
//		var_dump($html); die;
		return $html;
	}

    function getGateMsg ($msgId) {
		switch($msgId){
			case	11: $out =  'شماره کارت نامعتبر است';break;
			case	12: $out =  'موجودي کافي نيست';break;
			case	13: $out =  'رمز نادرست است';break;
			case	14: $out =  'تعداد دفعات وارد کردن رمز بيش از حد مجاز است';break;
			case	15: $out =   'کارت نامعتبر است';break;
			case	17: $out =   'کاربر از انجام تراکنش منصرف شده است';break;
			case	18: $out =   'تاريخ انقضاي کارت گذشته است';break;
			case	21: $out =   'پذيرنده نامعتبر است';break;
			case	22: $out =   'ترمينال مجوز ارايه سرويس درخواستي را ندارد';break;
			case	23: $out =   'خطاي امنيتي رخ داده است';break;
			case	24: $out =   'اطلاعات کاربري پذيرنده نامعتبر است';break;
			case	25: $out =   'مبلغ نامعتبر است';break;
			case	31: $out =  'پاسخ نامعتبر است';break;
			case	32: $out =   'فرمت اطلاعات وارد شده صحيح نمي باشد';break;
			case	33: $out =   'حساب نامعتبر است';break;
			case	34: $out =   'خطاي سيستمي';break;
			case	35: $out =   'تاريخ نامعتبر است';break;
			case	41: $out =   'شماره درخواست تکراري است';break;
			case	42: $out =   'تراکنش Sale يافت نشد';break;
			case	43: $out =   'قبلا درخواست Verify داده شده است';break;
			case	44: $out =   'درخواست Verify يافت نشد';break;
			case	45: $out =   'تراکنش Settle شده است';break;
			case	46: $out =   'تراکنش Settle نشده است';break;
			case	47: $out =   'تراکنش Settle يافت نشد';break;
			case	48: $out =   'تراکنش Reverse شده است';break;
			case	49: $out =   'تراکنش Refund يافت نشد';break;
			case	51: $out =   'تراکنش تکراري است';break;
			case	52: $out =   'سرويس درخواستي موجود نمي باشد';break;
			case	54: $out =   'تراکنش مرجع موجود نيست';break;
			case	55: $out =   'تراکنش نامعتبر است';break;
			case	61: $out =   'خطا در واريز';break;
			case	100: $out =   'تراکنش با موفقيت انجام شد.';break;
			case	111: $out =   'صادر کننده کارت نامعتبر است';break;
			case	112: $out =   'خطاي سوئيچ صادر کننده کارت';break;
			case	113: $out =   'پاسخي از صادر کننده کارت دريافت نشد';break;
			case	114: $out =   'دارنده کارت مجاز به انجام اين تراکنش نيست';break;
			case	412: $out =   'شناسه قبض نادرست است';break;
			case	413: $out =   'شناسه پرداخت نادرست است';break;
			case	414: $out =   'سازمان صادر کننده قبض نامعتبر است';break;
			case	415: $out =   'زمان جلسه کاري به پايان رسيده است';break;
			case	416: $out =   'خطا در ثبت اطلاعات';break;
			case	417: $out =   'شناسه پرداخت کننده نامعتبر است';break;
			case	418: $out =   'اشکال در تعريف اطلاعات مشتري';break;
			case	419: $out =   'تعداد دفعات ورود اطلاعات از حد مجاز گذشته است';break;
			case	421: $out =   'IP نامعتبر است';break;
			case	500: $out =   'کاربر به صفحه زرین پال رفته ولي هنوز بر نگشته است';break;
			case	'1':
			case	'error': $out ='خطا غیر منتظره رخ داده است';break;
			case	'hck2': $out = 'لطفا از کاراکترهای مجاز استفاده کنید';break;
			case	'notff': $out = 'سفارش پیدا نشد';break;
			default: $out ='خطا غیر منتظره رخ داده است';break;
		}
		return $out;
	}
	function getShippingAddress() {

		$user =	JFactory::getUser();
		$db = JFactory::getDBO();

		$query = "SELECT * FROM #__j2store_addresses WHERE user_id={$user->id}";
		$db->setQuery($query);
		return $db->loadObject();

	 }

}
