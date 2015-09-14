<?php
$dl_metrika_id = get_option('dl_yandex_metrika_id');
$dl_token = get_option('dl_yandex_metrika_token');

$url = 'https://api-metrika.yandex.ru/stat/traffic/summary.json?id='.$dl_metrika_id.'&oauth_token='.$dl_token;
$json_data = file_get_contents($url);
$json_data = json_decode($json_data, true);
?>
<div class="wrap">
<h2>Сводка за неделю (<?php echo date('d.m',strtotime($json_data[date1])); ?> - <?php echo date('d.m',strtotime($json_data[date2])); ?>)</h2>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Дата', 'Посетители'],
<?php
foreach($json_data[data] as $key => $value) { 
	
	$date = date('d.m.y',strtotime($json_data[data][$key][date]));
	$visites = $json_data[data][$key][visits];
	
	echo '[\''. $date .'\','.$visites.'],';

}
?>
        ]);

        var options = {
			legend: { position: "none" }
		};

        var chart = new google.visualization.AreaChart(document.getElementById('visites_div'));
        chart.draw(data, options);
      }
    </script>

<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Дата', 'Новые посетители'],
<?php
foreach($json_data[data] as $key => $value) { 
	
	$date = date('d.m.y',strtotime($json_data[data][$key][date]));
	$new_visitors = $json_data[data][$key][new_visitors];
	
	echo '[\''. $date .'\','.$new_visitors.'],';

}
?>
        ]);

        var options = {
			legend: { position: "none" }
		};

        var chart = new google.visualization.AreaChart(document.getElementById('new_visitors_div'));
        chart.draw(data, options);
      }
    </script>
	

<div class="wrap">
    <div class="postbox-container" style="width: 100%">
        <div class="metabox-holder">
            <div class="meta-box-sortables">
			
			
                <div class="postbox" id="first">
                    <h3 class="hndle" style="cursor: default">Посетители (<?php echo $json_data[totals][visits] ?>)</h3>
                    <div class="inside">
                        <div id="visites_div" style="width: 90%; height: 150px;"></div>
                    </div>
                </div>
				
				
                <div class="postbox" id="second">
                    <h3 class="hndle" style="cursor: default">Новые посетители (<?php echo $json_data[totals][visitors] ?>)</h3>
                    <div class="inside">
                        <div id="new_visitors_div" style="width: 90%; height: 150px;"></div>
                    </div>
                </div>

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