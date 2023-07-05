<?php
/**
 * Template Name: Reviews Template
 */
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    get_header();
        
    // array of reviews, fetched from database
    $reviews = [];
    $error_msg = '';
    
    require_once 'database/database.php';
    require_once 'templates/functions/template_functions.php';
    
    //connect to database: PHP Data object representing Database connection
    $pdo = db_connect();
    
    // submit review to database
    submit_review();
    
    // get reviews from database
    get_reviews();
    
    // include the template to display the page
    include 'templates/reviews.php';

    get_footer();
?>