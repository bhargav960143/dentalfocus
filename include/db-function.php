<?php
class alldbfunction{
	function insertRecords($df_table_name,$array_insert,$return_type = false){
		global $wpdb;
		$qryInsert = "INSERT INTO $df_table_name";
		$keyParameter = '';
		$valueParameter = '';
		$totalParameter = count($array_insert);
		$i = 0;
		foreach($array_insert as $keyField => $valueField){
			if(($totalParameter - 1) > $i){
				$keyParameter .=  $keyField . ',';
				$valueParameter .=  "'" . $valueField . "'" . ',';
			}
			else{
				$keyParameter .=  $keyField;
				$valueParameter .=  "'" . $valueField . "'";
			}
			$i++;
		}
		$qryInsert .= "($keyParameter) VALUES ($valueParameter)";
		$wpdb->query($qryInsert);
		if($return_type){
			return $wpdb->insert_id;
		}
		else{
			return true;	
		}
	}
	
	function selectAllRecords($df_table_name,$array_condition,$order_by,$return_type = true){
		global $wpdb;
		$qrySelect = "SELECT * FROM $df_table_name";
		$resData = $wpdb->get_results($qrySelect, ARRAY_A);
		if (count($resData) > 0) {
			return $resData;	
		}
		else{
			return 0;	
		}
	}
	
	function editRecords($df_table_name,$array_condition,$return_type = true){
		global $wpdb;
		$editParameter = '';
		$totalParameter = count($array_condition);
		$i = 0;
		foreach($array_condition as $keyField => $valueField){
			if(($totalParameter - 1) > $i){
				$editParameter .= $keyField . " = " . $valueField . " AND ";
			}
			else{
				$editParameter .= $keyField . " = " . $valueField;
			}
			$i++;
		}
		$qryEdit = "SELECT * FROM $df_table_name WHERE $editParameter";
		$resData = $wpdb->get_row($qryEdit, ARRAY_A);
		
		if (count($resData) > 0) {
			return $resData;	
		}
		else{
			return 0;	
		}
	}
	
	function updateRecords($df_table_name,$array_update_data,$array_condition,$return_type = true){
		global $wpdb;
		$editParameter = '';
		$totalCondition = count($array_condition);
		$totalParameter = count($array_update_data);
		$setParameter = '';
		$conditionParameter = '';
		$i = 0;
		foreach($array_condition as $keyField => $valueField){
			if(($totalCondition - 1) > $i){
				$conditionParameter .= $keyField . " = '" . $valueField . "' AND ";
			}
			else{
				$conditionParameter .= $keyField . " = '" . $valueField . "'";
			}
			$i++;
		}
		$i = 0;
		foreach($array_update_data as $keyField => $valueField){
			if(($totalParameter - 1) > $i){
				$setParameter .= $keyField . " = '" . $valueField . "' , ";
			}
			else{
				$setParameter .= $keyField . " = '" . $valueField . "'";
			}
			$i++;
		}
		$qryUpdate = "UPDATE $df_table_name SET $setParameter WHERE $conditionParameter";
		
		$wpdb->query($qryUpdate);
		if($return_type){
			return true;
		}
		else{
			return true;	
		}
	}
	
	function deleteRecords($df_table_name,$array_condition,$return_type = false){
		global $wpdb;
		$deleteParameter = '';
		$totalParameter = count($array_condition);
		$i = 0;
		foreach($array_condition as $keyField => $valueField){
			if(($totalParameter - 1) > $i){
				$deleteParameter .= $keyField . " = " . $valueField . " AND ";
			}
			else{
				$deleteParameter .= $keyField . " = " . $valueField;
			}
			$i++;
		}
		$qryDelete = "DELETE FROM $df_table_name WHERE $deleteParameter";
		$wpdb->query($qryDelete);
		if($return_type){
			return true;
		}
		else{
			return true;	
		}
	}
}
?>