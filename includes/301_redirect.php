<?php
// current address
$oldurl = strtolower($_SERVER['REQUEST_URI']);
// new redirect address
$newurl = '';
// old to new URL map (for you to configure)
$redir = array(
	'/old/' => '/new/page/',
);
while ((list($old, $new) = each($redir)) && !$newurl) {
	if (strpos($oldurl, $old) !== false) $newurl = $new;
}
// redirect
if ($newurl != '') {
	header('HTTP/1.1 301 Moved Permanently');
	header("Location: $newurl");
	exit();
}
?>
