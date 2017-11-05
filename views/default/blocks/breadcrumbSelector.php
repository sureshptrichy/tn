<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.')); ?>
<ol id="main-breadcrumb" class="breadcrumb">
<?php
$hasProperty = FALSE;
if (count($propertyList) > 0) { $hasProperty = TRUE; ?>
	<li class="dropdown">
		<a id="propertySelector" class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="<?php echo URL; ?>property/switch/<?php echo session('property'); ?>?rf=<?php echo $G->url->getUrl(); ?>">
			<?php echo $currentProperty['name']; ?> <span class="caret"></span>
		</a>
		<ul class="dropdown-menu" role="menu" aria-labelledby="propertySelector">
			<?php
			foreach ($propertyList as $id => $property) {
				echo "<li><a href=\"".URL."property/switch/$id?rf=".$G->url->getUrl()."\">{$property['name']}</a></li>";
			}
			?>
		</ul>
	</li>
<?php } else {
	if (isset($currentProperty['name'])) { $hasProperty = TRUE; ?>
	<li>
		<a id="propertySelector" href="<?php echo URL; ?>property/switch/<?php echo session('property'); ?>?rf=<?php echo $G->url->getUrl(); ?>">
			<?php echo $currentProperty['name']; ?>
		</a>
	</li>
<?php
	}
}
if (count($divisionList) > 0 && $hasProperty) { ?>
	<li class="dropdown">
		<a id="divisionSelector" class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="<?php echo URL; ?>division/switch/<?php echo session('division'); ?>?rf=<?php echo $G->url->getUrl(); ?>">
			<?php echo $currentDivision['name']; ?> <span class="caret"></span>
		</a>
		<ul class="dropdown-menu" role="menu" aria-labelledby="divisionSelector">
			<?php
			foreach ($divisionList as $id => $division) {
				echo "<li><a href=\"".URL."division/switch/$id?rf=".$G->url->getUrl()."\">{$division['name']}</a></li>";
			}
			?>
		</ul>
	</li>
<?php } else {
	if (isset($currentDivision['name']) && $hasProperty) { ?>
	<li>
		<a id="divisionSelector" href="<?php echo URL; ?>division/switch/<?php echo session('division'); ?>?rf=<?php echo $G->url->getUrl(); ?>">
			<?php echo $currentDivision['name']; ?>
		</a>
	</li>
<?php
	}
}
if (count($departmentList) > 0 && $hasProperty) { ?>
	<li class="dropdown">
		<a id="departmentSelector" class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="<?php echo URL; ?>department/switch/<?php echo session('department'); ?>?rf=<?php echo $G->url->getUrl(); ?>">
			<?php echo $currentDepartment['name']; ?> <span class="caret"></span>
		</a>
		<ul class="dropdown-menu" role="menu" aria-labelledby="departmentSelector">
			<?php
			foreach ($departmentList as $id => $department) {
				echo "<li><a href=\"".URL."department/switch/$id?rf=".$G->url->getUrl()."\">{$department['name']}</a></li>";
			}
			?>
		</ul>
	</li>
<?php } else {
	if (isset($currentDepartment['name']) && $hasProperty) { ?>
	<li>
		<a id="departmentSelector" href="<?php echo URL; ?>department/switch/<?php echo session('department'); ?>?rf=<?php echo $G->url->getUrl(); ?>">
			<?php echo $currentDepartment['name']; ?>
		</a>
	</li>
<?php
	}
} ?>
</ol>
