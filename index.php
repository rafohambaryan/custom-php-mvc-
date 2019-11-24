<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once(__DIR__ . '/app/init.php');
require_once(__DIR__ . '/route/Route.php');
use route\Route;

new Route();