<?php

function make_date_selector ($mode, $rain_date) {

	$prev_query = 
	$next_query = 
	$db = 
	$db_res = 
	$db_res_array = 
	$prev_date = 
	$next_date = 
	$d_array = 
	$latest_url = 
	$prev_html = 
	$next_html = 
	$html = 
	null ;

	if ( ! $mode or ! $rain_date ) {

		return null ;
	}

	preg_match ( "/(20[0-9]{2})-([0-9]{2})-([0-9]{2})/u", 
		$rain_date, $d_array ) ;

// for debug
//var_dump ($d_array) ;
//exit ;

	switch ($mode) {

	case "monthly_report":

		$prev_query = 
			"SELECT date FROM rain WHERE date < '" . 
			date ( "Y-m-d", mktime (0,0,0, $d_array [2], 
			1, $d_array [1] ) ) . 
			"' ORDER BY date DESC LIMIT 1 ;" ;

		$next_query = 
			"SELECT date FROM rain WHERE date > '" . 
			date ( "Y-m-d", mktime (0,0,0, $d_array [2] +1, 
			1 -1, $d_array [1] ) ) . 
			"' ORDER BY date LIMIT 1 ;" ;

		break ;

	case "daily_report":

	default:

		$prev_query = 
			"SELECT date FROM rain WHERE date < '" . 
			$rain_date . "' ORDER BY date DESC LIMIT 1 ;" ;

		$next_query = 
			"SELECT date FROM rain WHERE date > '" . 
			$rain_date . "' ORDER BY date LIMIT 1 ;" ;
	}

// for debug
//var_dump ( array ($prev_query, $next_query) ) ;
//exit ;

	$db = new SQLite3 (DB_FILE) ;

	$db_res = $db -> query ($prev_query) ;

	$db_res_array = $db_res -> fetchArray (SQLITE3_ASSOC) ;

// for debug
//var_dump ($db_res_array) ;

	if ( array_get_value ( $db_res_array, 'date', "" ) ) {

		$prev_date = $db_res_array ['date'] ;
	}

	$db_res -> finalize () ;


	$db_res = $db -> query ($next_query) ;

	$db_res_array = $db_res -> fetchArray (SQLITE3_ASSOC) ;

	if ( array_get_value ( $db_res_array, 'date', "" ) ) {

		$next_date = $db_res_array ['date'] ;
	}

	$db -> close () ;

// for debug
//return array ($prev_date, $next_date) ;
//var_dump ( array ($prev_date, $next_date) ) ;
//exit ;

	$latest_url = "?" ;

	switch ($mode) {

	case "monthly_report":

		$rain_date = substr ($rain_date, 0, -3) ;

		$latest_url .= "mode=" . $mode ;

		break ;

	case "daily_report":

	default:
	
		$latest_url .= "mode=" . $mode ;

	}


	if ($prev_date) {

		$prev_html = "\t" . '<span><a href="?mode=' . 
			$mode . '&date=' . $prev_date . 
			'">前</a></span>' ;
	}
	else {
		$prev_html = "\t<span>前</span>" ;
	}

	if ($next_date) {

		$next_html = '<span><a href="?mode=' . 
			$mode . '&date=' . $next_date . 
			'">次</a></span>' . "\n" ;
	}
	else {
		$next_html = "<span>次</span>\n" ;
	}

	$html = "\t<h2>" . $rain_date . "</h2>\n" . $prev_html . $next_html ;

	$html .= '<span><a href="' . 
		$latest_url . '">最新</a></span>' . "\n" ;

	return $html ;

}
?>
