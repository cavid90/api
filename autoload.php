<?php
/**
 * Created by PhpStorm.
 * User: kcavi
 * Date: 16.09.2018
 * Time: 21:47
 */

define('BASE_PATH', realpath(__DIR__.''));

#-----------------------------------
# Autoload classes
#----------------------------------
if (file_exists(BASE_PATH.'/vendor/autoload.php')) {
    require_once BASE_PATH.'/vendor/autoload.php';
} else {
    echo "<h1>Please install via composer.json</h1>";
    echo "<p>Install Composer instructions: <a href='https://getcomposer.org/doc/00-intro.md#globally'>https://getcomposer.org/doc/00-intro.md#globally</a></p>";
    echo "<p>Once composer is installed navigate to the working directory in your terminal/command promt and enter 'composer install'</p>";
    exit;
}

$db = \Classes\Db::getInstance();