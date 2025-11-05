<?php
session_start();

function isAdmin()
{
    return isset($_SESSION['users']['role']) && $_SESSION['users']['role'] === 'admin';
}

function isUser()
{
    return isset($_SESSION['users']['role']) && $_SESSION['users']['role'] === 'user';
}
