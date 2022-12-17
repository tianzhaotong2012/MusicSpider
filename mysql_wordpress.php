<?php
require_once('config.php');


function insert_table($table_name,$new_record,$is_debug){
	$keys = array_keys($new_record);
	$values = array_values($new_record);
	$value_str = '';
	foreach($values as $value){
		if(is_numeric($value)){
		  $value_str .= $value . ',';
		}else{
	        $value_str .= "'" . $value . "',";
		}  
	}
	$value_str = substr($value_str,0,strlen($value_str)-1);
	$sql = sprintf('insert into %s (%s) values (%s)',$table_name,implode(",",$keys),$value_str);
	if($is_debug){
		var_dump($sql);
	}
	$con = mysql_connect(MYSQLHOST_,MYSQLUSER_,MYSQLPASS_);
      if(!$con){
        die('erro:' . mysql_error());
      	}
      mysql_select_db(MYDB_,$con);
      mysql_set_charset('utf8', $con); 
      $result = mysql_query($sql);
	$id = mysql_insert_id($con);
	return $id;
}

