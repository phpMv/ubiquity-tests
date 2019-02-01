<?php
use Classes\User;

include 'c3.php';
include 'Classes/User.php';
$user=new User();
$user->setPrenom("Robert");
$user->setNom("SMITH");
echo $user;