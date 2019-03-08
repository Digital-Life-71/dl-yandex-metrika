<div class="wrap">
<h2>Настроки</h2>
<form method="post" action="options.php">

	<?php settings_fields( 'dl-yandex-metrika-settings-group' ); ?>
	<?php settings_errors(); ?>
	
	<table class="form-table">
	<tr valign="top">
		<th scope="row">Сайт</th>
		<td><?php dl_select_options_counters(); ?></td>
	</tr>
	<!--<tr valign="top">
		<th scope="row">Режим разработки</th>
		<td>
		<p><input
			name="dl_yandex_metrika_developer_url" 
			type="checkbox" 
			id="dl_yandex_metrika_developer_url" 
			value="0" 
			<? checked( '0', get_option( 'dl_yandex_metrika_developer_url' ) ); ?>
			/><label for="dl_yandex_metrika_developer_url"> - выводить сылку на масив данных</label></p>
		<p>
		<input
			name="dl_yandex_metrika_developer" 
			type="checkbox" 
			id="dl_yandex_metrika_developer" 
			value="0" 
			<? checked( '0', get_option( 'dl_yandex_metrika_developer' ) ); ?>
			/><label for="dl_yandex_metrika_developer"> - выводить массив данных</label></p>
			</td>
	</tr>-->
	</table>
	

	<?php submit_button(); ?>

	
	<input 
		type="hidden" 
		name="dl_yandex_metrika_client_id" 
		value="<?php echo get_option('dl_yandex_metrika_client_id'); ?>">
	
	<input 
		type="hidden" 
		name="dl_yandex_metrika_token" 
		value="<?php echo get_option('dl_yandex_metrika_token'); ?>">
</form>
</div>