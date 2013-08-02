<?php

function process_today_data () {

	$rain_date =
	$rain_time_array =
	$rain_data_array =
	$db =
	$db_res =
	$latest_datetime = 
	$now_datetime = 
	$obj_latest_datetime = 
	$obj_now_datetime = 
	$interval = 
	$mkdata_res_array = 
	$res = 
	$msg = 
	$msg_array = 
	null ;


	// DB 内の最新データ日時を取得する

	$db = new SQLite3 (DB_FILE) ;

	$db_res = $db -> query (
		"SELECT date, time FROM rain ORDER BY date DESC, ". 
		"time DESC LIMIT 1 ;"
		) ;

	$db_res_array = $db_res -> fetchArray (SQLITE3_ASSOC) ;

	if ( array_get_value ($db_res_array, 'date', "") and 
		array_get_value ($db_res_array, 'time', "" ) ) {

		$latest_datetime = 
			$db_res_array ['date'] . " " . $db_res_array ['time'] ;

		// 現在日時との比較のため DateTime Object を取得
		$obj_latest_datetime = DateTime::createFromFormat 
			("Y-m-d H:i", $latest_datetime ) ;

		$now_datetime = date ("Y-m-d H:i") ;
		//$now_datetime = "2013-06-26 00:00" ;

		$obj_now_datetime = DateTime::createFromFormat 
			("Y-m-d H:i", $now_datetime ) ;

		// 現在日時との差を取得
		$interval = $obj_latest_datetime -> 
			diff ($obj_now_datetime) ;

// for debug
//var_dump ($interval) ;
//exit ;

		// 差が 1 時間以下の場合は終了する ( a: 総日数 9
		if ( ! $interval -> format ('%a') and 
			! $interval -> format ('%h') ) {

		return null ;
		}
	}

	$db -> close () ;
	$db = 
	$db_res = 
	$db_res_array = 
	null ;

	$mkdata_res_array = mkdata (RAIN_DATA_PATH_TODAY) ;

	if ( ! is_array ($mkdata_res_array) ) {

		return $mkdata_res_array ;
	}
	else {

		if ( list ($rain_date, $rain_time_array, $rain_data_array) 
			= $mkdata_res_array ) {

			$res = colmun_check 
				($rain_date, $rain_time_array, $rain_data_array) ;

			if ( $res != '1' ) {

				return $res ;
			}
		}
		else {

			$msg = "mkdata_res_array split failed." ;
			access_log_writer (time(), $msg) ;
			return $msg ;
		}
	}
	
	return 1 ;
}

?>
