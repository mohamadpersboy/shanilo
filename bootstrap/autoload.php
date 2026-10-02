<?php

define('LARAVEL_START', microtime(true));
ini_set('memory_limit', "2048M");
ini_set('upload_max_filesize', "100M");
ini_set('post_max_size', "100M");

/*
|--------------------------------------------------------------------------
| Register The Composer Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader
| for our application. We just need to utilize it! We'll require it
| into the script here so that we do not have to worry about the
| loading of any our classes "manually". Feels great to relax.
|
*/

require __DIR__.'/../vendor/autoload.php';
