<?php

function isValidEmail($email){
  if(filter_var($email, FILTER_VALIDATE_EMAIL) == true){
    return true;
  }else{
    return false;
  }
}

// Should return a PDO
function db_connect() {

  try {
    // TODO
    // try to open database connection using constants set in config.php
    // // return $pdo;
    $connectionString = "mysql:host=localhost; dbname=rioisland";
    $user = "root";
    $pass = '';
 
    $pdo = new PDO($connectionString,  $user, $pass);
    $pdo ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
  }
  catch (PDOException $e){
    die($e->getMessage());
  }
}

function submit_review() {
  global $pdo;
  global $error_msg;
  $valid = true;

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['personname']) && isset($_POST['rating']) && isset($_POST['comment'])){

      if(trim($_POST['personname']) == '') {
        $valid = false;
        $error_msg =  $error_msg . '<li>Full Name is required</li>';
      }

      if($_POST['rating'] == 0) {
        $valid = false;
        $error_msg =  $error_msg . '<li>Rating is required</li>';
      }

      if(trim($_POST['comment']) == '') {
        $valid = false;
        $error_msg =  $error_msg . '<li>Comment is required</li>';
      }

      if($valid == true) {
        $sql = 'INSERT INTO reviews(date,name, rating, comment)
        VALUES (:date, :name, :rating, :comment)';
        $date = date('Y-m-d');
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':date', $date);
        $statement->bindValue(':name', $_POST['personname']);
        $statement->bindValue(':rating', $_POST['rating']);
        $statement->bindValue(':comment', $_POST['comment']);
        $statement->execute();
      }
    }
  }
}


// Get all reviews from database and store in $reviews
function get_reviews() {
  global $pdo;
  global $reviews;

  $sql = "SELECT * FROM reviews ORDER BY ID DESC";
  $result = $pdo->query($sql);

  while($row = $result->fetch()){ 
    $reviews[] = $row;
  }
}

function search_available_rooms() {
  global $pdo;
  global $avail_rooms;
  global $checkin_date;
  global $checkout_date;
  global $guest_name;
  global $guest_email;
  global $error_msg;
  $valid = true;

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['checkin_date']) && isset($_POST['checkout_date']) && isset($_POST['guest_name']) && isset($_POST['guest_email'])){

      if(trim($_POST['guest_name']) == '') {
        $valid = false;
        $error_msg =  $error_msg . '<li>Guest Full Name is required</li>';
      }

      if(trim($_POST['guest_email']) == '') {
        $valid = false;
        $error_msg =  $error_msg . '<li>Guest Email is required</li>';
      }

      if(trim($_POST['guest_email']) != '' && !isValidEmail(trim($_POST['guest_email']))) {
        $valid = false;
        $error_msg =  $error_msg . '<li>Guest Email is invalid</li>';
      }

      if(trim($_POST['checkin_date']) == '') {
        $valid = false;
        $error_msg =  $error_msg . '<li>Check In Date is required</li>';
      }

      if(trim($_POST['checkout_date']) == '') {
        $valid = false;
        $error_msg =  $error_msg . '<li>Check Out Date is required</li>';
      }

      if(trim($_POST['checkin_date']) != '' && trim($_POST['checkout_date']) != '' && (trim($_POST['checkout_date'] <= trim($_POST['checkin_date'])))) {
        $valid = false;
        $error_msg =  $error_msg . '<li>Check Out Date must be greated than Check In Date</li>';      
      }

      if ($valid == true) {
        $date_query_arr = array();

        $strt_day = new DateTime($_POST['checkin_date']);
        $end_day = new DateTime($_POST['checkout_date']);
        $end_day = $end_day->modify( '+1 day' );
  
        $period = new DatePeriod(
          $strt_day,
          new DateInterval('P1D'),
          $end_day
        );
  
        foreach ($period as $key => $value) {
          $tmp_expression = "SELECT room_ID FROM bookings WHERE '". $value->format('Y-m-d') ."' BETWEEN date_start and date_end and is_cancelled = 0";
          array_push($date_query_arr, $tmp_expression);     
        }
  
        $date_query = implode(" union ", $date_query_arr);
  
        $sql = "SELECT * FROM rooms WHERE ID NOT IN (". $date_query .") ORDER BY price";
  
        $result = $pdo->query($sql);
      
        while($row = $result->fetch()){ 
          $avail_rooms[] = $row;
        }
  
        $checkin_date = $_POST['checkin_date'];
        $checkout_date = $_POST['checkout_date'];
        $guest_name = $_POST['guest_name'];
        $guest_email = $_POST['guest_email'];
      }

    }
  }
}

