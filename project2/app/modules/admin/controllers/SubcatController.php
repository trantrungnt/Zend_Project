<?php 
class Admin_SubcatController extends Zend_Controller_Action{
	
	public function init(){
        $layoutPath = APP_PATH . '/templates/admin/';
        $option = array ('layout'     => 'index',
                         'layoutPath' => $layoutPath,
                         'contentKey' => 'content' );
        Zend_Layout::startMvc( $option );
    }
	
	public function indexAction(){
		$cat    = new Admin_Model_Cat();
		$arrcat = $cat->getAllCategory();
		$this->view->cat = $arrcat;
		$subcat = new Admin_Model_Subcat();
		$data = $subcat->getAllSubcat();             
		//$this->view->data = $arrsubcat;
		
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
	
	public function addAction(){
		$cat = new Admin_Model_Cat();
		$arrcat = $cat->getAllCategory();
		$this->view->catdata = $arrcat;
		
		$subcat = new Admin_Model_Subcat();
		if($this->_request->isPost()){
			$catid = $this->_request->getParam('catname');
			$subcatname = $this->_request->getParam('txtSubcatName');
            $subcatdes  = $this->_request->getParam('txtDes');
			$url        = strtolower($subcatname);
			$subcaturl  = str_replace(' ','-',$url);
			$data=array();
			$errc='';
			$errscn='';
			$errscd='';
			if($catid==-1){
				$errc='Please choose category.';
				$data['cat_id'] = -1;
			}else{
				$data['cat_id'] = $catid;
			}
			if($subcatname==''){
				$errscn=' Subcatname must be not empty.';
				$data['subcat_name']='';
			}else{
				$data['subcat_name']=$subcatname;
			}
			if($subcatdes==''){
				$errscd = "Subcategory description must be not empty.";
				$data['subcat_des']='';
			}else{
				$data['subcat_des']=$subcatdes;
			}
			if($errc!='' || $errscn!='' || $errscd!=''){
                $this->view->errc   = $errc;
				$this->view->errscn = $errscn;
				$this->view->errscd = $errscd;
                $this->view->subcat = $data;
            }else{
                $check = $subcat->addSubcategory($catid,$subcatname,$subcatdes,$subcaturl);
                if($check){
                    $this->_redirect('/admin/subcat/index');
                }
            }	
		}
	}
	
	public function editAction(){
		$cat = new Admin_Model_Cat();
		$arrcat = $cat->getAllCategory();
		$this->view->catdata = $arrcat;
		
		$subcat = new Admin_Model_Subcat();
		$id  = $this->_request->getParam('id');
		$catid      = $this->_request->getParam('catname');
        $subcatname = $this->_request->getParam('txtSubcatName');  
        $subcatdes  = $this->_request->getParam('txtDes');  
		$url        = strtolower($subcatname);
		$subcaturl  = str_replace(' ','-',$url);
		
		if($this->_request->isPost()){ 
            $data=array();
			$errc='';
			$errscn='';
			$errscd='';
			if($catid==-1){
				$errc='Please choose category.';
				$data['cat_id'] = -1;
			}else{
				$data['cat_id'] = $catid;
			}
			if($subcatname==''){
				$errscn=' Subcatname must be not empty.';
				$data['subcat_name']='';
			}else{
				$data['subcat_name']=$subcatname;
			}
			if($subcatdes==''){
				$errscd = "Subcategory description must be not empty.";
				$data['subcat_des']='';
			}else{
				$data['subcat_des']=$subcatdes;
			} 
            if($errc!='' || $errscn!='' || $errscd!=''){
                $this->view->errc   = $errc;
				$this->view->errscn = $errscn;
				$this->view->errscd = $errscd;
                $this->view->subcat = $data;
            }else{
                $check = $subcat->editSubCategory($catid,$subcatname,$subcatdes,$subcaturl,$id);
                if($check){
                    $this->_redirect('/admin/subcat/index');
                }
            }    
		}else{
		      $this->view->subcat = $subcat->getSubcat($id);
		}
	}
	
	public function deleteAction(){
		$cat = new Admin_Model_Subcat();
        $id = $this->_request->getParam('id');
		$check = $cat ->delete('subcat_id IN('.$id.')');
		if($check){
			$this->_redirect('/admin/subcat/index');
		}
	}
}