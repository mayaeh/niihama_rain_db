<?php
// written by maya minatsuki
// made this file : 2013.04.11
// last mod. : 2013.07.09
//


// 連想配列の要素が存在するかチェックする関数
require_once ( SCRIPT_DIR . "include/unoh_lib/array_get_value.inc.php" ) ;

require_once ( MAYALIB_DIR . 'access_log_writer.inc.php' ) ;

if ( ! function_exists ('sqlite_escape_string') ) {
	require_once ( MAYALIB_DIR . 'sqlite_escape_string.inc.php' ) ;
}

require_once ( MAYALIB_DIR . 'mkdata.inc.php' ) ;

require_once ( MAYALIB_DIR . 'process_today_data.inc.php' ) ;

require_once ( MAYALIB_DIR . 'make_date_selector.inc.php' ) ;

require_once ( MAYALIB_DIR . 'make_data_table.inc.php' ) ;

require_once ( MAYALIB_DIR . 'colmun_exists.inc.php' ) ;

require_once ( MAYALIB_DIR . 'colmun_check.inc.php' ) ;

require_once ( MAYALIB_DIR . 'output_report_html.inc.php' ) ;

//require_once ( MAYALIB_DIR . 'make_calendar_table.inc.php' ) ;

?>
