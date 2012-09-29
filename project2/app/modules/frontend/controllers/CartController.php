<?php
class CartController extends Zend_Controller_Action{
	
	public function init(){
        $layoutPath = APP_PATH . '/templates/frontend/';
        $option = array ('layout'     => 'cart',
                         'layoutPath' => $layoutPath,
                         'contentKey' => 'content' );
        Zend_Layout::startMvc( $option );
    }
	
	public function indexAction(){
		$yourCart = new Zend_Session_Namespace('cart');
		$session = $yourCart->getIterator();
		$totalItems = 0;
		if($session['cart']){
			foreach($session['cart'] as $k=>$v){
				$totalItems+=$v;
			}
			$yourCart->totalItems = $totalItems;
			$this->view->cart = $yourCart->cart;
		} else {
			$this->_redirect('cart/error');
		}
	}
	public function errorAction(){
		
	}
	public function additemAction(){
		$yourCart = new Zend_Session_Namespace('cart');
		$session = $yourCart->getIterator();
		$id = $this->_request->getParam('id');
		$yourCart->id = $id;
		if(count($yourCart->cart) == 0){
			$cart[$id] = 1;
			$yourCart->cart = $cart;
		} else{
			$tmp = $session['cart'];
			if(array_key_exists($id,$tmp) == true){
				$tmp[$id] = $tmp[$id] + 1;
			}else{
				$tmp[$id] = 1;
			}
			$yourCart->cart = $tmp;
		}
		
		$this->_redirect('/cart');
	}
	public function updatecartAction(){
		$param = $this->_request->getParam('cart');
		$p = array();
		foreach($param as $k=>$v){
			$p[] = array($k=>$v['qty']);
		}
		$yourCart = new Zend_Session_Namespace('cart');
		$session = $yourCart->cart;
		foreach($session as $k=>$v){
			foreach($p as $_p){
				if(array_key_exists($k,$_p) == true){
					if($_p[$k] == $v){
						break;
					} else {
						$yourCart->cart[$k] = $_p[$k];
						break;
					}
				}
			}
		}
		$this->_redirect('/cart');
	}
	public function deleteAction(){
		$id = $this->_request->getParam('id');
		$yourCart = new Zend_Session_Namespace('cart');
		$yourCart->totalItems = $yourCart->totalItems - $yourCart->cart[$id];
		$yourCart->cart[$id] = 0;
		if($yourCart->totalItems !=0){
			$this->_redirect('/cart');
		} else {
			$yourCart->totalPrice = 0;
			$this->_redirect('/cart/error');
		}
		
	}
}

















