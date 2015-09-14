<?php
$dl_metrika_id = get_option('dl_yandex_metrika_id');
$dl_token = get_option('dl_yandex_metrika_token');
$date = date('Ymd',strtotime("-1 month"));

$url = 'https://api-metrika.yandex.ru/stat/demography/age_gender.json?id='.$dl_metrika_id.'&oauth_token='.$dl_token.'&date1='.$date;
$json_data = file_get_contents($url);
$json_data = json_decode($json_data, true);
?>
<div class="wrap">
<h2>Отчет по полу и возрасту</h2>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Пол', 'Процент'],
<?php
foreach($json_data[data_gender] as $key => $value) { 
	
	$name = $json_data[data_gender][$key][name];
	$visits_percent = $json_data[data_gender][$key][visits_percent];
	
	//$visits_percent = round($visits_percent, 2);
	
	echo '[\''. $name .'\','.$visits_percent.'],';

} ?>
        ]);

      var options = {
		title: 'Пол посетителей',
        pieHole: 0.4,  
		height: 400,
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
foreach($json_data[data] as $key => $value) { 
	
	$name = $json_data[data][$key][name];
	$visits_percent = $json_data[data][$key][visits_percent];
	
	//$visits_percent = round($visits_percent, 2);
	
	echo '[\''. $name .'\','.$visits_percent.'],';

} ?>
        ]);

      var options = {
		title: 'Возрастная группа',
        pieHole: 0.4,  
		height: 400,
      };

        var chart = new google.visualization.PieChart(document.getElementById('datachart'));
        chart.draw(data, options);
      }
    </script>	

<div class="wrap">
    <div class="postbox-container" style="width: 100%">
        <div class="metabox-holder">
            <div class="meta-box-sortables">
			
			
                <div class="postbox" id="first">
                    <div class="inside">
						<div id="piechart" style="width: 50%; float: left;"></div>
						<div id="datachart" style="width: 50%; float: left;"></div>
						<div style="clear: both"></div>
                    </div>
                </div>
				

<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr>
	<th class="manage-column column-title"><a>Пол посетителей</a></th>
	<th class="manage-column column-author">Доля визитов</th>
	<th class="manage-column column-author">Отказы</th>
	<th class="manage-column column-author">Глубина просмотра</th>
	<th class="manage-column column-author">Среднее время</th>
</tr>
</thead>

<tbody>
<?php

foreach($json_data[data_gender] as $key => $value) { 
	
	$name = $json_data[data_gender][$key][name];
	$visits_percent = $json_data[data_gender][$key][visits_percent];
	$denial = $json_data[data_gender][$key][denial];
	$depth = $json_data[data_gender][$key][depth];
	$visit_time = $json_data[data_gender][$key][visit_time];
	
	$visit_time	= $visit_time/60;
?>
 
<tr>
  <th class="manage-column column-title"><a><?php echo $name; ?></a></th>
  <th class="manage-column column-author"><?php echo round($visits_percent, 2); ?> %</th>
  <th class="manage-column column-author"><?php echo $denial; ?></th>
  <th class="manage-column column-author"><?php echo $depth; ?></th>
  <th class="manage-column column-author"><?php echo round($visit_time, 1); ?></th>
</tr>
<?php } ?>
</tbody>
</table>                        

<br>

<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr>
	<th class="manage-column column-title"><a>Возрастная группа</a></th>
	<th class="manage-column column-author">Доля визитов</th>
	<th class="manage-column column-author">Отказы</th>
	<th class="manage-column column-author">Глубина просмотра</th>
	<th class="manage-column column-author">Среднее время</th>
</tr>
</thead>

<tbody>
<?php
foreach($json_data[data] as $key => $value) { 
	
	$name = $json_data[data][$key][name];
	$visits_percent = $json_data[data][$key][visits_percent];
	$denial = $json_data[data][$key][denial];
	$depth = $json_data[data][$key][depth];
	$visit_time = $json_data[data][$key][visit_time];
	
	$visit_time	= $visit_time/60;
?>
 
<tr>
  <th class="manage-column column-title"><a><?php echo $name; ?></a></th>
  <th class="manage-column column-author"><?php echo round($visits_percent, 2); ?> %</th>
  <th class="manage-column column-author"><?php echo $denial; ?></th>
  <th class="manage-column column-author"><?php echo $depth; ?></th>
  <th class="manage-column column-author"><?php echo round($visit_time, 1); ?></th>
</tr>
<?php } ?>
</tbody>
</table>

<br>

				<?php if(get_option('dl_yandex_metrika_developer') <> '') { ?>
				<div class="postbox" id="second">
                    <h3 class="hndle" style="cursor: default">Массив данных</h3>
                    <div class="inside">
						<?php if(get_option('dl_yandex_metrika_developer_url') <> '') { ?>
						<a href="<?php echo $url.'&pretty=1'; ?>" target="_blank"><?php echo $url; ?></a><?php } ?>						
                        <pre><?php print_r($json_data); ?></pre>
                    </div>
                </div>
				<?php } ?>
				
            </div>
        </div>
    </div>
</div>