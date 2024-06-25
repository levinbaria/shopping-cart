<?php

$servername = '172.104.166.158';
$username   = 'training_levinb';
$password   = 'sTW0eq8PhkLac0fG';
$dbname     = 'training_levinb';

// $servername = 'localhost';
// $username   = 'root';b  
// $password   = '';
// $dbname     = 'shopping-cart';

$connect = mysqli_connect( $servername, $username, $password, $dbname );

if ( ! $connect ) {
	die( 'Connection error in database' . mysqli_connect_error() );
}

// $sql = 'CREATE DATABASE `shopping-cart`';
// $result = mysqli_query($connect, $sql);
// if(!$result){
// echo mysqli_error($connect);
// }else {
// echo 'Database Created';
// }

// $sql = 'CREATE TABLE customer (
// ID int(10) NOT NULL AUTO_INCREMENT,
// cname varchar(30) NOT NULL,
// cemail varchar(50) NOT NULL,
// cpassword varchar(255) NOT NULL,
// r_time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
// PRIMARY KEY(ID)
// )';
// $result = mysqli_query($connect, $sql);
// if(!$result){
// echo mysqli_error($connect);
// }else {
// echo 'Table Created';
// }
