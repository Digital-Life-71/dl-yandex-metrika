<?php
add_action('wp_dashboard_setup', 'dl_yandex_metrika_add_dashboard_widgets_demography');
function dl_yandex_metrika_add_dashboard_widgets_demography() {
    wp_add_dashboard_widget(
        'demography_dashboard_widget',			// Идентификатор виджета.
        'Демография',           				// Заголовок виджета.
        'demography_dashboard_widget_function'	// Функция отображения.
    );
}

function demography_dashboard_widget_function() {
	$dl_metrika_id = get_option('dl_yandex_metrika_id');
	$dl_token = get_option('dl_yandex_metrika_token');

	$date1 = date('Ymd',strtotime("-7 day"));

	$url = 'https://api-metrika.yandex.ru/stat/demography/age_gender.json?id='.$dl_metrika_id.'&oauth_token='.$dl_token.'&date1='.$date1;
	$json_data = file_get_contents($url);
	$json_data = json_decode($json_data, true);

?>	<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Пол', 'Процент'],
<?php
foreach($json_data['data_gender'] as $key => $value) {

	$name = $json_data['data_gender'][$key]['name'];
	$visits_percent = $json_data['data_gender'][$key]['visits_percent'];

	echo '[\''. $name .'\','.$visits_percent.'],';

} ?>
        ]);

      var options = {
		title: 'Пол посетителей',
        pieHole: 0.4,
		height: 300,
		'legend':'top',
		'chartArea': {'width': '80%', 'height': '80%'},
      };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
      }
    </script>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Пол', 'Процент'],
<?php
foreach($json_data['data'] as $key => $value) {

	$name = $json_data['data'][$key]['name'];
	$visits_percent = $json_data['data'][$key]['visits_percent'];

	echo '[\''. $name .'\','.$visits_percent.'],';

} ?>
        ]);

      var options = {
		title: 'Возрастная группа',
        pieHole: 0.4,
		height: 300,
		'legend':'top',
		'chartArea': {'width': '80%', 'height': '80%'},
      };

        var chart = new google.visualization.PieChart(document.getElementById('datachart'));
        chart.draw(data, options);
      }
    </script>

	<div id="piechart" style="width: 50%; float: left;"></div>
	<div id="datachart" style="width: 50%; float: left;"></div>
	<div style="clear: both"></div>

	<?php
}