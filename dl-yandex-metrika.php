<?php
/*
Plugin Name: DL Yandex Metrika
Description: Яндекс.Метрика — это сервис веб-аналитики для оценки эффективности сайтов. Он позволяет анализировать:конверсию и выручку сайта, эффективность рекламы (Яндекс.Директ, Яндекс.Маркет и т. д.), аудиторию сайта и поведение посетителей, источники, привлекающие посетителей. Все инструменты Яндекс.Метрики бесплатны.
Plugin URI: http://vcard.dd-l.name/wp-plugins/
Version: 0.3.6.1
Author: Dyadya Lesha (info@dd-l.name)
Author URI: http://dd-l.name
*/

add_action( 'admin_menu', 'dl_yandex_metrika_menu' );
function dl_yandex_metrika_menu(){

	add_menu_page(
		'DL Yandex Metrika',
		'DL Metrika',
		'level_7',
		'dl_metrika_dashboard',
		'',
		'dashicons-chart-area');

	add_submenu_page('dl_metrika_dashboard',
		'Сводка',
		'Сводка',
		'level_7',
		'dl_metrika_dashboard',
		'dl_yandex_metrika_start');

	if(get_option('dl_yandex_metrika_id') <> '') {
		add_submenu_page('dl_metrika_dashboard',
			'Посещаемость',
			'Посещаемость',
			'level_7',
			'dl_metrika_traffic',
			'dl_yandex_metrika_traffic');

		add_submenu_page('dl_metrika_dashboard',
			'География',
			'География',
			'level_7',
			'dl_metrika_geo',
			'dl_yandex_metrika_geo');

		add_submenu_page('dl_metrika_dashboard',
			'Демография',
			'Демография',
			'level_7',
			'dl_metrika_demography',
			'dl_yandex_metrika_demography');

		add_submenu_page('dl_metrika_dashboard',
			'Операционные системы',
			'Операционные системы',
			'level_7',
			'dl_metrika_os',
			'dl_yandex_metrika_os');

		add_submenu_page('dl_metrika_dashboard',
			'Мобильные устройства',
			'Мобильные устройства',
			'level_7',
			'dl_metrika_mobile',
			'dl_yandex_metrika_mobile');

		add_submenu_page('dl_metrika_dashboard',
			'Нагрузка на сайт',
			'Нагрузка на сайт',
			'level_7',
			'dl_metrika_traffic_load',
			'dl_yandex_metrika_traffic_load');

		add_submenu_page('dl_metrika_dashboard',
			'Поведение на сайте',
			'Поведение на сайте',
			'level_7',
			'dl_metrika_inpage',
			'dl_yandex_metrika_inpage');

		add_submenu_page('dl_metrika_dashboard',
			'Настройки',
			'Настройки',
			'level_8',
			'dl_metrika_settings',
			'dl_yandex_metrika_settings');
	}
}


