<?php
class Admin_Block_Function extends Zend_Db_Table_Abstract{
    function execSQL($sql){
		if($sql!=""){
			return mysql_query($sql);
		}
	}
	
	function getDataToArray($sql){
		$rs=$this->execSQL($sql);
		$arrData=array();
		while($row=@mysql_fetch_array($rs)){
			array_push($arrData,$row);
		}
		return $arrData;
	}
	
	function getComboBox($tbl,$vkey,$vdes,$boxName,$headMes,$focus=null,$where=null, $func=null){
		$sbox="<select name='".$boxName."' onchange='".$func."();'><option value='-1' selected='selected'>".$headMes."</option>";
		$where=(isset($where))?$where:' 1=1 ';
		$sql="SELECT $vkey,$vdes FROM $tbl WHERE $where";
		$rs=$this->getDataToArray($sql);
		foreach($rs as $row){
			$sbox.="<option value=".$row[$vkey]." >".$row[$vdes]."</option>";
		}
		$sbox.="</select>";
		$vBox=$focus;
		$sbox=str_replace("<option value=".$vBox." >","<option value=".$vBox." selected='selected' >",$sbox);
		return $sbox;
		
	}
    }