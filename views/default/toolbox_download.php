<?php defined('SYSTEM_PATH') OR die(_('No direct access to this file is allowed.'));?>
<?php
$file = $template['path'];
$path = str_replace_once(UPLOAD_URL, '', $template['path']);
if (file_exists(UPLOAD_PATH.$path)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.$path);
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize(UPLOAD_PATH.$path));
    ob_clean();
    flush();
    readfile(UPLOAD_PATH.$path);
    exit;
} else {
	pr('File Not Found');	
}
?>