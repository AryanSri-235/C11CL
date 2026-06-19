<?php

$env = parse_ini_file(__DIR__ . '/.env');

$DB_HOST = $env['DB_HOST'];
$DB_PORT = $env['DB_PORT'];
$DB_NAME = $env['DB_NAME'];
$DB_USER = $env['DB_USER'];
$DB_PASS = $env['DB_PASS'];