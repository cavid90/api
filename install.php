<?php
include_once 'autoload.php';

$raw_sql = file_get_contents('database/orders.sql');

$query = $db->getConnection()->exec($raw_sql);
if($db->getConnection()->errorCode() == 00000) {
    echo 'Tables has been created';
} else {
    echo 'Mysql error code: '.$db->getConnection()->errorCode();
    echo 'Unable to create database tables';
}


