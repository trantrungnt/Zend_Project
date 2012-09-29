<?php 
class IndexController extends Zend_Controller_Action{
	public function indexAction(){
		//$test=new Zend_Session_Namespace();lam o day truoc
		//echo $test->catname;die;
        
        
	   $pr=array();
       $product= new Frontend_Model_Product();
       $data=$product->getAllProduct();
       
       
       $currentPage=$this->_getParam('page');
       if(!isset($currentPage) or $currentPage==''){
            $currentPage=1; 
       }       
       
       
        $paginator = Zend_Paginator::factory($data);
        $paginator->setItemCountPerPage(9)
                  ->setPageRange(3)//so page muon hien thi
                  ->setCurrentPageNumber($currentPage);
        
        //print_r($paginator);die;
        $this->view->product=$paginator;
        $this->view->promotion=$product->getProductSaleoff();
       
	}
	
	public function headerAction(){
		$name=$this->_getParam('name');
		
		$topmenu = new Frontend_Model_Index();
		//style menu
		$class = $topmenu->getCategoryName($name);
		$this->view->urlcatname = $class['cat_name'];
		//menu cap 1
		$rstopmenu = $topmenu->getCategories();
		$this->view->rstopmenu = $rstopmenu;
		//menu cap 2
		$submenu = $topmenu->getSubcat();
		$this->view->rstopmenu = $rstopmenu;
		
		$this->view->submenu = $submenu; 
		$this->view->catname = $name; 
        $subname=$this->_getParam('subname');
		$this->view->subcatname = $subname;
		//slide
		$product= new Frontend_Model_Product();
		//$products = $product->getAllProduct();
        $productpomotion=$product->getProductSaleoff();
        foreach($productpomotion as $proid=>$saleoff){
            $arrproid[]=$proid;
            $arrsaleoff[]=$saleoff;
        }
        $listproid=implode(',',$arrproid);
        $products = $product->getSlideProduct($listproid);
        $i=0;
        foreach($products as $item){
            $item['saleoff']=$arrsaleoff[$i];
            $data[]=$item;
        }
        
        //print_r($data);die;
        
		$this->view->product = $data;
		
		
		$auth = Zend_Auth::getInstance();
		
		if($auth->hasIdentity()){
			$infoUser = $auth->getIdentity();
			$field = array();
			foreach($infoUser as $k=>$v){
				$field[] = $k;
			}
			if(in_array('cus_email',$field)){
				$this->view->email = $infoUser->cus_email;
			} else {
				$this->view->email = '';
			}
		}
	}
     public function slideAction(){
        $pr=array();
		//slide
		$product= new Frontend_Model_Product();
		//$products = $product->getAllProduct();
        $productpomotion=$product->getProductSaleoff();
        //print_r($productpomotion);die;
        foreach($productpomotion as $proid=>$saleoff){
            $arrproid[]=$proid;
            $arrsaleoff[]=$saleoff;
        }
        $listproid=implode(',',$arrproid);
        $products = $product->getSlideProduct($listproid);
        
        $i=0;
        foreach($products as $item){
            
            foreach($productpomotion as $proid=>$saleoff){
                if($proid==$item['pro_id']){
                    $item['saleoff']=$saleoff;        
                }
            }
            
            $data[]=$item;
        }
        
       // print_r($data);die;
        
		$this->view->product = $data;
    }
	
    
	
	
}