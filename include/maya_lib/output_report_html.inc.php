<?php

function output_report_html ($mode, $rain_date) {

	$msg = 
	$query = 
	$db = 
	$db_res = 
	$db_res_array = 
	$graph_datetime_text = 
	$graph_data_p1_array = 
	$graph_data_p2_array = 
	$graph_data_p3_array = 
	$graph_data_p4_array = 
	$graph_data_p5_array = 
	$html_data = 
	$graph_data = 
	null ;

// for debug
//$rain_date = '2013-07-03' ;

	if ( ! $rain_date ) {

		return null ;
	}

	switch ($mode) {

	case "monthly_report":
	
		$query = "SELECT date, SUM(n_ikku) AS n_ikku, " . 
			"SUM(n_bessi) AS n_bessi, " . 
			"SUM(n_tatukawa) AS n_tatukawa, " . 
			"SUM(n_ojouin) AS n_ojouin, " . 
			"SUM(n_takihama) AS n_takihama " . 
			"FROM rain WHERE date LIKE '" . 
			preg_replace ( "/(20[0-9]{2}-[0-9]{2})-[0-9]{2}/u", 
			"$1%", $rain_date ) . "' GROUP BY date ;" ;

		break ;

	case "daily_report":

	default:
	
		$query = "SELECT * FROM rain WHERE date = '" . 
			$rain_date . "' ;" ;
	}

	$db = new SQLite3 (DB_FILE) ;


// for debug
//var_dump ($query) ;
//exit ;

	$db_res = $db -> query ($query) ;

	while ($row  = $db_res -> fetchArray (SQLITE3_ASSOC) ) {

// for debug
//var_dump ($row) ;
//exit ;

		if (array_get_value ($row, 'date', "") ) {

			$db_res_array [] = $row ;
		
			switch ($mode) {

			case "monthly_report":
	
				$graph_datetime_text = preg_replace 
					("/20[0-9]{2}-[0-9]{2}-([0-9]{2})/u", 
					"$1", $row ['date'] ) ;

				break ;

			case "daily_report":

			default:
	
				$graph_datetime_text = preg_replace 
					("/([0-9]{2}):00/u", 
					"$1", $row ['time'] ) ;
			}

			$graph_data_p1_array [] = "['" . $graph_datetime_text . 
				"'," . $row ['n_ikku'] . "]" ;

			$graph_data_p2_array [] = "['" . $graph_datetime_text .
				"'," . $row ['n_bessi'] . "]" ;

			$graph_data_p3_array [] = "['" . $graph_datetime_text . 
				"'," . $row ['n_tatukawa'] . "]" ;

			$graph_data_p4_array [] = "['" . $graph_datetime_text . 
				"'," . $row ['n_ojouin'] . "]" ;

			$graph_data_p5_array [] = "['" . $graph_datetime_text . 
				"'," . $row ['n_takihama'] . "]" ;

		}
	}

	if ($graph_data_p1_array) {

		$graph_data = 
			"\tvar line1 = [" . 
			implode ( ",", $graph_data_p1_array ) . "];\n\n" . 
			"\tvar line2 = [" . 
			implode ( ",", $graph_data_p2_array ) . "];\n\n" . 
			"\tvar line3 = [" . 
			implode ( ",", $graph_data_p3_array ) . "];\n\n" . 
			"\tvar line4 = [" . 
			implode ( ",", $graph_data_p4_array ) . "];\n\n" . 
			"\tvar line5 = [" . 
			implode ( ",", $graph_data_p5_array ) . "];\n\n" ;
	}

// for debug
//var_dump ($graph_data) ;
//exit ;

	$html_data = make_data_table ($mode, $db_res_array) ;

	$db_res -> finalize () ;

	switch ($mode) {

	case "monthly_report":

		$query =  
			"SELECT SUM(n_ikku) AS n_ikku, " . 
			"SUM(n_bessi) AS n_bessi, " . 
			"SUM(n_tatukawa) AS n_tatukawa, " . 
			"SUM(n_ojouin) AS n_ojouin, " . 
			"SUM(n_takihama) AS n_takihama FROM rain " . 
			"WHERE year = '" . substr ($rain_date, 0, 4) . 
			"' AND month = '" . substr ($rain_date, 5,2) . 
			"' ;" ;

		break ;

	case "daily_report":

	default:

		$query =  
			"SELECT SUM(n_ikku) AS n_ikku, " . 
			"SUM(n_bessi) AS n_bessi, " . 
			"SUM(n_tatukawa) AS n_tatukawa, " . 
			"SUM(n_ojouin) AS n_ojouin, " . 
			"SUM(n_takihama) AS n_takihama FROM rain " . 
			"WHERE date = '" . $rain_date . "' ;" ;
	}

// for debug
//var_dump ($query) ;
//exit ;

	$db_res = $db -> query ($query) ;

	$db_res_array = null ;
	$db_res_array [0] = $db_res -> fetchArray (SQLITE3_ASSOC) ;

	$html_data .= make_data_table ($mode, $db_res_array) ;

// for debug
//var_dump ($html_data) ;
//var_dump ($db_res_array) ;
//exit;

	$db -> close () ;

	return array ($html_data, $graph_data) ;
}
?>
