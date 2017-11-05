<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.')); ?>
<div class="list-group side-bar-nav" role="navigation">
	<?php
	foreach ($menu as $url => $route) {
		$active = NULL;
		if ($G->url->isCurrent($url)) {
			$active = 'active';
		}
		echo "<a href=\"".URL."$url\" class=\"list-group-item $active\">{$route['name']}</a>";
	}
	?>
</div>
