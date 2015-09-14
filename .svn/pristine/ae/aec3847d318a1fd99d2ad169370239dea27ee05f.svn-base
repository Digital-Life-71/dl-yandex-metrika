<?php
$token		= get_option('dl_yandex_metrika_token');
$metrika_id	= get_option('dl_yandex_metrika_id');
?>
<div class="wrap">
<h2>Настройка DL Yandex Metrika</h2>
<form method="post" action="options.php">

	<?php settings_fields( 'dl-yandex-metrika-settings-group' ); ?>
	
	<?php settings_errors(); ?>

<?php if ($token == '') { ?>

<ol>
	<li><a 
		target="_blank" href="https://oauth.yandex.ru/authorize?response_type=token&amp;client_id=d8de135c2b1045edb2199b258b9f23f0" class="button" style="margin-top:-5px">
		Разрешить доступ к своим данным и получить токен</a>
	<li>Ведите полученный "токен" и нажмите кнопку "Сохранить и продолжить".
	<p><input 
		type="text" 
		name="dl_yandex_metrika_token" 
		value="<?php echo get_option('dl_yandex_metrika_token'); ?>"  required> - Token доступа
</ol>

<p class="submit">
	<input type="submit" class="button-primary" value="Сохранить и продолжить" />
</p>

<?php } elseif($metrika_id == '') { ?>

<p><strong>Почти все готово, остался один шаг.</strong>

	<p>Выберите сайт из списка <?php dl_select_options_counters(); ?>
	
	<input 
		type="hidden" 
		name="dl_yandex_metrika_token" 
		value="<?php echo get_option('dl_yandex_metrika_token'); ?>">

<p class="submit">
	<input type="submit" class="button-primary" value="Завершить настройку" />
</p>

<?php } else { ?>

	<input 
		type="hidden" 
		name="dl_yandex_metrika_token" 
		value="<?php echo get_option('dl_yandex_metrika_token'); ?>">
<table class="form-table">
	<tbody>
	<tr valign="top">
		<th scope="row">Показывать метрику для сайта</th>
		<td>
			<p><?php echo echo_all_counters(); ?>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">Общая информация</th>
		<td>
			<p><code><?php echo $token; ?></code> - токен доступа
			<p><code><?php echo $metrika_id; ?></code> - id счетчика
		</td>
	</tr>
	</tbody><tr valign="top">
		<th scope="row">Внешний вид</th>
		<td></td>
	</tr>
	<tr valign="top">
		<th scope="row">Для разработчиков</th>
		<td></td>
	</tr>
	<tr valign="top">
		<th scope="row"></th>
		<td></td>
	</tr>
	<tr valign="top">
		<th scope="row"></th>
		<td></td>
	</tr>
	<tr valign="top">
		<th scope="row"></th>
		<td></td>
	</tr>
	</tbody>
</table>
<p class="submit">
	<input type="submit" class="button-primary" value="Сохранить" />
	<input type="submit" class="button" name="del" value="Сбросить настройки" />
</p>
<?php } ?>
</form>
</div>