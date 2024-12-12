<?php
$currentUrl = $_SERVER['REQUEST_URI'];
if (strpos($currentUrl, '/login') !== false) {
    header("Location: /");
    exit();
}
?>