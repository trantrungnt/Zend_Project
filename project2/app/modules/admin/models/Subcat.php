<?php
class Admin_Model_Subcat extends Zend_Db_Table_Abstract{
	protected $_name = 'subcategory';
	
	public function getAllSubcat(){
		$sql = $this->_db->select()
                         ->from(array('sc'=>$this->_name))
                         ->join(array('c'=>'category'),'sc.cat_id=c.cat_id','cat_name')
                         ->where('1=1')
                         ->order('subcat_id desc');
                                
        return $this->_db->fetchAll($sql);
	}
    
    public function checkHasChild($subcatid){
        $sql = $this->_db->select()
                         ->from('product','count(*)')
                         ->where('subcat_id='.$subcatid);
         return $this->_db->fetchOne($sql);               
    }
	
	public function getSubcat($id){
        $sql = $this->_db->select()
                         ->from($this->_name)
                         ->where('subcat_id='.$id);    
        return $this->_db->fetchRow($sql);   
    }
	
	public function getSubCats($catid){
		 $sql = $this->_db->select()
                         ->from($this->_name)
                         ->where('cat_id='.$catid);
        return $this->_db->fetchAll($sql);  
	}
	
	
	public function addSubcategory($catid,$subcatname,$subcatdes,$subcaturl){
		$arrdata = array(
			'cat_id' => $catid,
			'subcat_name' => $subcatname,
            'subcat_des'  => $subcatdes,
			'url'		  => $subcaturl
		);
		return $this->insert($arrdata);
	}
	
	public function editSubCategory($catid,$subcatname,$subcatdes='',$subcaturl,$cond){
        
        $arrdata = array(
			'cat_id' => $catid,
            'subcat_name' => $subcatname,
            'subcat_des'  => $subcatdes,
			'url'         => $subcaturl
        );
        return $this->update($arrdata,'subcat_id='.$cond);
    }
}