<?php 
class Admin_CatController extends Zend_Controller_Action{
	
	public function init(){
        $layoutPath = APP_PATH . '/templates/admin/';
        $option = array ('layout'     => 'index',
                         'layoutPath' => $layoutPath,
                         'contentKey' => 'content' );
        Zend_Layout::startMvc( $option );
    }
	
	public function indexAction(){
		$cat = new Admin_Model_Cat();
		$data = $cat->getAllCategory();             
		//$this->view->data = $arrcat;	
		
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
		if($this->_request->isPost()){
			$catname = $this->_request->getParam('txtCatName');
            $catdes  = $this->_request->getParam('txtDes');
			$url     = strtolower($catname);
			$caturl  = str_replace(' ','-',$url);
			$errcn='';
			$errcd='';
			$data=array();
			if($catname==''){
				$errcn = "Please fill category name!";
				$data['cat_name']='';
			}else{
				$data['cat_name']=$catname;
			}
			if($catdes==''){
               $errcd = 'Please fill category description!';
               $data['cat_des']='';
            }else{
               $data['cat_des']=$catdes;
            } 
			if($errcn!='' || $errcd!==''){
                $this->view->errcn = $errcn;
				$this->view->errcd = $errcd;
                $this->view->cat = $data;
             }else{
                $check = $cat->addCategory($catname,$catdes,$caturl);
                if($check){
                    $this->_redirect('/admin/cat/index');
                }
             }
			
		}
	}
	
	public function editAction(){
		$cat = new Admin_Model_Cat();
		$id  = $this->_request->getParam('id');
        $catname = $this->_request->getParam('txtCatName');    
        $catdes = $this->_request->getParam('txtCatDes');   
		$url     = strtolower($catname);
		$caturl  = str_replace(' ','-',$url);
		if($this->_request->isPost()){ 
			$errcn='';
			$errcd='';
             if($catname==''){
                $errcn='Category name must be not null.';
                $data['cat_name']='';
             }else{
                $data['cat_name']=$catname;
             }
			 if($catdes==''){
                $errcd = ' Category description must be not null.';
                $data['cat_des']='';
             }else{
                $data['cat_des']=$catdes;
             } 
             if($errcn!='' || $errcd!==''){
                $this->view->errcn = $errcn;
				$this->view->errcd = $errcd;
                $this->view->cat = $data;
             }else{
                $check = $cat->editCategory($catname,$catdes,$caturl,$id);
                if($check){
                    $this->_redirect('/admin/cat/index');
                }
             }
             
		}else{
		      $this->view->cat = $cat->getCategory($id);
		}
	}
	
	public function deleteAction(){
		$cat = new Admin_Model_Cat();
        $id = $this->_request->getParam('id');
		$check = $cat ->delete('cat_id IN('.$id.')');
		if($check){
			$this->_redirect('/admin/cat/index');
		}
	}

}