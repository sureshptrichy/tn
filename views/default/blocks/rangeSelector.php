<?php
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


$rightSeparatorFirst = FALSE;
$rightMenu = array();
foreach ($menu as $url => $route) {
	if ($route['main_order'] == 100) {
		$rightMenu[$url] = $route;
	}
}
?>
<div class="nav-wrapper">
<?php if ($hasYears) { ?>
	<ul class="nav navbar-nav">
		<li>
			<a id="monthSelector" class="<?php if ($monthDropdown) { ?>dropdown-toggle <?php } ?>" <?php if ($monthDropdown) { ?>data-toggle="dropdown" data-target="#"<?php } ?> href="<?php echo URL; ?>month/switch/<?php echo $currentMonth; ?>?rf=<?php echo $G->url->getUrl(); ?>">
				<?php echo $currentName; ?><?php if ($monthDropdown) { ?> <span class="caret"></span><?php } ?>
			</a>
			<?php if ($monthDropdown) { ?><ul class="dropdown-menu" role="menu" aria-labelledby="monthSelector">
				<?php
				if ($currentMonth != 0) {
					echo '<li><a href="'.URL.'month/switch/0?rf='.$G->url->getUrl().'">All Months</a></li>';
				}
				foreach ($monthsList as $val => $name) {
					$hasStuff = NULL;
					if (isset($dates[$currentYear][$val])) {
						$hasStuff = 'hasItems';
					}
					echo '<li class="'.$hasStuff.'"><a href="'.URL.'month/switch/'.$val.'?rf='.$G->url->getUrl().'">'.$name.'</a></li>';
				}
				?>
				</ul><?php } ?>
		</li>
		<li>
			<a id="yearSelector" class="<?php if ($yearDropdown) { ?>dropdown-toggle <?php } ?>" <?php if ($yearDropdown) { ?>data-toggle="dropdown" data-target="#"<?php } ?> href="<?php echo URL; ?>year/switch/<?php echo $currentYear; ?>?rf=<?php echo $G->url->getUrl(); ?>">
				<?php echo $currentYear; ?><?php if ($yearDropdown) { ?> <span class="caret"></span><?php } ?>
			</a>
			<?php if ($yearDropdown) { ?><ul class="dropdown-menu" role="menu" aria-labelledby="yearSelector">
				<?php
				foreach ($dates as $year => $months) {
					if ($year != $currentYear) {
						echo '<li><a href="'.URL.'year/switch/'.$year.'?rf='.$G->url->getUrl().'">'.$year.'</a></li>';
					}
				}
				?>
				</ul><?php } ?>
		</li>
		<li class="menu-right"><a href="<?php echo URL; ?>logout">Logout</a></li>
		<li class="menu-right"><a href="javascript:window.print();"><i class="fa fa-print"></i></a></li>
		<?php
		foreach ($rightMenu as $url => $route) {
			if (isset($route['separator']) && $route['separator']) {
				echo '<li class="divider"></li>';
			}
			$active = NULL;
			$dropdown = NULL;
			if ($G->url->isCurrent($url)) {
				$active = 'active';
			}
			if (isset($route['_children'])) {
				if (isset($route['separator']) && $route['separator']) {
					echo '<li class="divider"></li>';
				}
				echo "<li class=\"dropdown menu-right $active\"><a href=\"".URL."$url\" class=\"dropdown-toggle\" data-toggle=\"dropdown\">Settings <b class=\"caret\"></b></a>";
				?><ul class="dropdown-menu on-hover"><?php
				foreach ($route['_children'] as $subUrl => $subRoute) {
					if (isset($subRoute['separator'])) {
						if ($subRoute['separator']) {
							if (TRUE === $rightSeparatorFirst) {
								echo '<li class="divider"></li>';
							}
							$rightSeparatorFirst = TRUE;
						}
						if (TRUE !== $subRoute['separator']) {
							echo '<li class="dropdown-header">'.$subRoute['separator'].'</li>';
						}
					}
					$active = NULL;
					if ($G->url->isCurrent($url.'/'.$subUrl)) {
						$active = 'active';
					}
					echo "<li class=\"$active\"><a href=\"".URL."$url/$subUrl\">{$subRoute['name']}</a>";
				}
				?></ul></li><?php
			} else {
				echo "<li class=\"$active\"><a href=\"".URL."$url\">{$route['name']}</a></li>";
			}
		}
		?>
	</ul>
<?php } ?>
</div>