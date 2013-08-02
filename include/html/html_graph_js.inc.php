<script type="text/javascript">
$(document).ready ( function() {

<?php echo $graph_data ; ?>

	var plot1 = $.jqplot 
		('chart1', [line1,line2,line3,line4,line5], {

//		title: '降雨量', 
		animate: !$.jqplot.use_excanvas, 
		seriesDefaults: {
			renderer: $.jqplot.BarRenderer, 
			pointLabels: { show: true }
		}, 
		axes: {
			// X 軸
			xaxis: {
				renderer: $.jqplot.CategoryAxisRenderer, 
//				tickRenderer:
//					$.jqplot.CanvasAxisTickRenderer, 
//					tickOptions: { angle: -30 }, 
				label: "日時"
			}, 
			// Y 軸
			yaxis: {
				label: "降雨量"
			}
		}, 
		// 凡例
		series: [
			{ label: '一宮町' },
			{ label: '別子山' },
			{ label: '立川' }, 
			{ label: '大生院' }, 
			{ label: '多喜浜' },
		], 
		legend: {
			show: true, // true: 表示 / false: 非表示
			placement: 'outside', 
			renderer: $.jqplot.EnhancedLegendRenderer,
			rendererOptions: {
				seriesToggle: 'slow'
			}
		}
	} ) ;
} ) ;
</script>

<div id="chart1">
</div>
