<?php
class Admin_Model_Customer extends Zend_Db_Table_Abstract{
	protected $_name = 'customer';
	
	public function getAllCustomer(){
        $sql = $this->_db->select()
                         ->from($this->_name)
                         ->where('1=1')
                         ->order('cus_id asc');
                                
        return $this->_db->fetchAll($sql);
    }
	
	public function getCustomer($id){
        $sql = $this->_db->select()
                         ->from($this->_name)
                         ->where('cus_id='.$id);    
        return $this->_db->fetchRow($sql);   
    }
	
	public function addCustomer($cus_name, $cus_add,$cus_mail, $cus_phone, $cus_ava){
		$arrdata = array(
            'cus_name' 		=> $cus_name,
            'cus_address'  	=> $cus_add,
			'cus_email'  	=> $cus_mail,
			'cus_phone'  	=> $cus_phone,
			'cus_avatar'  	=> $cus_ava
        );
		return $this->insert($arrdata);
	}
	
	public function editCustomer($cus_name, $cus_add,$cus_mail, $cus_phone, $cus_ava, $cond){
        
        $arrdata = array(
            'cus_name' 		=> $cus_name,
            'cus_address'  	=> $cus_add,
			'cus_email'  	=> $cus_mail,
			'cus_phone'  	=> $cus_phone,
			'cus_avatar'  	=> $cus_ava
        );
        return $this->update($arrdata,'cus_id='.$cond);
    }
}