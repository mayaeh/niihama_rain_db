<?php

function colmun_exists ($rain_date, $rain_time_array) {

	$db = 
	$query = 
	$db_st = 
	$db_res = 
	$db_res_array = 
	$row = 
	$col = 
	$nothing_col_array = 
	null ;

	if ( ! $rain_date or ! is_array ($rain_time_array) ) { 

		return null ;
	}

	$db = new SQLite3 (DB_FILE) ;

	$query = "SELECT * FROM rain WHERE date = '" . 
		$rain_date . "' ORDER BY time ;" ;

	$db_res = $db -> query ($query) ;

	// [0] は使用しない
	$db_res_array ['time'][0] = null ;

	while ($row = $db_res -> fetchArray (SQLITE3_ASSOC) ) {

		if (array_get_value ($row, 'time', "") ) {

			$db_res_array ['time'] [] =
				$row ['time'] ;
		}
	}

// for debug
//var_dump ($db_res_array) ;
//exit ;

	for ($i = 1; $i < count ($rain_time_array); $i ++ ) {

		if ( array_search ( $rain_time_array [$i], 
			$db_res_array ['time'] ) === FALSE ) {

			$nothing_col_array [] = $i ;
		}
	}

	$db -> close () ;

	return $nothing_col_array ;

}
?>
