<?php 
class Admin_ProductController extends Zend_Controller_Action{
	
	public function init(){
        $layoutPath = APP_PATH . '/templates/admin/';
        $option = array ('layout'     => 'index',
                         'layoutPath' => $layoutPath,
                         'contentKey' => 'content' );
        Zend_Layout::startMvc( $option );
    }
	
	public function indexAction(){
		$subcat = new Admin_Model_Subcat();
		$arrsc  = $subcat->getAllSubcat();
		$this->view->subcat = $arrsc;
		
		$pro = new Admin_Model_Product();
		$data = $pro->getAllProduct(); 
		$colors = $pro->getColor();
		$sizes  = $pro->getSize();
		//$this->view->data = $arrpro;
		$this->view->color = $colors;
		$this->view->size  = $sizes;
		
		$currentPage=$this->_getParam('page');
       if(!isset($currentPage) or $currentPage==''){
            $currentPage=1; 
       }       
       
       
        $paginator = Zend_Paginator::factory($data);
        $paginator->setItemCountPerPage(10)
                  ->setPageRange(3)//so page muon hien thi
                  ->setCurrentPageNumber($currentPage);
        
        //print_r($paginator);die;
        $this->view->product=$paginator;
	}
	
	public function addAction(){
		$cat    = new Admin_Model_Cat();
		$arrcat = $cat->getAllCategory();
		$this->view->cat = $arrcat;
		
		$subcat    = new Admin_Model_Subcat();
		$arrsubcat = $subcat->getAllSubcat();
		$this->view->subcat = $arrsubcat;
		
		$product = new Admin_Model_Product();
		$color   = $product->getColor();
		$this->view->color = $color;
		
		$size    = $product->getSize();
		$this->view->size  = $size;
		
		$gal =  new Admin_Model_Gallery();
		
		//print_r($color);die;
		if($this->_request->isPost()){
			$subcat      = $this->_request->getParam('subcatname');
			$proname     = $this->_request->getParam('proname');
			$proprice    = $this->_request->getParam('proprice');
			$proquantity = $this->_request->getParam('proquantity');
			$procolor    = $this->_request->getParam('procolor');
			$prosize     = $this->_request->getParam('prosize');
            $prodes      = $this->_request->getParam('prodes');
			//$imggal      = $this->_request->getParam('imggalflag');
			$filearr     = $_FILES['imggal'];
			//upload image
			$file       = $_FILES['proimg']; 
			$url        = APP_PATH.'/templates/admin/images/upload/product/';
			$arrAllowEx =array('jpg','jpeg','png','gif','bmp');
			$maxSize    =5242880;
			$proimg      =$product->uploadFile($file,$url,$arrAllowEx,$maxSize);
			$proimgful = '/app/templates/admin/images/upload/product/'.$proimg ;
			//echo $proimgful;die;
			$data=array();
			$errsc = '';
			$errpname = '';
			$errprice = '';
			$errquantity = '';
			$errcolor = '';
			$errsize = '';
			$errimg = '';
			$errdes = '';
			if($subcat==-1){
				$errsc='Please choose subcategory.';
				$data['subcat_id'] = '';
			}else{
				$data['subcat_id'] = $subcat;
			}
			if($proname==''){
				$errpname='Product name must be not null.';
				$data['pro_name']='';
			}else{
				$data['pro_name']=$proname;
			}
			if($proprice==""){
				$errprice = 'Product price must be not null';
				$data['pro_price'] = '';
			}else{
				$data['pro_price'] = $proprice;
			}
			if($proquantity==""){
				$errquantity = 'proquantity must be not null';
				$data['pro_quantity'] = '';
			}else{
				$data['pro_quantity'] = $proquantity;
			}
			
			if($procolor==-1){
				$errcolor = 'Please choose color for the product';
				$data['col_id'] = '';
			}else{
				$data['col_id'] = $procolor;
			}
			
			if($prosize==-1){
				$errsize = 'Please choose size for the product';
				$data['siz_id'] = '';
			}else{
				$data['siz_id'] = $prosize;
			}
			if($proimg=='-1'){
				$errimg=' extension file is not valid.</br>';
				$data['pro_img']='';
			}elseif($proimg=="-2"){
				$errimg.='file is not valid.';
				$data['pro_img']='';
			}else{
				$data['pro_img']=$proimgful;
			}
			
			if($prodes==''){
				$errdes=' prodes must be not null.';
				$data['pro_des']='';
			}else{
				$data['pro_des']=$prodes;
			}			
			if($errsc!='' || $errpname!='' || $errprice!='' || $errquantity!='' || $errcolor!='' || $errsize!='' || $errimg!='' || $errdes!=''){
                $this->view->errsc = $errsc;
				$this->view->errpname = $errpname;
				$this->view->errprice = $errprice;
				$this->view->errquantity = $errquantity;
				$this->view->errcolor = $errcolor;
				$this->view->errsize = $errsize;
				$this->view->errimg = $errimg;
				$this->view->errdes = $errdes;
                $this->view->product = $data;
            }else{
               $check = $product->addProduct($subcat,$procolor,$prosize,$proname,$proprice,$proquantity,$proimgful,$prodes);
                if($check){
				    for($i=0;$i<count($filearr['name']);$i++){
						$url        = APP_PATH.'/templates/admin/images/upload/gallery/';
						$arrAllowEx =array('jpg','jpeg','png','gif','bmp');
						$maxSize    =5242880;
						$proimg      =$product->uploadMultiFile($filearr['name'][$i],$filearr['size'][$i],$filearr['tmp_name'][$i],$url,$arrAllowEx,$maxSize);
						//echo  $proimg;die;
						$urlgal  =  '/app/templates/admin/images/upload/gallery/'.$proimg ;						
						$gal->addGallery($check,$urlgal);
						
					} 
                    $this->_redirect('/admin/product/index');
                }
				
            }
			
		}
	}

