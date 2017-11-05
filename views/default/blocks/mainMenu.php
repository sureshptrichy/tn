<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
$dates = getDateArray($G, TRUE);
$currentYear = session('year');
$currentMonth = session('month');
$hasYears = TRUE;
$yearDropdown = FALSE;
$monthDropdown = TRUE;
$monthsList = array(
	1 => 'January',
	2 => 'February',
	3 => 'March',
	4 => 'April',
	5 => 'May',
	6 => 'June',
	7 => 'July',
	8 => 'August',
	9 => 'September',
	10 => 'October',
	11 => 'November',
	12 => 'December'
);

$togglenav = 'display:none;';
if(session('togglenav') == 'Show Navigation'){
	$togglenav = 'display:block;';
} elseif(session('togglenav') == 'Hide Navigation'){
	$togglenav = 'display:none;';
} else {
	$togglenav = 'display:none;';
}
if (count($dates) > 1) {
	$yearDropdown = TRUE;
}
if (!isset($dates[$currentYear])) {
	$currentYear = date('Y', time());
	//$currentMonth = date('n', time());
	//session('year', $currentYear);
	//session('month', $currentMonth);
	$dates[$currentYear] = array();
}
if (!isset($dates[$currentYear][$currentMonth])) {
	if ($currentMonth != 0) {
		//$currentMonth = 0;
		//session('month', $currentMonth);
	}
}
$currentName = 'All Months';
if ($currentMonth != 0) {
	$currentName = date('F', strtotime("2013-$currentMonth-01"));
}

$leftMenu = array();
$rightMenu = array();
$rightSeparatorFirst = FALSE;
foreach ($menu as $url => $route) {    
	if ($route['main_order'] < 100) {
		$leftMenu[$url] = $route;
	} else {
		$rightMenu[$url] = $route;
	}
}

$mm = '';
?>
	<div class="nav-wrapper">
		<?php if (!empty($leftMenu)){ ?>
		<ul class="nav nav-justified nav-location">
			<?php
			foreach ($leftMenu as $url => $route) {
				if ($route['name'] != 'Templates'){
					if (isset($route['separator']) && $route['separator']) {
						echo '<li class="divider"></li>';
					}
					$active = NULL;
					if ($G->url->isCurrent($url)) {
						$active = 'class="active"';
					}
					/* if($route['name'] == 'Hourly Reviews' && !user_is('Department Manager')) {
						continue;
					}  */
					echo "<li $active><a href=\"".URL."$url\">{$route['name']}</a></li>";
				}
			}
			?>
		<?php //************** RANGE SELECTOR *************** // ?>
		</ul>
		<?php } ?>
		<?php
		if (!empty($leftMenu)){
			foreach ($leftMenu as $url => $route) {
				if ($G->url->isCurrent($url) || $G->url->parentUrl(0, true) == $url) {
					$mm .= "<li class=\"current-nav\">{$route['name']}</li>";
				}
			}
			if (!empty($rightMenu)){
				foreach ($rightMenu['settings']['_children'] as $url => $route) {
					if ($G->url->isCurrent('settings/'.$url) || 'settings/'.$G->url->parentUrl(0, true) == 'settings/'.$url) {
						$mm .= "<li class=\"current-nav\">{$route['name']}</li>";
					}
				}
			}
		}
		?>
		<?php if ($mm != ""){ ?>
		<ul class="nav nav-justified nav-location nav-single">
			<?php echo $mm; ?>
		</ul>
		<?php } ?>
	</div>