<?php

//echo make_calendar_table ( null , null ) ;
//exit ;

function make_calendar_table ( $year , $month , $target_date_array ) {
	$return_text = null ;
	$css_class = null ;

	if ( $year )
	{
		if ( ! preg_match ( "/^20[0-9]{2}$/" , $year ) )
		{
			$year = null ;
			$month = null ;
		}
	}
	if ( $month )
	{
		if ( preg_match ("/^0[1-9]/" , $month ) )
		{
			$month = preg_replace ( "/^0/" , "" , $month ) ;
		}

		if ( ! preg_match ( "/^0?[1-9]$/" , $month ) and ! preg_match ( "/^1[0-2]$/" , $month ) )
		{
			$year = null ;
			$month = null ;
		}
	}

// http://nyx.pu1.net/sample/date_time/calendar2.html
//
	$now_year = date ("Y") ; // 現在の年を取得
	$now_month = date ("n") ; // 在の月を取得
	$now_day = date ("j") ; // 現在の日を取得

	if ( ! $year )
	{
		$year = $now_year ;
	}
	if ( ! $month )
	{
		$month = $now_month ;
	}

	// 曜日の配列作成
	$weekday = array ( "日", "月", "火", "水", "木", "金", "土" ) ;
	// 1日の曜日を数値で取得
	$fir_weekday = date ( "w" , mktime ( 0, 0, 0, $month, 1, $year ) ) ;

	//$return_text .= '<table border="1" cellspacing="0" cellpadding="5" style="text-align:center;">' ;
	$return_text .= "<div id=\"calendarTableContainer\">\n<table>\n" ;

	// 見出し部分<caption>タグ出力
	//$return_text .= "<caption style=\"color:black; font-size:14px; padding:0px;\">" .
	$return_text .= "<caption id=\"calendarCaption\">" . 
		"<span onclick=\"month_change(" . 
		date ( "Ym", mktime ( 0, 0, 0, $month - 1, 1, $year ) ) . 
		");\">&lt;&nbsp;</span>" . 
		$year . "年" . $month . "月" . 
		"<span onclick=\"month_change(" . 
		date ( "Ym", mktime ( 0, 0, 0, $month + 1, 1, $year ) ) . 
		");\">&gt;&nbsp;</span>" . 
		"</caption>\n" ;

	$return_text .= "<tr>\n" ;

	// 曜日セル<th>タグ設定
	$i = 0 ; // カウント値リセット
	while ( $i <= 6 ) { // 曜日分ループ

//-------------スタイルシート設定---------------------------------
	    if ( $i == 0 ) { // 日曜日の文字色
		    //$style = "#C30" ;
		    $css_class = "sunday" ;
	    }
	    else if ( $i == 6 ) { // 土曜日の文字色
		    //$style = "#03C" ;
		    $css_class = "saturday" ;
	    }
	    else { // 月曜～金曜日の文字色
		    //$style = "black" ;
		    $css_class = "weekday" ;
	    }
//-------------スタイルシート設定終わり---------------------------

	    // <th>タグにスタイルシートを挿入して出力
	    //$return_text .= "\t<th style=\"color:" . $style . "\" class=\"" . $css_class . "\">" . $weekday [$i] . "</th>\n" ;
	    $return_text .= "\t<th class=\"" . $css_class . "\">" . $weekday [$i] . "</th>\n" ;

	    $i ++ ; //カウント値+1
	}

	// 行の変更
	$return_text .= "</tr>\n" ;
	$return_text .= "<tr>\n" ;

	$i = 0 ; //カウント値リセット（曜日カウンター）
	while ( $i != $fir_weekday ) { //１日の曜日まで空白（&nbsp;）で埋める
	    $return_text .= "\t<td>&nbsp;</td>\n" ;
	    $i ++ ;
	}

	// 今月の日付が存在している間ループする
	for ( $day = 1 ; checkdate ( $month , $day , $year ) ; $day ++ ) {

    //曜日の最後まできたらカウント値（曜日カウンター）を戻して行を変える
	    if( $i > 6 ) {
	        $i = 0 ;
	        $return_text .= "</tr>\n" ;
	        $return_text .= "<tr>\n" ;
	    }

//-------------スタイルシート設定-----------------------------------
	    if ( $i == 0 ) { //日曜日の文字色
		    //$style = "#C30" ;
		    $css_class = "sunday" ;
	    }
	    else if ( $i == 6 ) { //土曜日の文字色
		    //$style = "#03C" ;
		    $css_class = "saturday" ;
	    }
	    else { //月曜～金曜日の文字色
		    //$style = "black" ;
		    $css_class = "weekday" ;
	    }

    // 今日の日付の場合、背景色追加
	    if ( $day == $now_day and $month == $now_month and $year == $now_year ) {
		    //$style = $style . "; background:silver" ;
		    $css_class .= " today" ;
	    }
//-------------スタイルシート設定終わり-----------------------------

	    // 日付セル作成とスタイルシートの挿入
	    //$return_text .= "\t<td style=\"color:" . $style . ";\" class=\"" . $css_class . "\">" . $day . "</td>\n" ;

		$return_text .= "\t<td class=\"" . $css_class . "\">" ;

		// 記事のある日付にはリンクをつける
		if ( is_array ( $target_date_array ) ) {

// for debug
//$return_text = $target_date_array ;
//return $return_text ;

			if ( array_search ( $day, $target_date_array ) ) {

				$return_text .= "<a href=\"#a" . $year ;
				if ( $month < 10 ) {
					$return_text .= "0" ;
				}
				$return_text .= $month ;
				if ( $day < 10 ) {
					$return_text .= "0" ;
				}
				$return_text .= $day . "\">" . $day . "</a>" ;
			}
			else {
				$return_text .= $day ;
			}
		}
		else {
			$return_text .= $day ;
		}
	
		$return_text .= "</td>\n" ;


	    $i ++ ; //カウント値（曜日カウンター）+1
	}

	while ( $i < 7 ) { //残りの曜日分空白（&nbsp;）で埋める
	    $return_text .= "\t<td>&nbsp;</td>\n" ;
	    $i ++ ;
	}
	$return_text .= "</tr>\n" ;
	$return_text .= "</table>\n</div>\n" ;

	return $return_text ;
}

?>
