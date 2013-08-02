<?php

require_once ('config.php') ;

$rain_date =
$rain_time_array =
$rain_data_array =
$res = 
$msg = 
$msg_array = 
$msg_html = 
$html_data = 
$graph_data = 
$mode = 
null ;

$res = process_today_data () ;

if ( $res != 1 ) {

	$msg_array [] = $res ;
}

if ($_GET) {

	if (array_get_value ($_GET, 'mode', "") ) {

		$match_array = null ;

		if (preg_match ( 
			"/^((daily|monthly)_report)$/u", 
			$_GET ['mode'], $match_array ) ) {

			$mode = $match_array [1] ;
		}
	}

	if (array_get_value ($_GET, 'date', "") ) {

		$match_array = null ;

		if (preg_match ( "/^(20[0-9]{2}-[0-9]{2}-[0-9]{2})$/u", 
			$_GET ['date'], $match_array ) ) {

			$rain_date = $match_array [1] ;
		}
	}
}

if ( ! $mode ) {

	$mode = "daily_report" ;
}

if ( ! $rain_date ) {

	$rain_date = date ("Y-m-d") ;
}


if ( ! list ($html_data, $graph_data) = 
	output_report_html ($mode, $rain_date) ) {

	$msg = "output_report_html return not array" ;
	access_log_writer (time(), $msg) ;
	$msg_array [] = $msg ;
}

require_once (HTML_HEADER_FILE) ;

if ( is_array ($msg_array) ) {

	$msg_html = "<div id=\"shellResponseContainer\">\n" . 
		"<ul>\n" ;

	for ( $i = 0; $i < count($msg_array); $i ++ ) {

		if ($msg_array [$i]) {
		
			$msg_html .= "<li>" . $msg_array [$i] . 
				"</li>\n" ;
		}
	}
	
	$msg_html .= "</ul>\n</div>\n" ;
	
	echo $msg_html ;
}
//var_dump ($msg_array) ;

require (HTML_TOP_MENU_FILE) ;

require_once (HTML_DATESELECTOR_FILE) ;

require_once (HTML_TABLE_FILE) ;

if ($graph_data) {
	require_once (HTML_GRAPH_JS_FILE) ;
}

require_once (HTML_FOOTER_FILE) ;

?>
