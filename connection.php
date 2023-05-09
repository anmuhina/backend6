<?php
$user = 'u52811';
     $pass = '8150350';
     $db = new PDO('mysql:host=localhost;dbname=u52811', $user, $pass,
       [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); 
?>