	public function editAction(){
		$subcat = new Admin_Model_Subcat();
		$arrsubcat = $subcat->getAllSubcat();
		$this->view->subcat = $arrsubcat;
		$id  = $this->_request->getParam('id');
		$product = new Admin_Model_Product();
		$data    = $product->getProduct($id);
		
		$color   = $product->getColor();
		$this->view->color = $color;
		
		$size    = $product->getSize();
		$this->view->size  = $size;
		
		
		$subcat      = $this->_request->getParam('subcatname');
		$proname     = $this->_request->getParam('proname');
		$proprice    = $this->_request->getParam('proprice');
		$proquantity = $this->_request->getParam('proquantity');
		$procolor    = $this->_request->getParam('procolor');
		$prosize     = $this->_request->getParam('prosize');
		$prodes      = $this->_request->getParam('prodes');
		$idelimg      = $this->_request->getParam('idelimg');
		if($this->_request->isPost()){
			if($idelimg=='1'){
				$file = $_FILES['newimg']; 
				$url        = APP_PATH.'/templates/admin/images/upload/product/';
				$arrAllowEx =array('jpg','jpeg','png','gif','bmp');
				$maxSize    =5242880;
				$proimg      =$product->uploadFile($file,$url,$arrAllowEx,$maxSize);
				$proimgful = '/app/templates/admin/images/upload/product/'.$proimg ;
				//echo APP_PATH.$data['pro_img'];die;
				if(file_exists(APP_PATH_IMG.$data['pro_img'])){
					unlink(APP_PATH_IMG.$data['pro_img']);
				}
			}
			/* //upload image
			$file       = $_FILES['proimg']; 
			$url        = APP_PATH.'/templates/admin/images/upload/product/';
			$arrAllowEx =array('jpg','jpeg','png','gif','bmp');
			$maxSize    =5242880;
			$proimg      =$product->uploadFile($file,$url,$arrAllowEx,$maxSize); */
			$data=array();
			$errsc = '';
			$errpname = '';
			$errprice = '';
			$errquantity = '';
			$errcolor = '';
			$errsize = '';
			$errimg = '';
			$errdes = '';
			if($subcat==-1){
				$errsc='Please choose subcategory.';
				$data['subcat_id'] = '';
			}else{
				$data['subcat_id'] = $subcat;
			}
			if($proname==''){
				$errpname='Product name must be not null.';
				$data['pro_name']='';
			}else{
				$data['pro_name']=$proname;
			}
			if($proprice==""){
				$errprice = 'Product price must be not null';
				$data['pro_price'] = '';
			}else{
				$data['pro_price'] = $proprice;
			}
			if($proquantity==""){
				$errquantity = 'proquantity must be not null';
				$data['pro_quantity'] = '';
			}else{
				$data['pro_quantity'] = $proquantity;
			}
			
			if($procolor==""){
				$errcolor = 'procolor must be not null';
				$data['pro_price'] = '';
			}else{
				$data['pro_price'] = $procolor;
			}
			
			if($prosize==-1){
				$errsize = 'prosize must be not null';
				$data['pro_price'] = '';
			}else{
				$data['pro_price'] = $prosize;
			}
			if($proimg==-1){
				$errimg=' extension file is not valid.</br>';
				$data['pro_img']='';
			}elseif($proimg==-2){
				$errimg.='file is not valid.';
				$data['pro_img']='';
			}else{
				$data['pro_img']=$proimg;
			}
			
			if($prodes==''){
				$errdes=' prodes must be not null.';
				$data['pro_des']='';
			}else{
				$data['pro_des']=$prodes;
			}			
			if($errsc!='' || $errpname!='' || $errprice!='' || $errquantity!='' || $errcolor!='' || $errsize!='' || $errimg!='' || $errdes!=''){
                $this->view->errsc = $errsc;
				$this->view->errpname = $errpname;
				$this->view->errprice = $errprice;
				$this->view->errquantity = $errquantity;
				$this->view->errcolor = $errcolor;
				$this->view->errsize = $errsize;
				$this->view->errimg = $errimg;
				$this->view->errdes = $errdes;
                $this->view->product = $data;
             }else{
                $check = $product->editProduct($subcat,$procolor,$prosize,$proname,$proprice,$proquantity,$prodes,$id,$proimgful);
                if($check){
                    $this->_redirect('/admin/product/index');
                }
             }
			
		}else{
		      $this->view->product = $data;
		}
	}
	
	public function deleteAction(){
		$cat = new Admin_Model_Product();
        $id = $this->_request->getParam('id');
		$check = $cat ->delete('pro_id IN('.$id.')');
		if($check){
			$this->_redirect('/admin/product/index');
		}
	}
	
	public function getsubcatAction(){
		$catid = $this->_request->getParams('id');
		//$catid = $catid['id'];die;
		$subcat = new Admin_Model_Subcat();
		$subcats = $subcat->getSubCats($catid['id']);
		//print_r($subcats);die;
		$returnhtml = '
			<td>Subcategory: </td>
			<td>
				<select name="subcatname">
					<option value="-1">choose subcategory</option>
					';
					foreach($subcats as $subcat){
						$returnhtml .= '<option value="'.$subcat['subcat_id'].'">'.$subcat['subcat_name'].'</option>';
					}
				$returnhtml .= '</select>
			</td>
		';
		echo $returnhtml;exit;
	}

	
}