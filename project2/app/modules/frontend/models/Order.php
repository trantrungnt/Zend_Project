<?php 
class Frontend_Model_Order extends Zend_Db_Table_Abstract{
	public function getLastOrderId(){
		$sql = $this->_db->select()
					->from('order', array(new Zend_Db_Expr('max(order_id)')));
		return $this->_db->fetchRow($sql);
	}
	public function saveItems($ord_id,$cus_id,$cus_email,$cus_type,$total,$payment,$status){
		$paramarr = array(
			'order_id'=>$ord_id,
			'cus_id'=>$cus_id,
			'cus_email'=>$cus_email,
			'cus_type'=>$cus_type,
			'grand_total'=>$total,
			'payment_method'=>$payment,
			'status'=>$status
		);
		return $this->_db->insert('order',$paramarr);
	}
	public function getItem($id){
		$sql = $this->_db->select()
						->from('order')
						->where('id='.$id);
		return $this->_db->fetchRow($sql);
	}
	public function saveOrderItems($ord_id,$product_id,$product_qty){
		$paramarr = array(
			'order_id'=>$ord_id,
			'product_id'=>$product_id,
			'product_qty'=>$product_qty
		);
		return $this->_db->insert('order_item',$paramarr);
	}
}