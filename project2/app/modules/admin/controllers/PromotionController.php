<?php 
class Admin_PromotionController extends Zend_Controller_Action{
	
	public function init(){
        $layoutPath = APP_PATH . '/templates/admin/';
        $option = array ('layout'     => 'index',
                         'layoutPath' => $layoutPath,
                         'contentKey' => 'content' );
        Zend_Layout::startMvc( $option );
    }
	
	public function indexAction(){
		$prom = new Admin_Model_Promotion();
		$data = $prom->getAllPromotion(); 
		
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
    
    public function getProduct($arr=null){
       $subcat  = new Admin_Model_Subcat();
		$subcats = $subcat->getAllSubcat();
		
		$product = new Admin_Model_Product();
		//$products = $product->getAllProduct();
		$html = '<ul>';
		foreach($subcats as $subcatitem){
			$check = $subcat->checkHasChild($subcatitem['subcat_id']);
            if($check>0){
               $html .= '<li>';
    			$html .= $subcatitem['subcat_name'].'-'.$subcatitem['cat_name'];
    			$html .= '<ul>';
    			$products = $product->getSubProduct($subcatitem['subcat_id']);
    			foreach($products as $productitem){
    				$checked = '';
                    for($i=0;$i<count($arr);$i++){
                        if($productitem['pro_id']==$arr[$i]){
                            $checked = ' checked="checked" ';
                            break;
                        }
                    }
                    if($checked!=''){
                       $html .= '<li><input type="checkbox" '.$checked.' name="proid[]" value="'.$productitem['pro_id'].'" />';
    			 	$html .= $productitem['pro_name'].'</li>'; 
                    }else{
                        $html .= '<li><input type="checkbox" name="proid[]" value="'.$productitem['pro_id'].'" />';
    				    $html .= $productitem['pro_name'].'</li>';
                    }
                    
    			}
    			$html .= '</ul></li>'; 
                
            }
		}
		$html .= '</ul>';
        return $html; 
    }
	
	public function addAction(){
		$html = $this->getProduct();
        $this->view->proarrid = $html;
        
        //add promotion
        $prom = new Admin_Model_Promotion();
        if($this->_request->isPost()){
			$promname  = $this->_request->getParam('name');
            $saleoff   = $this->_request->getParam('saleoff');
            $startdate = $this->_request->getParam('startdate');
            $enddate   = $this->_request->getParam('enddate');
            $proid   = $this->_request->getParam('proid');
            $listproid = implode(',',$proid);
            $promid = $prom->addPromotion($promname,$saleoff,$startdate,$enddate,$listproid);
            if($promid){
                $this->_redirect('/admin/promotion/index');
            }
        }
	}
    
    public function editAction(){
        $id = $this->_request->getParam('id');
        $prom = new Admin_Model_Promotion();
        $promotions = $prom->getPromotion($id);
        $arrid = explode(',',$promotions['arr_id']);
        $html = $this->getProduct($arrid);
        $promotions['html'] = $html; 
        $this->view->data = $promotions;
        if($this->_request->isPost()){
			$promname  = $this->_request->getParam('name');
            $saleoff   = $this->_request->getParam('saleoff');
            $startdate = $this->_request->getParam('startdate');
            $enddate   = $this->_request->getParam('enddate');
            $proid   = $this->_request->getParam('proid');
            $listproid = implode(',',$proid);
            $promid = $prom->editPromotion($promname,$saleoff,$startdate,$enddate,$listproid,$id);
            if($promid){
                $this->_redirect('/admin/promotion/index');
            }
        }
    }
	
	public function deleteAction(){
		$prom = new Admin_Model_Promotion();
        $id = $this->_request->getParam('id');
		$check = $prom ->delete('prom_id IN('.$id.')');
		if($check){
			$this->_redirect('/admin/promotion/index');
		}
	}
}