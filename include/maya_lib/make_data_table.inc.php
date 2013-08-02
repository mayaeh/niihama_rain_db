<?php

function make_data_table ($mode, $table_data_array) {

	$msg_array = 
	$html_data = 
	null ;

// for debug
//var_dump ($table_data_array) ;
//exit ;

	if ( ! is_array ($table_data_array) ) {

		return null ;
	}

	for ( $i = 0; $i < count($table_data_array); $i ++ ) {

// for debug
//var_dump ($table_data_array [$i]) ;
//exit ;

		switch ($mode) {

			case "monthly_report":

				$html_data .= 
					'<tr class="r' . $i %2 . '">' . 
					"\n\t" . '<td class="date">' ;
				break ;

			case "daily_report":

			default:

				$html_data .= 
					'<tr class="r' . $i % 2 . '">' . 
					"\n\t" . '<td class="time">' ;
		}

		if (array_get_value ($table_data_array [$i], 'time', "") ) {

			$html_data .= $table_data_array [$i]['time'] ;
		}
		else if (array_get_value ($table_data_array [$i], 
			'date', "") ) {

			$html_data .= $table_data_array [$i]['date'] ;
		}
		else {

			$html_data .= "合計" ;
		}

// for debug
//var_dump ($html_data) ;
//exit ;

		$html_data .= "</td>\n\t" . 
			'<td class="n_ikku">' . 
			number_format ($table_data_array [$i]['n_ikku'], 1) . 
			"</td>\n\t" . 
			'<td class="n_bessi">' . 
			number_format ($table_data_array [$i]['n_bessi'], 1) . 
			"</td>\n\t" . 
			'<td class="n_tatukawa">' . 
			number_format ($table_data_array [$i]['n_tatukawa'], 1) . 
			"</td>\n\t" . 
			'<td class="n_ojouin">' . 
			number_format ($table_data_array [$i]['n_ojouin'], 1) . 
			"</td>\n\t" . 
			'<td class="n_takihama">' . 
			number_format ($table_data_array [$i]['n_takihama'],1) .
			"</td>\n" . 
			"</tr>\n" ; 

	}

	return $html_data ;
}
?>
