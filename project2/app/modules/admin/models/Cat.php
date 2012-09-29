<?php
class Admin_Model_Cat extends Zend_Db_Table_Abstract{
	protected $_name = 'category';
	
	public function getAllCategory(){
        $sql = $this->_db->select()
                         ->from($this->_name)
                         ->where('1=1')
                         ->order('cat_id desc');
                                
        return $this->_db->fetchAll($sql);
    }
	
	public function getCategory($id){
        $sql = $this->_db->select()
                         ->from($this->_name)
                         ->where('cat_id='.$id);    
        return $this->_db->fetchRow($sql);   
    }
	
	public function addCategory($catname,$catdes='',$caturl){
		$arrdata = array(
			'cat_name' => $catname,
            'cat_des'  => $catdes,
			'url'	   => $caturl
		);
		return $this->insert($arrdata);
	}
	
	public function editCategory($catname,$catdes='',$caturl,$cond){
        
        $arrdata = array(
            'cat_name' => $catname,
            'cat_des'  => $catdes,
			'url'      => $caturl
        );
        return $this->update($arrdata,'cat_id='.$cond);
    }
}