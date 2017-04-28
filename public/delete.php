<?php
// Package was hit directly (ie. request to /id/version). Currently we only
// expect these to be DELETE requests.

require(__DIR__ . '/../inc/core.php');

if (request_method() !== 'DELETE') {
	api_error('405', 'Only DELETEs allowed here');
}

require_auth();

# When rewrite base is the root path (/), /api/v2/package is prefixed in Apache.
# TODO: Handle this in .htaccess rewrite rules.
//$package = preg_replace('{/api/v2/package}', '', $_SERVER['REQUEST_URI'], 1);

//$package = preg_replace('{' . $_SERVER['REWRITE_BASE'] . '}', '', $package, 1);
//list($id, $version) = explode('/', $package);

$id = $_GET['id'];
$version = $_GET['version'];

$path = get_package_path($id, $version);

if (file_exists($path)) {
	unlink($path);
}

DB::deleteVersion($id, $version);
