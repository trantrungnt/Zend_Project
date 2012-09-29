<?php
class Admin_Model_Promotion extends Zend_Db_Table_Abstract{
	protected $_name = 'promotion';
	
	public function getAllPromotion(){
        $sql = $this->_db->select()
                         ->from($this->_name)
                         ->where('1=1')
                         ->order('prom_id desc');
                                
        return $this->_db->fetchAll($sql);
    }
    
    	public function getPromotion($id){
    	   $sql = $this->_db->select()
                         ->from($this->_name)
                         ->where('prom_id ='.$id)
                         ->order('prom_id desc');
                                
        return $this->_db->fetchRow($sql);
    	}
    
    public function addPromotion($name,$saleoff,$start,$end,$proid){
        $arrdata = array(
			'name' => $name,
            'saleoff'  => $saleoff,
			'start_date'	   => $start,
            'end_date'	   => $end,
            'arr_id'	   => $proid
		);
		return $this->insert($arrdata);
    }
	
    public function editPromotion($name,$saleoff,$start,$end,$proid,$id){
        $arrdata = array(
			'name' => $name,
            'saleoff'  => $saleoff,
			'start_date'	   => $start,
            'end_date'	   => $end,
            'arr_id'	   => $proid,
		);
		return $this->update($arrdata,'prom_id='.$id);
    }
}