<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
$hasProperty = FALSE;
$propertyDropdown = FALSE;
$divisionDropdown = FALSE;
$depertmentDropdown = FALSE;
$userDropdown = FALSE;
$hasUsers = FALSE;
/*
$togglenav = 'display:none;';
if(session('togglenav') == 'Show Navigation'){
	$togglenav = 'display:none;';
} elseif(session('togglenav') == 'Hide Navigation'){
	$togglenav = 'display:block;';
} else {
	$togglenav = '';
}
*/
if (isset($currentProperty['name'])) {
	$hasProperty = TRUE;
}
if (count($propertyList) > 0) {
	$propertyDropdown = TRUE;
}
if (count($divisionList) > 0 && count($divisionList) != 1 && $hasProperty) {
	$divisionDropdown = TRUE;
}
if (count($departmentList) > 0 && count($departmentList) != 1 && $hasProperty && $currentDivision['id'] != 'all') {
	$depertmentDropdown = TRUE;
}
if (count($sortedUserList) > 0 || isset($currentUser['id'])) {
	$hasUsers = TRUE;
}
if ($hasUsers && $hasProperty) {
	$userDropdown = TRUE;
}

$dates = getDateArray($G, TRUE);
$currentYear = session('year');
$currentMonth = session('month');
$hasYears = TRUE;
$yearDropdown = TRUE;
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
$yearsList = array();

$nowYear = date('Y');
for($y=2016;  $y<=$nowYear; $y++) {
	$yearsList[] = $y;
}

/* if (count($dates) > 1) {
	$yearDropdown = TRUE;
}

if (!isset($dates[$currentYear])) {
	$currentYear = date('Y', time());
	//$currentMonth = date('n', time());
	//session('year', $currentYear);
	//session('month', $currentMonth);
	$dates[$currentYear] = array();
} */
/* if (!isset($dates[$currentYear][$currentMonth])) {
	if ($currentMonth != 0) {
		//$currentMonth = 0;
		//session('month', $currentMonth);
	}
} */
$currentName = 'All Months';
if ($currentMonth != 0) {
	$currentName = date('F', strtotime(date("Y")."-$currentMonth-01"));
}


$rightSeparatorFirst = FALSE;
$rightMenu = array();
foreach ($menu as $url => $route) {
	if ($route['main_order'] == 100) {
		$rightMenu[$url] = $route;
	}
}

