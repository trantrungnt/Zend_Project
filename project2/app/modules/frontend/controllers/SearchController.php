<?php 
class SearchController extends Zend_Controller_Action{
	public function indexAction(){
	    Zend_Session::start();
		$cond = new Zend_Session_NameSpace();
		$pr=array();
	    if($this->_request->isPost()){
			$keysearch = $this->_request->getParam('keysearch');
			$cond->search = $keysearch;
			$search = $keysearch;
		}else{
			$search = $cond->search;
		}
		$sql = 'select * from product where pro_name like "%'.$search.'%"';
		$product= new Frontend_Model_Product();
        $data=$product->getProduct($sql);
        
        $currentPage=$this->_getParam('page');
        if(!isset($currentPage) or $currentPage==''){
            $currentPage=1; 
        }       
       
       
        $paginator = Zend_Paginator::factory($data);
        $paginator->setItemCountPerPage(6)
                  ->setPageRange(3)
                  ->setCurrentPageNumber($currentPage);
        $this->view->product=$paginator;
		$this->view->promotion=$product->getProductSaleoff();
	}
}