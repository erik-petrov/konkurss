<?php
$salt = "amogus";
$serverName = "localhost";
$username = "erikpetrov";
$password = "123456789";
$DBName = "erikpetrov";
$conn = new mysqli($serverName, $username, $password, $DBName);
$conn->set_charset('UTF8');
/*
   create table konkurss(
    konkurssID int PRIMARY KEY AUTO_INCREMENT,
    nimi varchar(20),
    pilt text,
    lisamisaeg timestamp,
    punktid int default 0,
    kommentaar text default '',
    avalik tinyint(1) default 1);
*/