<?php
class Frontend_Model_Product extends Zend_Db_Table_Abstract{
    
    public function getAllProduct(){
        $sql=$this->_db->select()
                       ->from('product')
                       ->where('1=1');
        return $this->_db->fetchAll($sql);                       
    }
    
    public function getProduct($sql){
        return $this->_db->fetchAll($sql);
    }
    public function getDetailProduct($id){
        $sql=$this->_db->select()
                        ->from(array('p'=>'product'))
						->join(array('sc'=>'subcategory'),'p.subcat_id=sc.subcat_id',array('subcaturl'=>'url','subcat_name'))
						->join(array('c'=>'category'),'sc.cat_id=c.cat_id',array('caturl'=>'url','cat_name'))
                        ->where('p.pro_id='.$id);
        return $this->_db->fetchRow($sql);     
    }
	public function getPromotion(){
        $sql=$this->_db->select()
                        ->from('promotion')
                        ->where('CURDATE() BETWEEN start_date AND end_date');
        return $this->_db->fetchAll($sql);                        

    }
    
    public function getProductSaleoff(){
        $promotion=$this->getPromotion();
           foreach($promotion as $item){
                $arrproduct=explode(',',$item['arr_id']);
                foreach($arrproduct as $row){
                    $check=@$pr[$row];
                    if(isset($check) and $check!=''){
                        if($check>$item['saleoff']){
                            $pr[$row]=$check;
                        }else{
                            $pr[$row]=$item['saleoff'];
                        }
                    }else{
                        $pr[$row]=$item['saleoff'];
                    }
                }
           }
           
           return $pr;
    }
    
    public function getSlideProduct($listproid){
        $sql=$this->_db->select()
                       ->from('product')
                       ->where('pro_id IN('.$listproid.')');
        return $this->_db->fetchAll($sql);   
    }
	
	public function getProductbyId($id){
		$sql = $this->_db->select()
						->from('product')
						->where('pro_id='.$id);
		return $this->_db->fetchRow($sql);
	}
	public function getGalImages($id){
		$sql = $this->_db->select()
						->from('gallery_product')
						->where('pro_id=?',$id);
		return $this->_db->fetchAll($sql);
	}
	
	public function getRelatedProduct($id){
		$sql = $this->_db->select()
						->from('product',array('subcat_id'))
						->where('pro_id='.$id);
		$result = $this->_db->fetchRow($sql);
		$sql = $this->_db->select()
						->from('product')
						->where('subcat_id=?',$result['subcat_id'])
						->limit(4);
		return $this->_db->fetchAll($sql);
	}
	
	public function getComment($productId){
		$sql=$this->_db->select()
				->from('comment')
				->where('pro_id='.$productId);
		return $this->_db->fetchAll($sql);
	}
	public function insertComment($cus_name, $cus_email, $com_content,$pro_id,$date_create){
		$arrdata=array(
			'cus_name'=>$cus_name,
			'cus_email'=>$cus_email,
			'com_content'=>$com_content,
			'pro_id'=>$pro_id,
			'date_create'=>$date_create,
		);
		return $this->_db->insert('comment',$arrdata);
	}
	public function getAllProductIds(){
		$sql = $this->_db->select()
				->from('product',array('pro_id'))
				->where('1=1');
		return $this->_db->fetchAll($sql);
	}
	public function getQtyOrder($pro_id){
		
		$sql = "select sum(q),product_id from ((SELECT product_id, product_qty as q FROM order_item WHERE product_id = $pro_id) as tbl)";
		return $this->_db->fetchRow($sql);
	}
	public function getGallery($proid){
        $sql=$this->_db->select()
                       ->from('gallery_product')
                       ->where('pro_id ='.$proid);
        return $this->_db->fetchAll($sql); 
    }
	
	
}