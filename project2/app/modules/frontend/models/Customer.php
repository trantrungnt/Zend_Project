<?php
class Frontend_Model_Customer extends Zend_Db_Table_Abstract{
	protected $_name = 'customer';
	public function addCustomer($cus_email, $cus_pass){
		$params = array(
			'cus_email' => $cus_email,
			'cus_pass'	=> $cus_pass
		);		
		return $this->insert($params);
	}
	public function checkAccount($cus_email){
		$sql = $this->_db->select()
					->from($this->_name,array('cus_email'))
					->where('1=1');
		$cus = $this->_db->fetchAll($sql);	
		$email = array();
		foreach($cus as $k=>$v){
			$email[] = $v['cus_email'];
		}	
		if(count($email)!=0){
			if(in_array($cus_email,$email)){
				return true;
			}
			//return false;
		}
		return false;
	}
	public function getCusId($cus_email){
		$sql = $this->_db->select()
						->from('customer')
						->where('cus_email=?',$cus_email);
		$result = $this->_db->fetchRow($sql);
		return $result['cus_id'];
	}
	
}