<?php

//DBB connect
$dbhost = 'localhost';
$dbname = 'popote';
$dbuser = 'root';
$dbpassword = 'root';

$dbh = new PDO(
    'mysql:host='. $dbhost .';dbname='. $dbname,
    $dbuser,
    $dbpassword
);

?>