<?php
function dl_yandex_metrika_add_dashboard_widgets_geo() {
    wp_add_dashboard_widget(
        'geo_dashboard_widget',         // Идентификатор виджета.
        'Просмотр по странам мира',           // Заголовок виджета.
        'geo_dashboard_widget_function' // Функция отображения.
    );
}
add_action('wp_dashboard_setup', 'dl_yandex_metrika_add_dashboard_widgets_geo');

function geo_dashboard_widget_function() {
	$dl_metrika_id = get_option('dl_yandex_metrika_id');
	$dl_token = get_option('dl_yandex_metrika_token');

	$url = 'https://api-metrika.yandex.ru/stat/geo.json?id='.$dl_metrika_id.'&oauth_token='.$dl_token;
	$json_data = file_get_contents($url);
	$json_data = json_decode($json_data, true);

	echo '<style>
			.column {
				-webkit-column-count: 2;
				-moz-column-count: 2;
				column-count: 2;
				-webkit-column-gap: 30px;
				-moz-column-gap: 30px;
				column-gap: 30px;
				-webkit-column-rule: 1px solid #ccc;
				-moz-column-rule: 1px solid #ccc;
				column-rule: 1px solid #ccc;
			}
		</style>';

	echo '<ul class="column">';
	foreach($json_data['data'] as $key => $value) {
		echo '<li><strong>'. $json_data['data'][$key]['name'] .'</strong> - '.$json_data['data'][$key]['visits'];
	}
	echo '</ul>';
}