<?php
/**
 * Authentication Check - Include this at the top of all protected pages
 * Redirects to login if user is not authenticated
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../src/Auth.php';

if (!Auth::check()) {
    header("Location: login.php");
    exit;
}
