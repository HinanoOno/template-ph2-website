<?php
function getDb():PDO{
  $dsn = 'mysql:dbname=posse;host=db';
  $user = 'root';
  $password = 'root';

  $db = new PDO($dsn, $user, $password);

  return $db;

}




?>