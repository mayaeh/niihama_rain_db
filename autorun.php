<?php

require_once ('config.php') ;

$rain_date =
$rain_time_array =
$rain_data_array =
$mkdata_res_array = 
$res = 
$msg = 
$msg_array = 
null ;

$mkdata_res_array = mkdata (RAIN_DATA_PATH) ;

if ( ! is_array ($mkdata_res_array) ) {

	$msg_array = $mkdata_res_array ;
}
else {

	if ( list ($rain_date, $rain_time_array, $rain_data_array) = 
		$mkdata_res_array ) {

		$res = colmun_check 
			($rain_date, $rain_time_array, $rain_data_array) ;

		if ( $res != '1' ) {

			var_dump ($res) ;
		}
	}
	else {

		$msg = "mkdata_res_array split failed." ;
		echo $msg . "\n" ;
		access_log_writer (time(), $msg) ;
	}
}

?>
