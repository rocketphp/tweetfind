<?php 
error_reporting(E_ERROR | E_WARNING | E_PARSE);
// $env = getenv('APPLICATION_ENV');
// error_reporting(E_ALL);
ini_set('display_errors', 'On'); 
ini_set('xdebug.var_display_max_depth', 15);
ini_set('xdebug.var_display_max_children', 256);
ini_set('xdebug.var_display_max_data', 1024);
set_time_limit(60 * 5); 
$autoload = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
require $autoload; 

use TweetFind\TweetFind;

/** 
 * TweetFind
 */
$app = new TweetFind();
$result = $app->startRestService();
echo $app->view('index');
