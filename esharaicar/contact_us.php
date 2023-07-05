<?php
/**
 * Template Name: Contact Us Template
 */
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    get_header();

    $contact_id = null;
    $error_msg = '';
        
    require_once 'database/database.php';
    require_once 'templates/functions/template_functions.php';

    //connect to database: PHP Data object representing Database connection
    $pdo = db_connect();

    submit_contact();

    // include the template to display the page
    include 'templates/contact_us.php';

    get_footer();
?>