function dl_yandex_metrika_start() {
	if(get_option('dl_yandex_metrika_id') == '') {
		include 'page-install.php';
	} else {
		include 'page-dashboard.php';
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

function dl_yandex_metrika_os(){
	include 'page-os.php';
}

function dl_yandex_metrika_mobile(){
	include 'page-mobile.php';
}

function dl_yandex_metrika_traffic_load(){
	include 'page-traffic-load.php';
}

function dl_yandex_metrika_inpage(){
	include 'page-inpage.php';
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


add_action( 'admin_enqueue_scripts', 'dl_yandex_metrika_admin_load_scripts' );
function dl_yandex_metrika_admin_load_scripts() {
    wp_enqueue_script( 'my_custom_script', 'https://www.google.com/jsapi' );
}


function dl_select_options_counters() {
	$url_counters = file_get_contents('https://api-metrika.yandex.ru/counters.json?oauth_token='.get_option('dl_yandex_metrika_token'));
	$json_data = json_decode($url_counters, true);
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

if(get_option('dl_yandex_metrika_id') <> '') {
	require_once( plugin_dir_path( __FILE__ ) . 'widgets/dashboard-widgets-traffic.php');
	require_once( plugin_dir_path( __FILE__ ) . 'widgets/dashboard-widgets-geo.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'widgets/dashboard-widgets-demography.php' );
}

// добавляем ссылку на панель WordPress
// добавляем ссылку на панель WordPress
function dl_yandex_metrika_toolbar($wp_admin_bar) {
	$args = array(
		'id' => 'dl_yandex_metrika_toolbar',
		'title' => 'DL Metrika',
		'href' => '/wp-admin/admin.php?page=dl_metrika_dashboard',
		'meta' => array(
		'target' => '_self',
			'title' => 'DL Metrika',
			)
	);
	$wp_admin_bar->add_node($args);


	$args = array(
		'id' => 'dl_metrika_dashboard',
		'title' => 'Сводка',
		'href' => '/wp-admin/admin.php?page=dl_metrika_dashboard',
		'parent' => 'dl_yandex_metrika_toolbar',
		'meta' => array(
			'title' => 'Сводка'
			)
	);
	$wp_admin_bar->add_node($args);

	$args = array(
		'id' => 'dl_metrika_traffic',
		'title' => 'Посещаемость',
		'href' => '/wp-admin/admin.php?page=dl_metrika_traffic',
		'parent' => 'dl_yandex_metrika_toolbar',
		'meta' => array(
			'title' => 'Посещаемость'
			)
	);
	$wp_admin_bar->add_node($args);

	$args = array(
		'id' => 'dl_metrika_geo',
		'title' => 'География',
		'href' => '/wp-admin/admin.php?page=dl_metrika_geo',
		'parent' => 'dl_yandex_metrika_toolbar',
		'meta' => array(
			'title' => 'География'
			)
	);
	$wp_admin_bar->add_node($args);

	$args = array(
		'id' => 'dl_metrika_demography',
		'title' => 'Демография',
		'href' => '/wp-admin/admin.php?page=dl_metrika_demography',
		'parent' => 'dl_yandex_metrika_toolbar',
		'meta' => array(
			'title' => 'Демография'
			)
	);
	$wp_admin_bar->add_node($args);

	$args = array(
		'id' => 'dl_metrika_os',
		'title' => 'Операционные системы',
		'href' => '/wp-admin/admin.php?page=dl_metrika_os',
		'parent' => 'dl_yandex_metrika_toolbar',
		'meta' => array(
			'title' => 'Операционные системы'
			)
	);
	$wp_admin_bar->add_node($args);

	$args = array(
		'id' => 'dl_metrika_mobile',
		'title' => 'Мобильные устройства',
		'href' => '/wp-admin/admin.php?page=dl_metrika_mobile',
		'parent' => 'dl_yandex_metrika_toolbar',
		'meta' => array(
			'title' => 'Мобильные устройства'
			)
	);
	$wp_admin_bar->add_node($args);

	$args = array(
		'id' => 'dl_metrika_traffic_load',
		'title' => 'Нагрузка на сайт',
		'href' => '/wp-admin/admin.php?page=dl_metrika_traffic_load',
		'parent' => 'dl_yandex_metrika_toolbar',
		'meta' => array(
			'title' => 'Нагрузка на сайт'
			)
	);
	$wp_admin_bar->add_node($args);

	$args = array(
		'id' => 'dl_metrika_inpage',
		'title' => 'Поведение на сайте',
		'href' => '/wp-admin/admin.php?page=dl_metrika_inpage',
		'parent' => 'dl_yandex_metrika_toolbar',
		'meta' => array(
			'title' => 'Поведение на сайте'
			)
	);
	$wp_admin_bar->add_node($args);

	$args = array(
		'id' => 'dl_metrika_inpage_visor',
		'title' => 'Вебвизор',
		'href' => 'https://metrika.yandex.ru/stat/visor?id='.get_option('dl_yandex_metrika_id'),
		'parent' => 'dl_metrika_inpage',
		'meta' => array(
			'target' => '_blank',
			'title' => 'Вебвизор'
			)
	);
	$wp_admin_bar->add_node($args);

	$args = array(
		'id' => 'dl_metrika_inpage_link_map',
		'title' => 'Карта ссылок',
		'href' => 'http://inpage.metrika.yandex.ru/inpage/link_map?id='.get_option('dl_yandex_metrika_id'),
		'parent' => 'dl_metrika_inpage',
		'meta' => array(
			'target' => '_blank',
			'title' => 'Карта ссылок'
			)
	);
	$wp_admin_bar->add_node($args);

	$args = array(
		'id' => 'dl_metrika_inpage_click_map',
		'title' => 'Карта кликов',
		'href' => 'http://inpage.metrika.yandex.ru/inpage/click_map?id='.get_option('dl_yandex_metrika_id'),
		'parent' => 'dl_metrika_inpage',
		'meta' => array(
			'target' => '_blank',
			'title' => 'Карта кликов'
			)
	);
	$wp_admin_bar->add_node($args);

	$args = array(
		'id' => 'dl_metrika_inpage_scroll_map',
		'title' => 'Карта скроллинга',
		'href' => 'http://inpage.metrika.yandex.ru/inpage/scroll_map?id='.get_option('dl_yandex_metrika_id'),
		'parent' => 'dl_metrika_inpage',
		'meta' => array(
			'target' => '_blank',
			'title' => 'Карта скроллинга'
			)
	);
	$wp_admin_bar->add_node($args);

	$args = array(
		'id' => 'dl_metrika_inpage_form_analysis',
		'title' => 'Аналитика форм',
		'href' => 'http://inpage.metrika.yandex.ru/inpage/form_analysis?id='.get_option('dl_yandex_metrika_id'),
		'parent' => 'dl_metrika_inpage',
		'meta' => array(
			'target' => '_blank',
			'title' => 'Аналитика форм'
			)
	);
	$wp_admin_bar->add_node($args);
}
add_action('admin_bar_menu', 'dl_yandex_metrika_toolbar', 99);