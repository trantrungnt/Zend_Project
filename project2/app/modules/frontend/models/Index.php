<?php
class Frontend_Model_Index extends Zend_Db_Table_Abstract{
	protected $_name='category';
	
	public function getCategories(){
		$sql = $this->_db->select()
                         ->from($this->_name)
                         ->where('1=1');
        return $this->_db->fetchAll($sql);
	}
	
	public function getSubcat(){
		$sql = $this->_db->select()
                         ->from('subcategory')
                         ->where('1=1');
        return $this->_db->fetchAll($sql);
	}
	
	public function getCategoryName($url){
		$sql=$this->_db->select()
                        ->from('category')
                        ->where('url="'.$url.'"');
        return $this->_db->fetchRow($sql); 
	}
	public function getPromotion(){
        $sql=$this->_db->select()
                        ->from('promotion')
                        ->where('CURDATE() BETWEEN start_date AND end_date');
        return $this->_db->fetchAll($sql);                        

    }
	
}