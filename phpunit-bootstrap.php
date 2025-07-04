<?php

// Load Composer autoloader
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__, ['.env.test', '.env']);
$dotenv->safeLoad();
