<?php 
class Admin_IndexController extends Zend_Controller_Action{
	
	public function preDispatch(){
        $login = Zend_Auth::getInstance();
        if(!$login->hasIdentity()){
            $this->_redirect("admin/login");
        }  
    }
	
	public function init(){
        $layoutPath = APP_PATH . '/templates/admin/';
        $option = array ('layout'     => 'index',
                         'layoutPath' => $layoutPath,
                         'contentKey' => 'content' );
        Zend_Layout::startMvc( $option );
    }
	
	public function indexAction(){
		$this->_redirect("admin/order");
	}
}