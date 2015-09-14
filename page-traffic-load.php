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


$group = $_GET['group'];
if($group == 'day'){
	$group = 'day';
} elseif($group == 'week') {
	$group = 'week';
} elseif($group == 'month') {
	$group = 'month';
} else {
	$group = 'day';
}


$url = 'https://api-metrika.yandex.ru/stat/traffic/load.json?id='.$dl_metrika_id.'&oauth_token='.$dl_token.'&date1='.$date1.'&date2='.$date2.'&group='.$group;
$json_data = file_get_contents($url);
$json_data = json_decode($json_data, true); 
?>
<div class="wrap">
<h2>Отчет Нагрузка на сайт <a href="https://metrika.yandex.ru/legacy/load?id=<?php echo $dl_metrika_id; ?>" target="_blank" style="float: right" class="button">Отчет на Yandex.Metrika</a></h2>
<script type="text/javascript">
      google.load("visualization", "1.1", {packages:["bar"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['', 'Запросы в секунду (максимум)', 'Посетители онлайн (максимум)'],
<?php
foreach($json_data[data] as $key => $value) { 
	
	$date = date('d.m.y',strtotime($json_data[data][$key][date]));
	$max_rps = $json_data[data][$key][max_rps];
	$max_users = $json_data[data][$key][max_users];
	
	echo '[\''. $date .'\','.$max_rps.','.$max_users.'],';

}
?>
        ]);

         var options = {
          chart: {
            title: 'Данные о максимальном количестве запросов (срабатываний счетчика) в секунду и максимальное количество посетителей онлайн'
          }
        };

        var chart = new google.charts.Bar(document.getElementById('visites_div'));

        chart.draw(data, options);
		
	}
    </script>
	

<div class="wrap">
<div class="wp-filter" style="margin: 0;">
	<ul class="filter-links">
		<li>Показать</li>
		<li>
			<a href="admin.php?page=dl_metrika_traffic_load&date=quart&group=<? echo $group;?>" 
			<? if($_GET['date'] == 'quart') echo 'class="current"' ?>>квартал</a>
			</li>
		<li>
			<a href="admin.php?page=dl_metrika_traffic_load&date=month&group=<? echo $group; ?>" 
			<? if($_GET['date'] == '') echo 'class="current"';
			if($_GET['date'] == 'month') echo 'class="current"' ?>>месяц</a>
			</li>
		<li style="border-right: 1px solid #e5e5e5;">
			<a href="admin.php?page=dl_metrika_traffic_load&date=week&group=<? echo $group; ?>" 
			<? if($_GET['date'] == 'week') echo 'class="current"';
			?>>неделя</a>
			</li>
		
		<li style="margin: 0 10px;">Детализация</li>	
		<li>
			<a href="admin.php?page=dl_metrika_traffic_load&date=<? echo $_GET['date'] ?>&group=day" <? 
			if($_GET['group'] == '') echo 'class="current"';
			if($_GET['group'] == 'day') echo 'class="current"';?>>по дням</a>
			</li>
		<li>
			<a href="admin.php?page=dl_metrika_traffic_load&date=<? echo $_GET['date'] ?>&group=week" <? if($_GET['group'] == 'week') echo 'class="current"';?>>по неделям</a>
			</li>	
		<li>
			<a href="admin.php?page=dl_metrika_traffic_load&date=<? echo $_GET['date'] ?>&group=month" <? if($_GET['group'] == 'month') echo 'class="current"';?>>по месяцам</a>
			</li>	
	</ul>
</div>

    <div class="postbox-container" style="width: 100%">
        <div class="metabox-holder">
            <div class="meta-box-sortables">
			
			
                <div class="postbox" id="first">
                    <div class="inside">
						<div id="visites_div" style="width: 98%; height: 250px;"></div>
                    </div>
                </div>
				

<table class="wp-list-table widefat fixed striped posts">
<thead>
<tr>
	<th class="manage-column column-title"><a>Дата</a></th>
	<th class="manage-column column-author">Запросы в секунду (максимум)</th>
	<th class="manage-column column-author">Посетители онлайн (максимум)</th>
</tr>
</thead>

<tbody>
<?php
foreach($json_data[data] as $key => $value) { 
	$traffic_date		= $json_data[data][$key][date];
	$traffic_max_rps	= $json_data[data][$key][max_rps];
	$traffic_max_users	= $json_data[data][$key][max_users];
?>  
<tr>
  <th class="manage-column column-title"><a><?php echo date('Y.m.d',strtotime($traffic_date)); ?></a></th>
  <th class="manage-column column-author"><?php echo $traffic_max_rps; ?></th>
  <th class="manage-column column-author"><?php echo $traffic_max_users; ?></th>
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