<?php

function dl_yandex_metrika_filtr() {

$page = $_GET['page'];
$date1 = $_GET['date'];
$date2 = date('Ymd');
$period = $_GET['period'];

if($date1 == 'week') {
	$date1 = date('Ymd',strtotime("-7 day"));
} elseif($date1 == 'month') {
	$date1 = date('Ymd',strtotime("-1 month"));
} elseif($date1 == 'quart') {
	$date1 = date('Ymd',strtotime("-3 month"));
} elseif($date1 == 'year') {
	$date1 = date('Ymd',strtotime("-12 month"));
} else {
	$date1 = date('Ymd',strtotime("-7 day"));
}


if($period == '' ) {
	$period = 'day';	
} else {
	$period = $_GET['period'];
}

?>
<div class="wp-filter" style="margin: 0;">
	<ul class="filter-links">
		<li>Показать за:</li>
		<li>
			<a href="admin.php?page=<? echo $page; ?>&date=week&group=<? echo $group; ?>" 
			<?  if($_GET['date'] == '') echo 'class="current"';
			if($_GET['date'] == 'week') echo 'class="current"'; ?>>неделя</a>
			</li>
		<li>
			<a href="admin.php?page=<? echo $page; ?>&date=month&group=<? echo $group; ?>" 
			<? if($_GET['date'] == 'month') echo 'class="current"' ?>>месяц</a>
			</li>
		<li style="border-right: 1px solid #e5e5e5;">
			<a href="admin.php?page=<? echo $page; ?>&date=quart&group=<? echo $group;?>" 
			<? if($_GET['date'] == 'quart') echo 'class="current"' ?>>квартал</a>
			</li>
		
		<li style="margin: 0 10px;">Детализация:</li>	
		<li>
			<a 
				href="admin.php?page=<? echo $page; ?>&group=<? echo $group; ?>&period=day" 
				<? if($period == 'day') echo 'class="current"';?>>по дням</a>
			</li>
		<li>
			<a 
				href="admin.php?page=<? echo $page; ?>&group=<? echo $group; ?>&period=week" 
				<? if($period == 'week') echo 'class="current"';?>>по неделям</a>
			</li>	
		<li>
			<a 
				href="admin.php?page=<? echo $page; ?>&group=<? echo $group; ?>&period=month" 
				<? if($period == 'month') echo 'class="current"';?>>по месяцам</a>
			</li>	
	</ul>
</div>
<?php
}

function dl_yandex_metrika_filtr_date() {

$page = $_GET['page'];
$date1 = $_GET['date'];
$date2 = date('Ymd');


if($date1 == 'week') {		// ???? ??????
	$date1 = date('Ymd',strtotime("-7 day"));
} elseif($date1 == 'month') {	// ???? ?????
	$date1 = date('Ymd',strtotime("-1 month"));
} elseif($date1 == 'quart') {	// ???? ???????
	$date1 = date('Ymd',strtotime("-3 month"));
} elseif($date1 == 'year') {	// ???? ???
	$date1 = date('Ymd',strtotime("-12 month"));
} else {
	$date1 = date('Ymd',strtotime("-7 day"));
}

?>
<div class="wp-filter" style="margin: 0;">
	<ul class="filter-links"> 
		<li>Показать за:</li>
		<li>
			<a href="admin.php?page=<? echo $page; ?>&date=week" 
			<?  if($_GET['date'] == '') echo 'class="current"';
			if($_GET['date'] == 'week') echo 'class="current"'; ?>>неделя</a>
			</li>
		<li>
			<a href="admin.php?page=<? echo $page; ?>&date=month" 
			<? if($_GET['date'] == 'month') echo 'class="current"' ?>>месяц</a>
			</li>
		<li>
			<a href="admin.php?page=<? echo $page; ?>&date=quart" 
			<? if($_GET['date'] == 'quart') echo 'class="current"' ?>>квартал</a>
			</li>	
	</ul>
</div>
<?php
}