function create_new_booking() {
  global $pdo;
  global $confirmation_number;

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['room_id']) && isset($_POST['guest_name']) && isset($_POST['guest_email']) && isset($_POST['total_price']) && isset($_POST['date_start']) && isset($_POST['date_end'])){
      $sql = 'INSERT INTO bookings(guest_name, guest_email, total_price, date_start, date_end, room_ID)
      VALUES (:guest_name, :guest_email, :total_price, :date_start, :date_end, :room_ID)';
      $statement = $pdo->prepare($sql);
      $statement->bindValue(':guest_name', $_POST['guest_name']);
      $statement->bindValue(':guest_email', $_POST['guest_email']);
      $statement->bindValue(':total_price', $_POST['total_price']);
      $statement->bindValue(':date_start', date('Y-m-d',$_POST['date_start']));
      $statement->bindValue(':date_end', date('Y-m-d',$_POST['date_end']));
      $statement->bindValue(':room_ID', $_POST['room_id']);
      $statement->execute();
      $confirmation_number = $pdo->lastInsertId();
      $confirmation_number = "RIO#" . str_pad($confirmation_number,10,"0",STR_PAD_LEFT);
    }
  }
}

function search_booking_details() {
  global $pdo;
  global $booking_details;
  global $confirmation_number;
  global $error_msg;
  $valid = true;

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['confirmation_number'])) {

      if(trim($_POST['confirmation_number']) == '') {
        $valid = false;
        $error_msg =  $error_msg . '<li>Confirmation Number is required</li>';
      }

      if($valid == true) {
        $parsed_confirmation_number = explode("#",$_POST['confirmation_number']);
        $parsed_confirmation_number = ltrim($parsed_confirmation_number[1], "0");
      
        $sql = "SELECT guest_name, guest_email, `name`, date_start, date_end, total_price, bookings.ID as ID FROM bookings inner join rooms on bookings.room_ID = rooms.ID WHERE is_cancelled = 0 and bookings.ID = " . $parsed_confirmation_number;
        $result = $pdo->query($sql);
      
        while($row = $result->fetch()){ 
          $booking_details[] = $row;
        }
  
        $confirmation_number = $_POST['confirmation_number'];
      }
    }
  }
}

function cancel_booking() {
  global $pdo;
  global $cancelled;

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['booking_id'])) {
      $sql = 'UPDATE bookings SET is_cancelled = 1 WHERE ID = :booking_id';
      $statement = $pdo->prepare($sql);
      $statement->bindParam(':booking_id', $_POST['booking_id']);
      $statement->execute();

      $cancelled = true;
    }
  }
}

function submit_contact() {
  global $pdo;
  global $contact_id;
  global $error_msg;
  $valid = true;

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['personname']) && isset($_POST['personemail']) && isset($_POST['comment'])){

      if(trim($_POST['personname']) == '') {
        $valid = false;
        $error_msg =  $error_msg . '<li>Full Name is required</li>';
      }

      if(trim($_POST['personemail']) == '') {
        $valid = false;
        $error_msg =  $error_msg . '<li>Email Address is required</li>';
      }

      if(trim($_POST['personemail']) != '' && !isValidEmail(trim($_POST['personemail']))) {
        $valid = false;
        $error_msg =  $error_msg . '<li>Email address is invalid</li>';
      }

      if(trim($_POST['comment']) == '') {
        $valid = false;
        $error_msg =  $error_msg . '<li>Question/Feedback is required</li>';
      }

      if($valid == true) {
        $sql = 'INSERT INTO contact(date_submitted,`name`, email, comment)
        VALUES (:date_submitted, :name, :email, :comment)';
        $date = date('Y-m-d');
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':date_submitted', $date);
        $statement->bindValue(':name', $_POST['personname']);
        $statement->bindValue(':email', $_POST['personemail']);
        $statement->bindValue(':comment', $_POST['comment']);
        $statement->execute();
        $contact_id = $pdo->lastInsertId();
      }
    }
  }
}
