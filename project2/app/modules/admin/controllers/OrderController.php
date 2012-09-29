<?php 
class Admin_OrderController extends Zend_Controller_Action{
	
	public function init(){
        $layoutPath = APP_PATH . '/templates/admin/';
        $option = array ('layout'     => 'index',
                         'layoutPath' => $layoutPath,
                         'contentKey' => 'content' );
        Zend_Layout::startMvc( $option );
    }
	public function indexAction(){
		$order = new Admin_Model_Order();
		$data = $order->getAllOrder();             
		//$this->view->data = $arrorder;	
		$currentPage=$this->_getParam('page');
        if(!isset($currentPage) or $currentPage==''){
            $currentPage=1; 
        }   
        $paginator = Zend_Paginator::factory($data);
        $paginator->setItemCountPerPage(10)
                  ->setPageRange(3)//so page muon hien thi
                  ->setCurrentPageNumber($currentPage);
        //print_r($paginator);die;
        $this->view->data=$paginator;
	}
	
	public function editAction(){
		$order = new Admin_Model_Order();
		$sstatus = new Zend_Session_Namespace('status');
		$id  = $this->_request->getParam('id');  
		if($this->_request->isPost()){ 
			$paramArr = $this->_request->getParams();
			//exit;
			//$order_id = $paramArr['order_id'];
			//$cus_mail =	$paramArr['cus_email'];
			$cus_type =	$paramArr['cus_type'];
			$gtotal = $paramArr['grand_total'];
			$payMethod = $paramArr['payment_method'];
			$status =	$paramArr['status'];
			if($status != 'pending'){
				require_once('Zend/Mail.php');
				require_once('Zend/Mail/Transport/Smtp.php');
				$config = array(
				 'auth' => 'login',
				 'username' => 'support@studentworkvietnam.com', 
				 'password' => '1q2w3e4r5t#');
				
				$transport = new Zend_Mail_Transport_Smtp('mail.studentworkvietnam.com', $config);
				try{
				 $view = new Zend_View();
				 $view->setScriptPath(APP_PATH . '/modules/frontend/views/emails/');
				 $view->assign('status', $status);
				 $bodytext = $view->render('statusOrder.phtml');
				 $mail = new Zend_Mail();
				 $mail->setBodyText($bodytext)
				  ->setFrom('contact.mr.son@gmail.com','nvson')
				  ->addTo('mrson.ithut@gmail.com','sonnv')
				  ->setSubject('Change Status Order');
				 $mail->send($transport);
				} catch(Zend_Exception $e) {
				 echo $e->getMessage();
				}
			}
           $check = $order->editOrder($cus_type,$gtotal,$payMethod,$status,$id);
			if($check){
				$this->_redirect('/admin/order/index');
			}
        }
		else{
		      $this->view->order = $order->getOrder($id);
		}
	}
	public function deleteAction(){
		$cat = new Admin_Model_Order();
        $id = $this->_request->getParam('id');
		$check = $cat ->delete('id IN('.$id.')');
		if($check){
			$this->_redirect('/admin/order/index');
		}
	}
}