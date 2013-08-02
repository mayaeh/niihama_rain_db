<?php

function mkdata ($data_path) {

	$rain_html_data =
	$rain_html_data_array =
	$rain_date =
	$rain_time_array =
	$rain_data_array =
	$sampling_flg =
	$place_chk_flg =
	null ;

	if ( ! $data_path ) {

		$msg = "data-path not set." ;
		access_log_writer (time(), $msg) ;
		return $msg ;
	}

	// [0] は使用しない
	$rain_time_array [0] = null ;
	$rain_data_array [0] = null ;


	$rain_html_data = mb_convert_encoding ( file_get_contents 
		($data_path), "UTF-8", "sjis-win" ) ;

	$rain_html_data_array = 
		preg_split ( "/\r?\n/u", $rain_html_data ) ;

// for debug
//var_dump ( $rain_html_data_array ) ;
//exit; 

	for ( $i = 0; $i < count ($rain_html_data_array); $i ++ ) {

		if ( preg_match 
			("/(20[0-9]{2})年([0-9]{2})月([0-9]{2})日/u", 
			$rain_html_data_array [$i], $match_date_array ) ) {

// for debug
//var_dump ($match_date_array) ;
//exit ;

			$rain_date = $match_date_array [1] . "-" . 
				$match_date_array [2] . "-" . 
				$match_date_array [3] ;
		}

// for debug
//if ($rain_date) {
//var_dump ($rain_date) ;
//exit ;
//}

		else if ( preg_match ( "/>時間</u", 
			$rain_html_data_array [$i] ) ) {

				$place_chk_flg = 5 ;
			}


		else if ( preg_match ( "/>([0-9]{2}:[0-9]{2})</u", 
			$rain_html_data_array [$i], 
			$match_time_array ) ) {

			$rain_time_array [] = $match_time_array [1] ;

			$rain_data_array [] = null ;

			$sampling_flg = 5 ;
		}

// for debug
//if (array_get_value ( $rain_time_array, 1, "" )) {
//var_dump ($rain_time) ;
//var_dump ($rain_data_array) ;
//exit ;
//}

		else if ($place_chk_flg) {

			if ( ! preg_match ( 
				"/(一宮町|別子山|立川|大生院|多喜浜)/u", 
				$rain_html_data_array [$i] ) ) {

				$msg = "unknown place found. check homepage." ;

				access_log_writer (time(), $msg) ;

				return $msg ;
			}

			$place_chk_flg -- ;
		}


		else if ($sampling_flg) {

			$time_num = count ($rain_data_array) -1 ;

			if ( preg_match ( "/>([0-9]{1,3}\.[0-9])</u", 
				$rain_html_data_array [$i], 
				$match_rainfall_array ) ) {

				$rain_data_array [$time_num][] = 
					$match_rainfall_array [1] ;
			}

			$sampling_flg -- ;

// for debug
//if ( $i > 53 ) {
//var_dump ($rain_data_array) ;
//exit ;
//}

		}
	}

// for debug
//for ( $i = 1; $i < count($rain_time_array); $i ++ ) {
//echo $rain_time_array[$i].":\n";
//var_dump ($rain_data_array[$i]);
//}
//var_dump ($rain_time_array) ;
//exit ;

	return array ($rain_date, $rain_time_array, $rain_data_array) ;
}

?>
