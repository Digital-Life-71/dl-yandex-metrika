<?php
$dl_metrika_id = get_option('dl_yandex_metrika_id');
$dl_token = get_option('dl_yandex_metrika_token');
$date = date('Ymd',strtotime("-1 month"));

$url = 'https://api-metrika.yandex.ru/stat/geo.json?id='.$dl_metrika_id.'&oauth_token='.$dl_token.'&date1='.$date;
$data_geo = file_get_contents($url);
$data_geo = json_decode($data_geo, true);
?>
<div class="wrap">
<h2>Отчет по Странам мира</h2>
<script type="text/javascript">
google.load("visualization", "1", {packages:["geochart"]});
google.setOnLoadCallback(drawRegionsMap);

function drawRegionsMap() {

var data = google.visualization.arrayToDataTable([
  ['Страны', 'Визиты'],
<?php
foreach($data_geo[data] as $key => $value) { 
	
	$geo_name 	= $data_geo[data][$key][name];
	$geo_visits = $data_geo[data][$key][visits];
	
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

foreach($data_geo[data] as $key => $value) { 
	$geo_name 			= $data_geo[data][$key][name];
	$geo_visits 		= $data_geo[data][$key][visits];
	$geo_page_views 	= $data_geo[data][$key][page_views];
	$geo_denial		 	= $data_geo[data][$key][denial];
	$geo_depth		 	= $data_geo[data][$key][depth];
	$geo_visit_time		= $data_geo[data][$key][visit_time];
	
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

				<?php if(get_option('dl_yandex_metrika_developer') <> '') { ?>
				<div class="postbox" id="second">
                    <h3 class="hndle" style="cursor: default">Массив данных</h3>
                    <div class="inside">
						<?php if(get_option('dl_yandex_metrika_developer_url') <> '') { ?>
						<a href="<?php echo $url.'&pretty=1'; ?>" target="_blank"><?php echo $url; ?></a><?php } ?>						
                        <pre><?php print_r($data_geo); ?></pre>
                    </div>
                </div>
				<?php } ?>
				
            </div>
        </div>
    </div>
</div>