<?php
$uri = trim($_SERVER['REQUEST_URI'], '/');#.phpを省略するコードです。

$phpFile = $uri . '.php';

if (file_exists($phpFile)) {
    include $phpFile;
} else {
    header("HTTP/1.0 404 Not Found");
    echo "404 Not Found";
}
$request_uri = $_SERVER['REQUEST_URI'];#ここから下はディレクトリを省略するコードです。

$request_uri = strtok($request_uri, '?');

$base_dir = __DIR__;

$requested_file = $base_dir . $request_uri;

if (file_exists($requested_file) && is_file($requested_file)) {
    
    include($requested_file);
} else {
    header("HTTP/1.0 404 Not Found");
    echo "404 Not Found";
    exit();
}
?>

