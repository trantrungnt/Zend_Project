<?php 
class Admin_CustomerController extends Zend_Controller_Action{
	
	public function init(){
        $layoutPath = APP_PATH . '/templates/admin/';
        $option = array ('layout'     => 'index',
                         'layoutPath' => $layoutPath,
                         'contentKey' => 'content' );
        Zend_Layout::startMvc( $option );
    }
	
	public function indexAction(){
		$cus = new Admin_Model_Customer();
		$arrcat = $cus->getAllCustomer();
		//echo 111; exit;
		$currentPage = 1;
        //check if User is not on page 1     $page=$this->_getParam('page',1);
        $i=$this->_getParam('page',1);
        if(!empty($i)){
            $currentPage = $i;
        }
        $paginator = Zend_Paginator::factory($arrcat);
        $paginator->setItemCountPerPage(10);
        $paginator->setPageRange(3);
        $paginator->setCurrentPageNumber($currentPage);
        $this->view->data = $paginator;
	}
	
	public function addAction(){
		$cus = new Admin_Model_Customer();
		$upload = new Admin_Model_Product();
		if($this->_request->isPost()){
			$cus_name = $this->_request->getParam('cus_name');
            $cus_email = $this->_request->getParam('cus_email');
			$cus_phone = $this->_request->getParam('cus_phone');
			$cus_add = $this->_request->getParam('cus_add');
			//upload image
			$file       = $_FILES['avatar'];
			$url        = APP_PATH.'/templates/admin/images/upload/avatar/';
			$arrAllowEx =array('jpg','jpeg','png','gif','bmp');
			$maxSize    =5242880;
			if($file['name']!=''){
				$ava = $upload->uploadFile($file,$url,$arrAllowEx,$maxSize);
			}
			$errcn='';
			$errcm='';
			$errcp='';
			$errcadd='';
			$errcava='';
			$data=array();
			if($cus_name==''){
				$errcn = "Please fill customer name!";
				$data['cus_name']='';
			}else{
				$data['cus_name']=$cus_name;
			}
			if($cus_email==''){
               $errcm = 'Please fill customer email!';
               $data['cus_email']='';
            }else{
               $data['cus_email']=$cus_email;
            } 
			if($cus_phone==''){
               $errcp = 'Please fill customer phone number!';
               $data['cus_phone']='';
            }else{
               $data['cus_phone']=$cus_phone;
            } 
			if($cus_add==''){
               $errcadd = 'Please fill customer address!';
               $data['cus_address']='';
            }else{
               $data['cus_address']=$cus_add;
            } 
			if($file['name']!=''){
				if($ava=='-1'){
					$errcava='extension file is not valid.</br>';
				}
				if($ava=="-2"){
					$errcava.='abc file is not valid.</br>';
				} else {
					$data['cus_avatar']=$ava;
				}
			} else {
				$data['cus_avatar']='no_avatar.png';
				$ava = 'no_avatar.png';		
			}
			if($errcn!='' || $errcm!=='' || $errcp!=='' || $errcadd!=='' || $errcava!==''){
                $this->view->errcn = $errcn;
				$this->view->errcm = $errcm;
				$this->view->errcp = $errcp;
				$this->view->errcadd = $errcadd;
				$this->view->errcava = $errcava;
                $this->view->cus = $data;
             }else{
                $check = $cus->addCustomer($cus_name,$cus_add,$cus_email,$cus_phone,$ava);
                if($check){
                    $this->_redirect('/admin/customer/index');
                }
             }
		}
	}
	public function editAction(){
		$cus = new Admin_Model_Customer();
		$id  = $this->_request->getParam('id');
        $catname = $this->_request->getParam('txtCatName');    
        $catdes = $this->_request->getParam('txtCatDes');   
		if($this->_request->isPost()){ 
			$cus_name = $this->_request->getParam('cus_name');
            $cus_email = $this->_request->getParam('cus_email');
			$cus_phone = $this->_request->getParam('cus_phone');
			$cus_add = $this->_request->getParam('cus_add');
			//upload image
			$file       = $_FILES['avatar'];
			$url        = APP_PATH.'/templates/admin/images/upload/avatar/';
			$arrAllowEx =array('jpg','jpeg','png','gif','bmp');
			$maxSize    = 5242880;
			if($file['name']!=''){
				$ava = $upload->uploadFile($file,$url,$arrAllowEx,$maxSize);
			}
			$errcn='';
			$errcm='';
			$errcp='';
			$errcadd='';
			$errcava='';
			$data=array();
			if($cus_name==''){
				$errcn = "Please fill customer name!";
				$data['cus_name']='';
			}else{
				$data['cus_name']=$cus_name;
			}
			if($cus_email==''){
               $errcm = 'Please fill customer email!';
               $data['cus_email']='';
            }else{
               $data['cus_email']=$cus_email;
            } 
			if($cus_phone==''){
               $errcp = 'Please fill customer phone number!';
               $data['cus_phone']='';
            }else{
               $data['cus_phone']=$cus_phone;
            } 
			if($cus_add==''){
               $errcadd = 'Please fill customer address!';
               $data['cus_address']='';
            }else{
               $data['cus_address']=$cus_add;
            } 
			if($file['name']!=''){
				if($ava=='-1'){
					$errcava='extension file is not valid.</br>';
				}
				if($ava=="-2"){
					$errcava.='abc file is not valid.</br>';
				} else {
					$data['cus_avatar']=$ava;
				}
			} else {
				$data['cus_avatar']='no_avatar.png';
				$ava = 'no_avatar.png';		
			}
			if($errcn!='' || $errcm!=='' || $errcp!=='' || $errcadd!=='' || $errcava!==''){
                $this->view->errcn = $errcn;
				$this->view->errcm = $errcm;
				$this->view->errcp = $errcp;
				$this->view->errcadd = $errcadd;
				$this->view->errcava = $errcava;
                $this->view->cus = $data;
             }else{
                $check = $cus->addCustomer($cus_name,$cus_add,$cus_email,$cus_phone,$ava);
                if($check){
                    $this->_redirect('/admin/customer/index');
                }
             }
		}else{
		      $this->view->cus = $cus->getCustomer($id);
		}
	}
	
	public function deleteAction(){
		$cus = new Admin_Model_Customer();
        $id = $this->_request->getParam('id');
		$check = $cus ->delete('cus_id IN('.$id.')');
		if($check){
			$this->_redirect('/admin/customer/index');
		}
	}

}