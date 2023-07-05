<?php
// Output comments to HTML

function rating_to_emoji($rating) {
  $emoji ='';
  if($rating == 1) { 
    $emoji = '😡';
  } elseif($rating == 2)  {
    $emoji = '☹️';
  } elseif($rating == 3)  {
    $emoji = '😐';
  } elseif($rating == 4)  {
    $emoji = '😊';
  } elseif($rating == 5)  {
    $emoji = '😃';
  }

  return $emoji;
}

function the_reviews() {
  global $reviews;
  $count = count($reviews);

  echo '<h2> Reviews </h2>';
  while($count !== 0){
    foreach($reviews as $data){
      echo '<div class="comment"><h3>Review by : ' . $data['name'] . '</h3>';
      echo '<div class="date">Posted on: ' . $data['date']. '</div>';
      echo '<div class="mood">Reaction: <span style="float:right; right:0;"> ' . rating_to_emoji($data['rating']) . ' </span></div>';
      echo '<div class="comment-text"> <p>' . $data['comment'] . '</p> </div> </div>';
      echo "<br>";
      $count = $count - 1;
    }
  }
}

function booking_details() {
  global $booking_details;
  global $confirmation_number;
  $count = count($booking_details);

  if($count == 0 && $confirmation_number != null) {
    echo 'Sorry, we could not find any details using the confirmation number provided.';
  } 
  elseif ($count > 0 && $confirmation_number != null) {
    foreach($booking_details as $data) {
      echo 'Dear '. $data['guest_name'] . '. The following are the details for you booking with us: <br /><br />';
      echo 'Email Contact: '. $data['guest_email'] . '<br />';
      echo 'Room Type: '. $data['name'] . '<br />';
      echo 'Check In Date: '. $data['date_start'] . '<br />';
      echo 'Check Out Date: '. $data['date_end'] . '<br />';
      echo 'Total Price : $'. $data['total_price'] . ' USD<br /><br />';

   

      echo '<form action="'. htmlspecialchars($_SERVER["REQUEST_URI"]) . '" method="post">';
      echo '<input type="hidden" name="booking_id" value="'. $data['ID'] .'" />';
      echo '<button type="submit" name="button">Cancel Booking</button>';
      echo '</form>';
    }
  }
}

function available_rooms() {
    global $avail_rooms;
    global $checkin_date;
    global $checkout_date;
    global $guest_name;
    global $guest_email;
    $count = count($avail_rooms);

    if($count == 0 && $checkin_date != null) {
        echo '<h4>Sorry, there are no rooms available for the selected dates. Please try another date.</h4>';
    }
    else if ($count > 0 && $checkin_date != null) {
        echo '<h4>Available Rooms for Check-In on '. $checkin_date .' and Check-Out on '. $checkout_date .': </h4>';
        foreach($avail_rooms as $data){
            $start_date = strtotime($checkin_date);
            $end_date = strtotime($checkout_date);
            $datediff = $end_date - $start_date;
            
            $nights = round($datediff / (60 * 60 * 24));
            $total_cost = $nights * $data["price"];

            echo '<h3><a target="_blank" href="'. $data["permalink"] . '">' . $data["name"] .'</a></h3>';
            echo 'Total Price for '. $nights . ' night(s):  <b> $' . $total_cost . " </b><span style='text-decoration: line-through'>". ($total_cost * 1.3)  .'</span> USD';
            echo '<form action="'. htmlspecialchars($_SERVER["REQUEST_URI"]) . '" method="post">';
            echo '<input type="hidden" name="room_id" value="'. $data['ID'] .'" />';
            echo '<input type="hidden" name="guest_name" value ="'. $guest_name .'" />';
            echo '<input type="hidden" name="guest_email" value ="'. $guest_email .'" />';
            echo '<input type="hidden" name="total_price" value ="'. $total_cost .'" />';
            echo '<input type="hidden" name="date_start" value ="'. $start_date .'" />';
            echo '<input type="hidden" name="date_end" value ="'. $end_date .'" />';
            echo '<button type="submit" name="button">Book</button>';
            $count = $count - 1;
            echo '</form>';
        }
    }
}
