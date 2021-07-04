<?php

$authTableData = [
    'table' => 'users',
    'idfield' => 'login',
    'cfield' => 'mdp',
    'uidfield' => 'uid',
    'rfield' => 'role',
];

$pathFor = [
    "login"  => "login.php",
    "logout" => "logout.php",
    "adduser" => "adduser.php",
    "root"   => "index.php",
];

const SKEY = '_Redirect';