$userId = session('user');
$loggedUser = get_model('user')->loadUser($userId);
if ($hasProperty) {
?>
<div class="nav-wrapper" id="main-navigation">
	<ul class="nav nav-justified nav-location">
		<li>
			<a id="monthSelector" class="<?php if ($monthDropdown) { ?>dropdown-toggle <?php } ?>" <?php if ($monthDropdown) { ?>data-toggle="dropdown" data-target="#"<?php } ?> href="<?php echo URL; ?>month/switch/<?php echo $currentMonth; ?>?rf=<?php echo $G->url->getUrl(); ?>">
				Month <?php echo $currentName; ?><?php if ($monthDropdown) { ?> <span class="caret"></span><?php } ?>
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
				Year <?php echo $currentYear; ?><?php if ($yearDropdown) { ?> <span class="caret"></span><?php } ?>
			</a>
			<?php if ($yearDropdown) { ?><ul class="dropdown-menu" role="menu" aria-labelledby="yearSelector">
				<?php
				foreach ($yearsList as $year) {
					if ($year != $currentYear) {
						echo '<li><a href="'.URL.'year/switch/'.$year.'?rf='.$G->url->getUrl().'">'.$year.'</a></li>';
					}
				}
				?>
				</ul><?php } ?>
		</li>
		<li id="propertySelector">
			<a class="<?php if ($propertyDropdown) { ?>dropdown-toggle <?php } ?>" <?php if ($propertyDropdown) { ?>data-toggle="dropdown" data-target="#"<?php } ?> href="<?php echo URL; ?>year/switch/<?php echo $currentYear; ?>?rf=<?php echo $G->url->getUrl(); ?>">
				<?php echo $currentProperty['name']; ?><?php if ($propertyDropdown) { ?> <span class="caret"></span><?php } ?>
			</a>
			<ul class="dropdown-menu" role="menu" aria-labelledby="propertySelector">
			<?php
			foreach ($propertyList as $id => $property) {
				$active = NULL;
				if ($property['id'] == $currentProperty['id']){
					$active = 'class="active"';
				}
				echo '<li '.$active.'><a href="'.URL.'property/switch/'.$id.'?rf='.$G->url->getUrl().'">'.$property['name'].'</a></li>';
			}
			?>
			</ul>
		</li>
		<?php
			/*
			foreach ($propertyList as $id => $property) {
				$active = NULL;
				if ($property['id'] == $currentProperty['id']){
					$active = 'class="active"';
				}
				echo '<li '.$active.'><a href="'.URL.'property/switch/'.$id.'?rf='.$G->url->getUrl().'">'.$property['name'].'</a></li>';
			}
			*/
		?>
		<?php //************** RANGE SELECTOR *************** // ?>
		<?php if ($hasYears) { ?>
			<?php
			foreach ($rightMenu as $url => $route) {
				if (isset($route['separator']) && $route['separator']) {
					//echo '<li class="divider"></li>';
				}
				$active = NULL;
				$dropdown = NULL;
				if ($G->url->isCurrent($url)) {
					$active = 'active';
				}
				if (isset($route['_children'])) {
					if (isset($route['separator']) && $route['separator']) {
						//echo '<li class="divider"></li>';
					}
					echo '<li class="dropdown menu-right '.$active.'"><a href="'.URL.$url.'" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cog"></i> <b class="caret"></b></a>';
					?><ul class="dropdown-menu on-hover"><?php
					foreach ($route['_children'] as $subUrl => $subRoute) {
						if (isset($subRoute['separator'])) {
							if ($subRoute['separator']) {
								if (TRUE === $rightSeparatorFirst) {
									//echo '<li class="divider"></li>';
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
					//echo "<li class=\"$active\" ><a href=\"".URL."$url\">{$route['name']}</a></li>";
					echo '<li class="'.$active.' menu-right"><a href="'.URL.$url.'">'.$route["name"].'</a></li>';
				}
			}
			?>
		<?php } ?>
		<li class="menu-right"><a href="javascript:window.print();"><i class="fa fa-print"></i></a></li>
		<li class="menu-right"><a href="<?php echo URL; ?>logout">Logout</a></li>
	</ul>
	<?php if (!empty($divisionListDisplay)){ ?>
	<ul class="nav nav-justified nav-location">
		<?php
			foreach ($divisionListDisplay as $id => $division) {
				$active = NULL;
				if ($division['id'] == $currentDivision['id']){
					$active = 'class="active"';
				}
				if (array_key_exists($division['id'], $divisionList)){
					echo '<li '.$active.'><a href="'.URL.'division/switch/'.$id.'?rf='.$G->url->getUrl().'">'.$division['name'].'</a></li>';
				} else {
					echo '<li class="display-only"><span>'.$division['name'].'</span></li>';
				}
			}
		?>
	</ul>
	<?php } ?>
	<?php if (!empty($departmentListDisplay)){ ?>
	<ul class="nav nav-justified nav-location">
		<?php
			foreach ($departmentListDisplay as $id => $department) {
				$active = NULL;
				if ($department['id'] == $currentDepartment['id']){
					$active = 'class="active"';
				}
				if (array_key_exists($department['id'], $departmentList)){
					echo '<li '.$active.'><a href="'.URL.'department/switch/'.$id.'?rf='.$G->url->getUrl().'">'.$department['name'].'</a></li>';
				} else {
					echo '<li class="display-only"><span>'.$department['name'].'</span></li>';
				}
			}
		?>
	</ul>
	<?php } ?>
	<?php if (!empty($sortedUserList)){ ?>
		
		<ul class="nav nav-justified nav-location">
		<li id="userSelector">
			<a class="<?php if ($currentUser) { ?>dropdown-toggle <?php } ?>" <?php if ($currentUser) { ?>data-toggle="dropdown" data-target="#"<?php } ?> href="<?php echo URL; ?>settings/users/switch/<?php echo $currentUser['id']; ?>?rf=<?php echo $G->url->getUrl(); ?>">
				<?php echo $currentUser['firstname'].' '.$currentUser['lastname']; ?><?php if ($currentUser) { ?> <span class="caret"></span><?php } ?>
			</a>
			<ul class="dropdown-menu" role="menu" aria-labelledby="userSelector">
			<?php
			foreach ($sortedUserList as $role => $userList) {
				$active = NULL;
				$username = $userList['firstname'].' '.$userList['lastname'];
				$url = URL.'settings/users/switch/'.$userList['id'].'?rf='.$G->url->getUrl();
				if ($userList['id'] == $currentUser['id']){
					$active = 'class="current-nav active"';
				}
				echo '<li '.$active.'><a href="'.$url.'">'.$username.'</a></li>';
			}
			?>
			</ul>
		</li>
	</ul>

	
	
	<?php //print_r($sortedUserList);exit; ?>
	
	<?php /*
	?>
	<ul class="nav nav-justified nav-location">
		<?php
			$count = 0;
			foreach ($sortedUserList as $role => $userList) {
				$count++;
				if ($count == 9){$count = 1;?>
	</ul>
	
	<?php //print_r($sortedUserList);exit; ?>
	<ul class="nav nav-justified nav-location">
		<?php }
			$url = URL.'settings/users/switch/'.$userList['id'].'?rf='.$G->url->getUrl();
			$username = $userList['firstname'].' '.$userList['lastname'];
			$active = '';
			if ($userList['id'] == $currentUser['id']) {
				$active = 'class="active"';
			}
			if ($userList['role'] != 'Super User' || $userList['id'] == $loggedUser['id']){
				//echo $username;
			?>
				<li <?=$active?>><a href="<?=$url?>"><?=$username?></a></li>
		<?php } elseif ($userList['role'] == 'Super User' && $property['name'] == 'Globi Northview Admin'){?>
			<li <?=$active?>><a href="<?=$url?>"><?=$username?></a></li>
		<?php }
		}
	?>
	</ul>
	<?php  */ ?>
	<?php } ?>
	
	<!-- 
	<ul class="nav nav-justified nav-location nav-single">
		<li class="current-nav"><?php echo $currentUser['firstname'].' '.$currentUser['lastname']; ?></li>
	</ul> -->
</div>
<?php } ?>