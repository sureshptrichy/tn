<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));
if ($G->url->ajax) {
echo json_encode($departments, JSON_FORCE_OBJECT|JSON_NUMERIC_CHECK);
}
