<div id="mainTable">

<table>
<tr>
<?php 
	switch ($mode) {

		case "monthly_report":

			echo "\t<th class=\"date\">日付</th>\n" ;
			break ;

		case "daily_report":

		default:

			echo "\t<th class=\"time\">時間</th>\n" ;
	}
?>
	<th class="n_ikku">一宮町</th>
	<th class="n_bessi">別子山</th>
	<th class="n_tatukawa">立川</th>
	<th class="n_ojouin">大生院</th>
	<th class="n_takihama">多喜浜</th>
</tr>
<?php echo $html_data ; ?>
</table>

</div>
