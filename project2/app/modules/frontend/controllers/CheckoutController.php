<?php 
class CheckoutController extends Zend_Controller_Action{
	public function preDispatch(){
		if($this->_request->getActionName() == 'success'){
		//echo 123; exit;
			require_once('Zend/Mail.php');
			require_once('Zend/Mail/Transport/Smtp.php');
			$config = array(
				'auth' => 'login',
				'username' => 'support@studentworkvietnam.com', 
				'password' => '1q2w3e4r5t#');
			
			$transport = new Zend_Mail_Transport_Smtp('mail.studentworkvietnam.com', $config);
			$sslastId = new Zend_Session_Namespace('lastid');
			$model_order = new Frontend_Model_Order();
			$order_item = $model_order->getItem($sslastId->lastid);
			try{
				$view = new Zend_View();
				$view->setScriptPath(APP_PATH . '/modules/frontend/views/emails/');
				$view->assign('email', $order_item['cus_email']);
				$view->assign('order_id', $order_item['order_id']);
				$view->assign('grand_total', $order_item['grand_total']);
				$view->assign('payment_method', $order_item['payment_method']);

				$bodytext = $view->render('newOrder.phtml');
				$mail = new Zend_Mail();
				$mail->setBodyText($bodytext)
					->setFrom('contact.mr.son@gmail.com','nvson')
					->addTo('mrson.ithut@gmail.com','sonnv')
					->setSubject('Test send mail');
				$mail->send($transport);
			} catch(Zend_Exception $e) {
				echo $e->getMessage();
			}
			$sslastId->unsetAll();
		}
	}
	public function init(){
        $layoutPath = APP_PATH . '/templates/frontend/';
        $option = array ('layout'     => 'cart',
                         'layoutPath' => $layoutPath,
                         'contentKey' => 'content' );
        Zend_Layout::startMvc( $option );
    }
	public function indexAction(){
		
	}
	public function inforAction(){
		$order = new Zend_Session_Namespace('order');
		$flag = 0;
		$errn = '';
		$erre = '';
		$errp = '';
		$erradd = '';
		$data = array();
		if($this->_request->isPost()){
		$arr_param = $this->_request->getParams();
		$global = new Frontend_Model_Global();
		if($arr_param['full_name']==""){
			$errn = '<span style="color:red">Your fullname is not empty</span>';
			$this->view->errn = $errn;
			$flag = -1;
		}
		if($arr_param['email']==""){
			$erre = '<span style="color:red">Your email is not empty</span>';
			$this->view->erre = $erre;
			$flag = -1;
		} else {
			if(!$global->checkEmail($arr_param['email'])){
				$erre = '<span style="color:red">Your email address is invalid!</span>';
				$flag = -1;
				$this->view->erre = $erre;
			}
		}
		if($arr_param['phone']==""){
			$errp = '<span style="color:red">Your phone is not empty</span>';
			$this->view->errp = $errp;
			$flag = -1;
		}
		if($arr_param['address']==""){
			$erradd = '<span style="color:red">Your address is not empty</span>';
			$this->view->erradd = $erradd;
			$flag = -1;
		}
		$this->view->data = $arr_param;
		if($flag==0){
			$order->order_info = $arr_param;
			$this->_redirect('/checkout/payment');
		}
		}
	}
	public function paymentAction(){
		$order = new Zend_Session_Namespace('order');
		if (isset($_POST['delivery'])) {
			$order->order_payment = 'Payment on delivery';
			$this->_redirect('/checkout/order/');
		}
		if(isset($_POST['nganluong'])){
			$order->order_payment = 'Payment by nganluong';
			$this->_redirect('/checkout/order/');
		}
		if (isset($_POST['paypal']) || isset($_POST['onepay'])){
			$this->_redirect('/checkout/error/');
		}
	}
	public function errorAction(){
	
	}
	public function orderAction(){
		$ssorder = new Zend_Session_Namespace('order');
		$yourcart = new Zend_Session_Namespace('cart');
		$son = new Frontend_Model_Order();
		$customer = new Frontend_Model_Customer();
		$this->view->order_info = $ssorder->order_info;
		$this->view->order_payment = $ssorder->order_payment;
		$session = $yourcart->getIterator();
		$this->view->cart = $session['cart'];
		$this->view->totalPrice = $session['totalPrice'];
		if($this->_request->isPost()){
			$max_orderId = $son->getLastOrderId();
			$order_id = (int)substr($max_orderId['max(order_id)'],1) +1;
			$ssorder->order_id = $order_id;
			$order_info = $ssorder->order_info;
			if($customer->checkAccount($order_info['email'])){
				$cus_id = $customer->getCusId($order_info['email']);
				$cus_type = 'customer';
			} else {
				$cus_id = 0;
				$cus_type = 'guest';
			};
			if($son->saveItems('#'.$order_id,$cus_id,$order_info['email'],$cus_type,$session['totalPrice'],$ssorder->order_payment,'pending')){
				$db = Zend_Db_Table_Abstract::getDefaultAdapter();
				$last_id = $db->lastInsertId();
				foreach($session['cart'] as $k=>$v){
					$son->saveOrderItems($last_id,$k,$v);
				}
				$sslastId = new Zend_Session_Namespace('lastid');
				$sslastId->lastid = $last_id;
				$yourcart->unsetAll();
				$this->_redirect('/checkout/success');
			};
		}
	}
	public function successAction(){
			$this->_redirect('/checkout/empty');
	}
	public function emptyAction(){
		$ssorder = new Zend_Session_Namespace('order');
		$order_id = $ssorder->order_id;
		$this->view->order_id = $order_id;
		$ssorder->unsetAll();
	}
}



















