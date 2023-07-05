<?php
/**
 * Template Name: Manage Bookings Template
 */
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    get_header();

    $booking_details = [];
    $error_msg = '';
    $cancelled = null;
        
    require_once 'database/database.php';
    require_once 'templates/functions/template_functions.php';
    
    //connect to database: PHP Data object representing Database connection
    $pdo = db_connect();

    search_booking_details();

    cancel_booking();

    // include the template to display the page
    include 'templates/manage_bookings.php'; 

    get_footer();
?>