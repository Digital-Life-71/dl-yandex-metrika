<?php
$dl_metrika_id = get_option('dl_yandex_metrika_id');
$dl_token = get_option('dl_yandex_metrika_token');
$date = date('Ymd',strtotime("-1 month"));

$url = 'https://api-metrika.yandex.ru/stat/geo.json?id='.$dl_metrika_id.'&oauth_token='.$dl_token.'&date1='.$date;
$json_data = file_get_contents($url);
$json_data = json_decode($json_data, true);
?>
<div class="wrap">
<h2>Отчет по Странам мира  <a href="https://metrika.yandex.ru/stat/geo?id=<?php echo $dl_metrika_id; ?>" target="_blank" style="float: right" class="button">Отчет на Yandex.Metrika</a></h2>
<script type="text/javascript">
google.load("visualization", "1", {packages:["geochart"]});
google.setOnLoadCallback(drawRegionsMap);

function drawRegionsMap() {

var data = google.visualization.arrayToDataTable([
  ['Страны', 'Визиты'],
<?php
foreach($json_data[data] as $key => $value) { 
	
	$geo_name 	= $json_data[data][$key][name];
	$geo_visits = $json_data[data][$key][visits];
	
	echo '[\''. $geo_name .'\','.$geo_visits.'],';

}
?>
]);

var options = {};

var chart = new google.visualization.GeoChart(document.getElementById('regions'));

chart.draw(data, options);
}
</script>
	

<div class="wrap">
    <div class="postbox-container" style="width: 100%">
        <div class="metabox-holder">
            <div class="meta-box-sortables">
			
			
                <div class="postbox" id="first">
                    <div class="inside">
						<div id="regions" style="width: 100%; height: 500px;"></div>
                    </div>
                </div>
				

<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr>
	<th class="manage-column column-title"><a>Страна</a></th>
	<th class="manage-column column-author">Визиты</th>
	<th class="manage-column column-author">Просмотры</th>
	<th class="manage-column column-author">Отказы</th>
	<th class="manage-column column-author">Глубина просмотра</th>
	<th class="manage-column column-author">Среднее время</th>	
</tr>
</thead>

<tbody>
<?php

foreach($json_data[data] as $key => $value) { 
	$geo_name 			= $json_data[data][$key][name];
	$geo_visits 		= $json_data[data][$key][visits];
	$geo_page_views 	= $json_data[data][$key][page_views];
	$geo_denial		 	= $json_data[data][$key][denial];
	$geo_depth		 	= $json_data[data][$key][depth];
	$geo_visit_time		= $json_data[data][$key][visit_time];
	
	$geo_visit_time		= $geo_visit_time/60;
?>  
<tr>
  <th class="manage-column column-title"><a><?php echo $geo_name; ?></a></th>
  <th class="manage-column column-author"><?php echo $geo_visits; ?></th>
  <th class="manage-column column-author"><?php echo $geo_page_views; ?></th>
  <th class="manage-column column-author"><?php echo round($geo_denial, 1); ?></th>
  <th class="manage-column column-author"><?php echo round($geo_depth, 1); ?></th>
  <th class="manage-column column-author"><?php echo round($geo_visit_time, 1); ?></th>
</tr>
<?php } ?>
</tbody>
</table>                        

<br>

	<?php if(get_option('dl_yandex_metrika_developer_url') <> '') { ?>
	<div class="postbox" id="second">
		<h3 class="hndle" style="cursor: default">URL json</h3>
		<div class="inside">
			<?php if(get_option('dl_yandex_metrika_developer_url') <> '') { ?>
			<a href="<?php echo $url.'&pretty=1'; ?>" target="_blank"><?php echo $url; ?></a><?php } ?>
		</div>
	</div>
	<?php } ?>	
	
	<?php if(get_option('dl_yandex_metrika_developer') <> '') { ?>
	<div class="postbox" id="second">
		<h3 class="hndle" style="cursor: default">Массив данных</h3>
		<div class="inside">
			<pre><?php print_r($json_data); ?></pre>
		</div>
	</div>
	<?php } ?>
				
            </div>
        </div>
    </div>
</div>