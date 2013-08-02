<?php

// for debug
//var_dump ( make_calendar_table (
//	date ( "Y", $db_last_date_u ) ,
//	date ( "m", $db_last_date_u ) ,
//	$target_date_array ) ) ;
//exit ;

if ( $display_month ) {
	preg_match ( "/(20[0-9]{2})\/([0-9]{2})/u", 
		$display_month, $match_array ) ;

	echo make_calendar_table ( $match_array [1], 
		$match_array [2], 
		$target_date_array ) ;
}
else {
	echo make_calendar_table ( '', '', '' ) ;
}

?>
