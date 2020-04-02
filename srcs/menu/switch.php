<?php

$state = intval($_GET['autoindex']);
$dest = '/etc/nginx/sites-available/default';
if ($state == 1) {
	$src = '/autoindex/default-autoon';
	if (!copy($src, $dest)) {
		print_r(error_get_last());
	}
} else {
	$src = '/autoindex/default-autooff';
	if (!copy($src, $dest)) {
		print_r(error_get_last());
	}
}
echo shell_exec("sudo service nginx reload");
header("Location: index.php?start=$state");
