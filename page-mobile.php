<?php
$dl_metrika_id = get_option('dl_yandex_metrika_id');
$dl_token = get_option('dl_yandex_metrika_token');

$date1 = $_GET['date'];
if($date1 == 'week') {		// если неделя
	$date1 = date('Ymd',strtotime("-7 day"));
} elseif($date1 == 'month') {	// если месяц
	$date1 = date('Ymd',strtotime("-1 month"));
} elseif($date1 == 'quart') {	// если квартал
	$date1 = date('Ymd',strtotime("-3 month"));
} elseif($date1 == 'year') {	// если год
	$date1 = date('Ymd',strtotime("-12 month"));
} else {
	$date1 = date('Ymd',strtotime("-1 month"));
}

$date2 = date('Ymd');

$url = 'https://api-metrika.yandex.ru/stat/tech/mobile.json?id='.$dl_metrika_id.'&oauth_token='.$dl_token.'&date1='.$date1.'&date2='.$date2;
$json_data = file_get_contents($url);
$json_data = json_decode($json_data, true); 
?>

<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Название операционной системы', 'Визиты'],
<?php foreach($json_data[data] as $key => $value) { 
	
	$name = $json_data[data][$key][name];
	$visits = $json_data[data][$key][visits];
	
	echo '[\''. $name .'\','.$visits.'],';

	} ?>
        ]);

        var options = {
			title: 'Данные о посетителях, которые обращаются на сайт с мобильных устройств',
			pieHole: 0.4,  
			height: 400,
			'chartArea': {'width': '70%', 'height': '70%'},
		};

        var chart = new google.visualization.PieChart(document.getElementById('dl_metrika_os'));
        chart.draw(data, options);
      }
    </script>
	

<div class="wrap">
<h2>Отчет Операционные системы <a href="https://metrika.yandex.ru/stat/tech_devices?id=<?php echo $dl_metrika_id; ?>" target="_blank" style="float: right" class="button">Отчет на Yandex.Metrika</a></h2>


<div class="wp-filter" style="margin: 0;">
	<ul class="filter-links">
		<li>Показать</li>
		<li>
			<a href="admin.php?page=dl_metrika_mobile&date=quart" 
			<? if($_GET['date'] == 'quart') echo 'class="current"' ?>>квартал</a>
			</li>
		<li>
			<a href="admin.php?page=dl_metrika_mobile&date=month" 
			<? if($_GET['date'] == '') echo 'class="current"';
			if($_GET['date'] == 'month') echo 'class="current"' ?>>месяц</a>
			</li>
		<li>
			<a href="admin.php?page=dl_metrika_mobile&date=week" 
			<? if($_GET['date'] == 'week') echo 'class="current"';
			?>>неделя</a>
			</li>
	</ul>
</div>


<div class="postbox-container" style="width: 100%">
	<div class="metabox-holder">
		<div class="meta-box-sortables">

		
		<div class="postbox" id="first">
			<div class="inside">
				<div id="dl_metrika_os" style="width: 98%; height: 400px;"></div>
			</div>
		</div>
				

<table class="wp-list-table widefat fixed striped posts">
	<thead>
		<tr>
			<th class="manage-column column-title"><a>Название операционной системы</a></th>
			<th class="manage-column column-author">Визиты</th>
			<th class="manage-column column-author">Просмотры</th>
			<th class="manage-column column-author">Отказы</th>
			<th class="manage-column column-author">Среднее время в секундах</th>
		</tr>
	</thead>
	
	<tbody>
	<?php

	$json_data = $json_data[data];
	
	foreach($json_data as $key => $value) { 
		$name		= $json_data[$key][name];			// Название операционной системы
		$visits		= $json_data[$key][visits];			// Визиты
		$page_views	= $json_data[$key][page_views]; 	// Просмотры
		$denial			= $json_data[$key][denial];		// Отказы		
		$visit_time		= $json_data[$key][visit_time];	// Среднее время в секундах
		$visit_time		= $visit_time/60;
	?>  
	<tr>
		<th class="manage-column column-title"><a><?php echo $name; ?></a></th>
		<th class="manage-column column-author"><?php echo $visits; ?></th>
		<th class="manage-column column-author"><?php echo $page_views; ?></th>
		<th class="manage-column column-author"><?php echo round($denial, 1); ?></th>
		<th class="manage-column column-author"><?php echo round($visit_time, 1); ?></th>
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