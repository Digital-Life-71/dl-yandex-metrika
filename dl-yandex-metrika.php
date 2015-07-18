<?php
/*
Plugin Name: DL Yandex Metrika
Description: Яндекс.Метрика — это сервис веб-аналитики для оценки эффективности сайтов. Он позволяет анализировать:конверсию и выручку сайта, эффективность рекламы (Яндекс.Директ, Яндекс.Маркет и т. д.), аудиторию сайта и поведение посетителей, источники, привлекающие посетителей. Все инструменты Яндекс.Метрики бесплатны.
Plugin URI: http://vcard.dd-l.name/wp-plugins/
Version: 0.2.1
Author: Dyadya Lesha (info@dd-l.name)
Author URI: http://dd-l.name
*/

add_action( 'admin_menu', 'dl_yandex_metrika_menu' );
function dl_yandex_metrika_menu(){	

	add_menu_page( 
		'DL Yandex Metrika',
		'DL Metrika',
		'administrator',
		'dl_metrika_start',
		'',
		'dashicons-chart-area');

	add_submenu_page('dl_metrika_start', 
		'Сводка', 
		'Сводка', 
		'administrator', 
		'dl_metrika_start', 
		'dl_yandex_metrika_start');
		
	if(get_option('dl_yandex_metrika_id') <> '') {
		add_submenu_page('dl_metrika_start', 
			'Посещаемость', 
			'Посещаемость', 
			'administrator', 
			'dl_metrika_traffic', 
			'dl_yandex_metrika_traffic');
			
		add_submenu_page('dl_metrika_start', 
			'География', 
			'География', 
			'administrator', 
			'dl_metrika_geo', 
			'dl_yandex_metrika_geo');

		add_submenu_page('dl_metrika_start', 
			'Демография', 
			'Демография', 
			'administrator', 
			'dl_metrika_demography', 
			'dl_yandex_metrika_demography');	
		
		add_submenu_page('dl_metrika_start', 
			'Настройки', 
			'Настройки', 
			'administrator', 
			'dl_metrika_settings', 
			'dl_yandex_metrika_settings');	
	}	
}


function dl_yandex_metrika_start() { 
	if(get_option('dl_yandex_metrika_id') == '') {
		include 'page-install.php'; 
	} else {
		include 'page-start.php';
	}
}


function dl_yandex_metrika_settings(){
	include 'page-settings.php';
}

function dl_yandex_metrika_traffic(){
	include 'page-traffic.php';
}

function dl_yandex_metrika_geo(){
	include 'page-geo.php';
}

function dl_yandex_metrika_demography(){
	include 'page-demography.php';
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


function dl_yandex_metrika_admin_load_scripts() {
    wp_enqueue_script( 'my_custom_script', 'https://www.google.com/jsapi' );
}
add_action( 'admin_enqueue_scripts', 'dl_yandex_metrika_admin_load_scripts' );


function dl_select_options_counters() {
	$url_counters = file_get_contents('https://api-metrika.yandex.ru/counters.json?oauth_token='.get_option('dl_yandex_metrika_token'));
	$counters = json_decode($url_counters, true);
	echo '<select name="dl_yandex_metrika_id">';
	
	foreach($counters[counters] as $key => $value) { 
		$site_name = $counters[counters][$key][site];
		$site_id = $counters[counters][$key][id];
		?>
		<option  
			<?php if ( get_option('dl_yandex_metrika_id') == $site_id ) echo 'selected="selected"'; ?>  
			value="<?php echo $site_id ?>"><?php echo $site_name; ?></option>
	<?php }
	
	echo '</select>';
}