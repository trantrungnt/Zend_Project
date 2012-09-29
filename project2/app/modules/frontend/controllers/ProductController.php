<?php 
class ProductController extends Zend_Controller_Action{
	public function preDispatch(){
        if ($this->_request->getActionName() == 'detail'){
			$session = new Zend_Session_Namespace('comment');
			$pro_id = $this->_request->getParam('id');
			$comment = new Frontend_Model_Product();
			$result = $comment->getComment($pro_id);
			$session->result = $result;
		}
    }
	public function indexAction(){
	    Zend_Session::start();
        $sql='select * from product as p inner join subcategory as sc on p.subcat_id=sc.subcat_id ';
        $where=' where 1=1 ';
		$pr=array();
        $product=new Frontend_Model_Product();
        
        $name=$this->_getParam('name');
		$subname=$this->_getParam('subname');
		$cond = new Zend_Session_NameSpace();
		//echo 'asfasf';die;
		if($name!='' and $subname==''){
			$cond->catname=$name;
			unset($cond->subcatname);
			$innerjoin=" inner join category as c on c.cat_id = sc.cat_id";
			$where.=" and c.url='".$name."'";
			
		}
		if($name!='' and $subname!=''){
			$cond->catname=$name;
			$cond->subcatname=$subname;
			$innerjoin=" inner join category as c on c.cat_id = sc.cat_id";
			$where.=' and c.url="'.$name.'" and sc.url="'.$subname.'"';
			
		}
		
		if($name=='' and $subname==''){
			if(isset($cond->catname) and !isset($cond->subcatname)) {
				$innerjoin=" inner join category as c on c.cat_id = sc.cat_id";
				$where.=" and c.url='".$cond->catname."'";
			}else{
				$innerjoin=" inner join category as c on c.cat_id = sc.cat_id";
				$where.=' and c.url="'.$cond->catname.'" and sc.url="'.$cond->subcatname.'"';
			}
		}		
		
        $sql.=$innerjoin.$where;
        $data=$product->getProduct($sql);
		
		$currentPage=$this->_getParam('page');
        if(!isset($currentPage) or $currentPage==''){
            $currentPage=1; 
        }       
       
       
        $paginator = Zend_Paginator::factory($data);
        $paginator->setItemCountPerPage(6)
                  ->setPageRange(3)//so page muon hien thi
                  ->setCurrentPageNumber($currentPage);
        
        //print_r($paginator);die;
        $this->view->product=$paginator;
		$this->view->promotion=$product->getProductSaleoff();
	}
	
	public function detailAction(){
		$layoutPath = APP_PATH . '/templates/frontend/';
        $option = array ('layout'     => 'detail',
                         'layoutPath' => $layoutPath,
                         'contentKey' => 'content' );
        Zend_Layout::startMvc( $option );
		$product=new Frontend_Model_Product();
		$this->view->promotion=$product->getProductSaleoff();
		$global = new Frontend_Model_Global();
		$paramarr = $this->_request->getParams();
        $this->view->product=$product->getDetailProduct($paramarr['id']);
	
		$session = new Zend_Session_Namespace('comment');
        $this->view->result = $session->result;
		
		
		
		$id=$paramarr['id'];
		$gallery = $product->getGallery($id);
        $this->view->gallery = $gallery;
		$date_create = date('Y-m-d',time());
		
		if($this->_request->isPost()){
			$dosave = 0;
			$err_content = '';
			$err_name = '';
			$err_email = '';
			$data = array();
			$com_content = $this->_request->getParam('body');
			$cus_name = $this->_request->getParam('name');
			$cus_email = $this->_request->getParam('email');
			//echo 123; exit;
			if($com_content == ''){
				$err_content = 'Content is not empty';
				$dosave = -1;
				$this->view->error_content = $err_content;
			} else {
				$data['content']=$com_content;
				$this->view->data = $data;
			}
			if($cus_name == ''){
				$err_name = 'Your name is not empty';
				$dosave = -1;
				$this->view->error_name = $err_name;
			} else {
				$data['name']=$cus_name;
				$this->view->data = $data;
			}
			if($cus_email == ''){
				$err_email = 'Your email is not empty';
				$dosave = -1;
				$this->view->error = $err_email;
			} else {
				if(!$global->checkEmail($cus_email)){
					$err_email = 'Your email is invalid!';
					$dosave = -1;
					$this->view->error = $err_email;
					$data['cus_email']=$cus_email;
					$this->view->data = $data;
				}
			}
			if($dosave == 0){
				$flag = $product->insertComment($cus_name,$cus_email,$com_content,$id,$date_create);
				if($flag){
					$this->_redirect('/product/detail/id/'.$id);
				}
			}	
		}
	}
	
	public function bestsellerAction(){
		
	}
	
	
}