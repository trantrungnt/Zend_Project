<?php
class Frontend_Model_Cart extends Zend_Db_Table_Abstract{
	public function getItem($id){
		$sql = $this->_db->select()
						->from('product')
						->where('pro_id='.$id);
		return $this->_db->fetchRow($sql);
	}
}