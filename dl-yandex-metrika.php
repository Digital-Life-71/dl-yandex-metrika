<?php
/*
Plugin Name: DL Yandex Metrika
Description: Яндекс.Метрика — это сервис веб-аналитики для оценки эффективности сайтов. Он позволяет анализировать:конверсию и выручку сайта, эффективность рекламы (Яндекс.Директ, Яндекс.Маркет и т. д.), аудиторию сайта и поведение посетителей, источники, привлекающие посетителей. Все инструменты Яндекс.Метрики бесплатны.
Plugin URI: http://dd-l.name/wordpress-plugins/
Version: 1.2
Author: Dyadya Lesha (info@dd-l.name)
Author URI: http://dd-l.name
*/

include_once 'filter.php'; 

add_action( 'admin_menu', 'dl_yandex_metrika_menu' );

function dl_yandex_metrika_menu(){	

	add_menu_page
	( 
		'DL Yandex Metrika',
		'DL Metrika',
		7,
		'dl_metrika_dashboard',
		'',
		'dashicons-chart-area',
		3
	);

	add_submenu_page
	(				    
		'dl_metrika_dashboard', 
		'Посещаемость', 
		'Посещаемость', 
		7, 
		'dl_metrika_dashboard', 
		'dl_yandex_metrika_start'
	);
		
	if(get_option('dl_yandex_metrika_id') <> '')
	{
		add_submenu_page('dl_metrika_dashboard', 
			'Источники, сводка', 
			'Источники, сводка', 
			7, 
			'dl_metrika_sources_summary', 
			'dl_yandex_metrika_sources_summary');
		
		add_submenu_page('dl_metrika_dashboard', 
			'Сайты', 
			'Сайты', 
			7, 
			'dl_metrika_sources_sites', 
			'dl_yandex_metrika_sources_sites');
		
		add_submenu_page('dl_metrika_dashboard', 
			'Поисковые системы', 
			'Поисковые системы', 
			7, 
			'dl_metrika_search_engines', 
			'dl_yandex_metrika_search_engines');
		
		add_submenu_page('dl_metrika_dashboard', 
			'Поисковые фразы', 
			'Поисковые фразы', 
			7, 
			'dl_metrika_sources_search_phrases', 
			'dl_yandex_metrika_sources_search_phrases');
		
		add_submenu_page('dl_metrika_dashboard', 
			'Социальные сети', 
			'Социальные сети', 
			7, 
			'dl_metrika_sources_social', 
			'dl_yandex_metrika_sources_social');
		
		add_submenu_page('dl_metrika_dashboard', 
			'Поведение на сайте', 
			'Поведение на сайте', 
			7, 
			'dl_metrika_inpage', 
			'dl_yandex_metrika_inpage');	
		
		add_submenu_page('dl_metrika_dashboard', 
			'Настройки', 
			'Настройки', 
			8, 
			'dl_metrika_settings', 
			'dl_yandex_metrika_settings');	
	}
}

function dl_yandex_metrika_start() { 
	if(get_option('dl_yandex_metrika_id') == '') {
		include 'page-install.php'; 
	} else {
		include 'page-traffic.php';
	}
}

function dl_yandex_metrika_traffic(){
	include 'page-traffic.php';
}

function dl_yandex_metrika_sources_summary(){
	include 'page-sources-summary.php';
}

function dl_yandex_metrika_sources_sites(){
	include 'page-sources-sites.php';
}

function dl_yandex_metrika_search_engines(){
	include 'page-search-engines.php';
}

function dl_yandex_metrika_sources_search_phrases(){
	include 'page-sources-search-phrases.php';
}

function dl_yandex_metrika_sources_social(){
	include 'page-sources-social.php';
}

function dl_yandex_metrika_inpage(){
	include 'page-inpage.php';
}

function dl_yandex_metrika_settings(){
	include 'page-settings.php';
}


add_action( 'admin_init', 'dl_yandex_metrika_register_settings' );
function dl_yandex_metrika_register_settings() {
	register_setting( 'dl-yandex-metrika-settings-group', 'dl_yandex_metrika_client_id' );
	register_setting( 'dl-yandex-metrika-settings-group', 'dl_yandex_metrika_token' );
	register_setting( 'dl-yandex-metrika-settings-group', 'dl_yandex_metrika_id' );
	register_setting( 'dl-yandex-metrika-settings-group', 'dl_yandex_metrika_developer' );
	register_setting( 'dl-yandex-metrika-settings-group', 'dl_yandex_metrika_developer_url' );
}


register_deactivation_hook( __FILE__, 'dl_yandex_metrika_deactivate' );
function dl_yandex_metrika_deactivate(){
	delete_option("dl_yandex_metrika_client_id");
	delete_option("dl_yandex_metrika_token");
	delete_option("dl_yandex_metrika_id");
	delete_option("dl_yandex_metrika_developer");
	delete_option("dl_yandex_metrika_developer_url");
}

function dl_select_options_counters() {
	
	$url ='https://api-metrika.yandex.net/management/v1/counters';
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


	/*echo '<pre>';
	print_r($json_data);
	echo '</pre>';*/
	
	echo '<select name="dl_yandex_metrika_id">';
	
	foreach($json_data[counters] as $key => $value) { 
		$site_name = $json_data[counters][$key][site];
		$site_id = $json_data[counters][$key][id];
		?>
		<option  
			<?php if ( get_option('dl_yandex_metrika_id') == $site_id ) echo 'selected="selected"'; ?>  
			value="<?php echo $site_id ?>"><?php echo $site_name; ?></option>
	<?php }
	
	echo '</select>';
}