<?php
$dl_metrika_id = get_option('dl_yandex_metrika_id');
$dl_token = get_option('dl_yandex_metrika_token');

$date1 = $_GET['date'];
$date2 = date('Ymd');
$period = $_GET['period'];


if($date1 == 'week') {		// если неделя
	$date1 = date('Ymd',strtotime("-7 day"));
} elseif($date1 == 'month') {	// если месяц
	$date1 = date('Ymd',strtotime("-1 month"));
} elseif($date1 == 'quart') {	// если квартал
	$date1 = date('Ymd',strtotime("-3 month"));
} elseif($date1 == 'year') {	// если год
	$date1 = date('Ymd',strtotime("-12 month"));
} else {
	$date1 = date('Ymd',strtotime("-7 day"));
}


if($period == '' ) {
	$period = 'day';	
} else {
	$period = $_GET['period'];
}
?>

<div class="wrap">
<h2>Поисковые фразы <a href="https://metrika.yandex.ru/stat/phrases?id=<?php echo $dl_metrika_id; ?>" target="_blank" style="float: right" class="button">Отчет на Yandex.Metrika</a></h2>

<p class="description" ></p>

<?php dl_yandex_metrika_filtr_date(); ?>

<?php
	$array_url_data = array(
		'preset' => 'sources_search_phrases',
		'metrics' => 'ym:s:visits,ym:s:users,ym:s:bounceRate,ym:s:pageDepth,ym:s:avgVisitDurationSeconds',
		'group' => $period,
		'date1' => $date1,
		'date2' => $date2,
		'id' => $dl_metrika_id,
		'oauth_token' => $dl_token,
	);
	
	$url = 'https://api-metrika.yandex.ru/stat/v1/data?'. http_build_query($array_url_data);
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_FAILONERROR,1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	curl_setopt($ch, CURLOPT_HTTPHEADER,
		array(
			'Host: api-metrika.yandex.net',
			'Authorization: OAuth '.get_option('dl_yandex_metrika_token'),
			'Content-Type: application/x-yametrika+json',
			'Access-Control-Allow-Origin: *'
		));

	$json_data = curl_exec($ch);

	curl_close($ch);

	$json_data = json_decode($json_data, true);
	?>
	
	<!--
	<pre>
	<?php print_r($array_url_data); ?>
	</pre>
	
	<pre>
	<?php print_r($json_data); ?>
	</pre>
	-->
	
	<div class="tablenav top">

	</div>
	
	<table class="wp-list-table widefat fixed striped posts">
	<thead>
		<tr>
			<th class="manage-column column-title"><a>Поисковая фраза, Поисковая система</a></th>
			<th class="manage-column column-author">Визиты</th>
			<th class="manage-column column-author">Посетители</th>
			<th class="manage-column column-author">Отказы</th>
			<th class="manage-column column-author">Глубина просмотра</th>
			<th class="manage-column column-author">Время на сайте, м</th>
		</tr>
	</thead>
	
	<tbody>
		<tr style="background: #ddd">
			<th class="manage-column column-title"><a>Итого и средние</a></th>
			<th class="manage-column column-author"><?php echo $json_data[totals][0]; ?></th>
			<th class="manage-column column-author"><?php echo $json_data[totals][1]; ?></th>
			<th class="manage-column column-author"><?php echo round($json_data[totals][2], 2); ?> %</th>
			<th class="manage-column column-author"><?php echo round($json_data[totals][3], 2); ?></th>
			<th class="manage-column column-author"><?php echo round($json_data[totals][4]/60, 2); ?></th>
		</tr>
		
		<?php

		$json_data = $json_data[data];
		
		foreach($json_data as $key => $value)
		{ 
			$name	= $json_data[$key][dimensions][0][name];
			$name_1	= $json_data[$key][dimensions][1][name];
			$visits	= $json_data[$key][metrics][0];
			$users	= $json_data[$key][metrics][1];
			$bounceRate	= $json_data[$key][metrics][2];
			$pageDepth	= $json_data[$key][metrics][3];
			$avgVisitDurationSeconds	= $json_data[$key][metrics][4];
			
			$avgVisitDurationSeconds	= $avgVisitDurationSeconds/60; 
		?>  
		<tr>
			<th class="manage-column column-title"><a><?php echo $name . ' &rarr; ' . $name_1; ?></a></th>
			<th class="manage-column column-author"><?php echo $visits; ?></th>
			<th class="manage-column column-author"><?php echo $users; ?></th>
			<th class="manage-column column-author"><?php echo round($bounceRate, 2); ?> %</th>
			<th class="manage-column column-author"><?php echo round($pageDepth, 2); ?></th>
			<th class="manage-column column-author"><?php echo round($avgVisitDurationSeconds, 2); ?></th>
		</tr>
		<?php 
		}
		?>
	</tbody>
	
	<tfoot>
		<tr>
			<th class="manage-column column-title"><a>Поисковая фраза, Поисковая система</a></th>
			<th class="manage-column column-author">Визиты</th>
			<th class="manage-column column-author">Посетители</th>
			<th class="manage-column column-author">Отказы</th>
			<th class="manage-column column-author">Глубина просмотра</th>
			<th class="manage-column column-author">Время на сайте, м</th>
		</tr>
	</tfoot>
</table>

</div>