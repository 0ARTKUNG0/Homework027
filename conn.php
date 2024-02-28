<?php
$sName = 'localhost';
$uName = 'root';
$uPass = '';
$db = 'teststeamna';

try {
  $conn = new PDO(
    "mysql:host=$sName;dbname=$db;charset=UTF8",
    $uName,
    $uPass
  );

  echo "You are now connecting database!!";
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Sorry! You cannot connect to database";
}
