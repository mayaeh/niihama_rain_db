<?php

function colmun_check ($rain_date, $rain_time_array, $rain_data_array) {

	$query = 
	$db = 
	$db_st = 
	$db_res = 
	$db_res_array = 
	$row = 
	$nothing_col_array = 
	null ;

	if ( ! $rain_date or ! is_array ($rain_time_array) or 
		! is_array ($rain_data_array) ) {

		return null ;
	}

	$nothing_col_array =
		colmun_exists ($rain_date, $rain_time_array) ;

// for debug
//var_dump ($nothing_col_array) ;
//exit ;

	if ( is_array ($nothing_col_array) ) {

		try {

			$db = new SQLite3 (DB_FILE) ;

			// トランザクションの開始
			$db -> exec ("BEGIN DEFERRED;") ;

			$db_st = $db -> prepare (
				"INSERT INTO rain " . 
				"(date, time, n_ikku, " . 
				"n_bessi, n_tatukawa, " . 
				"n_ojouin, n_takihama, " . 
				"year, month) VALUES (" . 
				":date, :time, :n_ikku, " . 
				":n_bessi, :n_tatukawa, " . 
				":n_ojouin, :n_takihama, " . 
				":year, :month)" ) ;

			for ( $i = 0; $i < count 
				($nothing_col_array); $i ++ ) {

				if ( 
					array_get_value ($rain_time_array, 
					$nothing_col_array [$i], "") and 
					array_get_value ($rain_data_array 
					[$nothing_col_array [$i]], 
					'0', "") and 
					array_get_value ($rain_data_array 
					[$nothing_col_array [$i]], 
					'1', "") and 
					array_get_value ($rain_data_array 
					[$nothing_col_array [$i]], 
					'2', "") and 
					array_get_value ($rain_data_array 
					[$nothing_col_array [$i]], 
					'3', "") and 
					array_get_value ($rain_data_array 
					[$nothing_col_array [$i]], 
					'4', "") ) {

					$db_st -> bindValue 
						(':date', $rain_date ) ;

					$db_st -> bindValue 
						(':time', 
						$rain_time_array 
						[$nothing_col_array [$i]]
						) ;

					$db_st -> bindValue 
						(':n_ikku', 
						$rain_data_array 
						[$nothing_col_array [$i]]
						[0] ) ;

					$db_st -> bindValue 
						(':n_bessi', 
						$rain_data_array 
						[$nothing_col_array [$i]][
						1] ) ;

					$db_st -> bindValue 
						(':n_tatukawa', 
						$rain_data_array 
						[$nothing_col_array [$i]]
						[2] ) ;

					$db_st -> bindValue 
						(':n_ojouin', 
						$rain_data_array 
						[$nothing_col_array [$i]]
						[3] ) ;

					$db_st -> bindValue 
						(':n_takihama', 
						$rain_data_array 
						[$nothing_col_array [$i]]
						[4] ) ;
					
					$db_st -> bindValue 
						(':year', 
						substr ($rain_date, 0, 4) ) ;
					
					$db_st -> bindValue 
						(':month', 
						substr ($rain_date, 5, 2) ) ;

					$db_st -> execute () ;
				}
			}
		}
		catch (Exception $e) {

			// ロールバック
			$db -> exec ("ROLLBACK;") ;
			$msg = "SQL 実行エラーが発生しロールバック\n" ;
			$msg .= $e -> getTraceAsString () ;
			echo $msg ;
			access_log_writer (time(), $msg) ;

			return ;
		}

		// コミット
		$db_res = $db -> exec ("COMMIT;") ;

		$db_st -> clear () ;

		if ( $db_res == true ) {

			$db_res = 
			$db_res_array = 
			$nothing_col_array = 
			null ;
		}
		else {

			$msg = "insert_res is false" ;
			echo $msg . "\n" ;
			access_log_writer (time(), $msg) ;
		}
	}
	else {

		$msg = "colmun_check fail or all colmun duplicate." ;
		echo $msg . "\n" ;
		access_log_writer (time(), $msg) ;
	}

	return 1 ;

}

?>
