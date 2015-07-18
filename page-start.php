<?php
$dl_metrika_id = get_option('dl_yandex_metrika_id');
$dl_token = get_option('dl_yandex_metrika_token');

$url = 'https://api-metrika.yandex.ru/stat/traffic/summary.json?id='.$dl_metrika_id.'&oauth_token='.$dl_token;
$data_traffic = file_get_contents($url);
$data_traffic = json_decode($data_traffic, true);
?>
<div class="wrap">
<h2>Сводка за неделю (<?php echo date('d.m',strtotime($data_traffic[date1])); ?> - <?php echo date('d.m',strtotime($data_traffic[date2])); ?>)</h2>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Дата', 'Посетители'],
<?php
foreach($data_traffic[data] as $key => $value) { 
	
	$date = date('d.m',strtotime($data_traffic[data][$key][date]));
	$visites = $data_traffic[data][$key][visits];
	
	echo '[\''. $date .'\','.$visites.'],';

}
?>
        ]);

        var options = {};

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
foreach($data_traffic[data] as $key => $value) { 
	
	$date = date('d.m',strtotime($data_traffic[data][$key][date]));
	$new_visitors = $data_traffic[data][$key][new_visitors];
	
	echo '[\''. $date .'\','.$new_visitors.'],';

}
?>
        ]);

        var options = {};

        var chart = new google.visualization.AreaChart(document.getElementById('new_visitors_div'));
        chart.draw(data, options);
      }
    </script>
	

<div class="wrap">
    <div class="postbox-container" style="width: 100%">
        <div class="metabox-holder">
            <div class="meta-box-sortables">
			
			
                <div class="postbox" id="first">
                    <h3 class="hndle" style="cursor: default">Посетители (<?php echo $data_traffic[totals][visits] ?>)</h3>
                    <div class="inside">
                        <div id="visites_div" style="width: 90%; height: 150px;"></div>
                    </div>
                </div>
				
				
                <div class="postbox" id="second">
                    <h3 class="hndle" style="cursor: default">Новые посетители (<?php echo $data_traffic[totals][visitors] ?>)</h3>
                    <div class="inside">
                        <div id="new_visitors_div" style="width: 90%; height: 150px;"></div>
                    </div>
                </div>

				<?php if(get_option('dl_yandex_metrika_developer') <> '') { ?>
				<div class="postbox" id="second">
                    <h3 class="hndle" style="cursor: default">Массив данных</h3>
                    <div class="inside">
						<?php if(get_option('dl_yandex_metrika_developer_url') <> '') { ?>
						<a href="<?php echo $url.'&pretty=1'; ?>" target="_blank"><?php echo $url; ?></a><?php } ?>						
                        <pre><?php print_r($data_traffic); ?></pre>
                    </div>
                </div>
				<?php } ?>
            </div>
        </div>
    </div>
</div>