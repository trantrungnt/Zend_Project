<?php
class Frontend_Model_Global extends Zend_Db_Table_Abstract{
	public function checkEmail($email){
		if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){
			return true;
		}
		return false;
	}
}