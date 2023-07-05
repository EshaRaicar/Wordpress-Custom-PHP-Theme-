<?php
/**
 * Template Name: New Booking Template
 */
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    get_header();

    $avail_rooms = [];
    $checkin_date = null;
    $checkout_date = null;
    $guest_name = null;
    $guest_email = null;
    $confirmation_number = null;
    $error_msg = '';
        
    require_once 'database/database.php';
    require_once 'templates/functions/template_functions.php';
    
    //connect to database: PHP Data object representing Database connection
    $pdo = db_connect();
    
    search_available_rooms();

    create_new_booking();

    // include the template to display the page
    include 'templates/new_booking.php';

    get_footer();
?>