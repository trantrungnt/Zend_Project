<?php
class Admin_Model_Product extends Zend_Db_Table_Abstract{
	protected $_name = 'product';
	
	public function getAllProduct(){
        $sql = $this->_db->select()
                         ->from($this->_name)
                         ->where('1=1')
                         ->order('pro_id desc');
                                
        return $this->_db->fetchAll($sql);
    }
	
	public function getSubProduct($subcatid){
		$sql = $this->_db->select()
                         ->from($this->_name)
                         ->where('subcat_id ='.$subcatid)
                         ->order('pro_id desc');
                                
        return $this->_db->fetchAll($sql);
	}
	public function getProduct($id){
        $sql = $this->_db->select()
                         ->from($this->_name)
                         ->where('pro_id='.$id);    
        return $this->_db->fetchRow($sql);   
    }
	
	public function getColor(){
		$sql = $this->_db->select()
						 ->from('colors')
						 ->where('1=1')
						 ->order('col_id desc');
		return $this->_db->fetchAll($sql);
	}
	
	public function getSize(){
		$sql = $this->_db->select()
					  ->from('size')
					  ->where('1=1')
					  ->order('siz_id desc');
		return $this->_db->fetchAll($sql);
	}
	
	public function addProduct($subcat_id,$col_id,$siz_id,$proname,$proprice,$proquantity,$proimg,$prodes){
		$arrdata = array(
			'subcat_id'   => $subcat_id,
			'col_id'      => $col_id,
			'siz_id'      => $siz_id,
			'pro_name'    => $proname,
			'pro_price'   => $proprice,
			'pro_quantity'=> $proquantity,
			'pro_img'     => $proimg,
            'pro_des'     => $prodes,
		);
		return $this->insert($arrdata);
	}
	
	
	public function editProduct($subcat_id,$col_id,$siz_id,$proname,$proprice,$proquantity,$prodes,$cond,$proimg=''){
        
        $arrdata = array(
			'subcat_id'   => $subcat_id,
			'col_id'      => $col_id,
			'siz_id'      => $siz_id,
			'pro_name'    => $proname,
			'pro_price'   => $proprice,
			'pro_quantity'=> $proquantity,
            'pro_des'     => $prodes,
        );
		if($proimg!=''){
			$arrdata['pro_img']=$proimg;
		}
        return $this->update($arrdata,'pro_id='.$cond);
    }
	
	//upload
	public function getExtension($str){
		$arrDot=explode('.',$str);// cat chuoi ra thanh mang voi ki tu .
		$extension=end($arrDot);// lay fan tu cuoi trong mang
		return $extension;
	}
	
	public function uploadFile($file,$url,$arrAllowEx,$maxSize){
		$fName=strtolower($file['name']);// lay ten file duoc upload len vidu: banner.gif
		$tmpfName=$file['tmp_name'];// file luu tru tam thoi cua file dc upload len 
		$fSize=$file['size'];// dung luong cua file duoc upload
		$extension=$this->getExtension($fName);
		if(!in_array($extension, $arrAllowEx)){
			return "-1"; //phan mo rong khong hop le
		}
		if($fSize>$maxSize){
			return "-2";// Kick thuoc file vuot qua qui dinh
		}
		$fNewName=time().'_'.$fName;
		$url=$url.$fNewName;
		if(move_uploaded_file($tmpfName,$url)){
			@chmod($fNewName,776);
			return $fNewName;
		}
	}
	
	
	public function uploadMultiFile($filename,$filesize,$filetmp,$url,$arrAllowEx,$maxSize){
		$fName=strtolower($filename);// lay ten file duoc upload len vidu: banner.gif
		$tmpfName=$filetmp;// file luu tru tam thoi cua file dc upload len 
		$fSize=$filesize;// dung luong cua file duoc upload
		$extension=$this->getExtension($fName);
		if(!in_array($extension, $arrAllowEx)){
			return "-1"; //phan mo rong khong hop le
		}
		if($fSize>$maxSize){
			return "-2";// Kick thuoc file vuot qua qui dinh
		}
		$fNewName=time().'_'.$fName;
		$url=$url.$fNewName;
		if(move_uploaded_file($tmpfName,$url)){
			@chmod($fNewName,776);
			return $fNewName;
		}
	}
}