<?php
$client_id	= get_option('dl_yandex_metrika_client_id');
$token		= get_option('dl_yandex_metrika_token');
$metrika_id	= get_option('dl_yandex_metrika_id');
?>
<div class="wrap">
<h2>Настройка DL Yandex Metrika</h2>
<form method="post" action="options.php">

	<?php settings_fields( 'dl-yandex-metrika-settings-group' ); ?>
	<?php settings_errors(); ?>

<?php if($client_id == '') { ?>

<p>Для настройки необходимо пройти 3 простых шага. 

<ol>
	<li>Получить ID приложения; 
	<li>Получить Токена; 
	<li>Выборать сайта из списка.
</ol>
	
<p>Для использования API Метрики необходимо получить авторизационный токен через OAuth-сервер Яндекса.

<p>Протокол OAuth 2.0 позволяет приложениям работать с сервисами Яндекса от имени пользователя. Доступ каждого приложения явно ограничивается правами, заданными при его регистрации.

<p>OAuth-авторизацию поддерживают Диск, Вебмастер, Метрика и другие сервисы.

<p><strong>Чтобы начать пользоваться протоколом, необходимо:</strong>

<ol>
	<li><a 
		href="https://oauth.yandex.ru/client/new" target="_blank" class="button" style="margin-top:-5px">Зарегистрировать</a> приложение на Яндекс.OAuth или <a href="https://oauth.yandex.ru/" target="_blank" >выбрать ранее созданное</a>.
	<p>Укажите свойства приложения:
	<p><strong>Название</strong> - Название приложения. Отображается на странице запроса доступа и в списке зарегистрированных приложений.
	<p><strong>Описание</strong> - Краткое описание приложения. Отображается в списке приложений, которым пользователь разрешил доступ к своему аккаунту.
	<p><strong>Ссылка на иконку</strong> - Ссылка на пиктограмму приложения. Необязательное cвойство.
	<p><strong>Ссылка на приложение</strong> - Ссылка на веб-страницу приложения. Необязательное свойство. Отображается в списке приложений, которым пользователь разрешил доступ к своему аккаунту.
	<p><strong>Права</strong> - Набор прав доступа (соответствует параметру scope протокола OAuth). Выбранные действия пользователи разрешают приложению при выдаче токенов.
	<p><img src="<?php echo plugins_url('dl-yandex-metrika/ym.jpg'); ?>" alt="Параметры которые необходимо отметить для приложения" style="max-width: 755px; width: 100%;">
	<p><strong>Callback URL</strong> - Адрес, на который пользователь возвращается после того, как он разрешил или отказал приложению в доступе. <strong>Укажите "https://oauth.yandex.ru/verification_code"</strong>
	<li>Ведите полученный ID приложения и нажмите кнопку "Сохранить и продолжить". 
	<p><input 
		type="text" 
		name="dl_yandex_metrika_client_id"
		value="<?php echo get_option('dl_yandex_metrika_client_id'); ?>" required> - ID приложения
</ol>

<p class="submit">
	<input type="submit" class="button-primary" value="Сохранить и продолжить" />
</p>

<?php } elseif ($token == '') { ?>

<p><strong>OAuth-токен</strong> - Строка, которая позволяет обращаться к сервису Яндекса от имени определенного пользователя. В контексте использования протокола «OAuth-токен» может сокращаться до «токен».

<p><strong>Продолжаем:</strong>

<ol>
	<li><a 
		target="_blank" href="https://oauth.yandex.ru/authorize?response_type=token&amp;client_id=<?php echo get_option('dl_yandex_metrika_client_id'); ?>" class="button" style="margin-top:-5px">
		Получить токен</a>
	<li>Ведите полученный "токен" и нажмите кнопку "Сохранить и продолжить".
	<p><input 
		type="text" 
		name="dl_yandex_metrika_token" 
		value="<?php echo get_option('dl_yandex_metrika_token'); ?>"  required> - Token доступа
		<input type="hidden" name="dl_yandex_metrika_client_id" value="<?php echo get_option('dl_yandex_metrika_client_id'); ?>">
	</ol>

<p class="submit">
	<input type="submit" class="button-primary" value="Сохранить и продолжить" />
</p>

<?php } elseif($metrika_id == '') { ?>

<p><strong>Почти все готово, остался один шаг.</strong>

	<p>Выберите сайт из списка <?php dl_select_options_counters(); ?>
	
	<input 
		type="hidden" 
		name="dl_yandex_metrika_client_id" 
		value="<?php echo get_option('dl_yandex_metrika_client_id'); ?>">
	
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
		name="dl_yandex_metrika_client_id" 
		value="<?php echo get_option('dl_yandex_metrika_client_id'); ?>">
	
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
			<p><code><?php echo $client_id; ?></code> - id приложения
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