<?php
// index.php - Punto de entrada único del sistema
session_start(); // MUY IMPORTANTE
require_once __DIR__ . '/routers/web.php';
?>