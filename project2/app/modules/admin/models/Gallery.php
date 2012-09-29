<?php
class Admin_Model_Gallery extends Zend_Db_Table_Abstract{
	protected $_name = 'gallery_product';
	
	public function addGallery($proid,$img){
		$arrdata = array(
			'pro_id'   => $proid,
			'gal_img'  => $img
		);
		return $this->insert($arrdata);
	}
	
	
}