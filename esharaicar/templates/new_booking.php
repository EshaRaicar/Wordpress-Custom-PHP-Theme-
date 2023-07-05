<script>
 
    $(function() {
      $.validator.addMethod("greaterThan", 
        function(value, element, params) {
            if (!/Invalid|NaN/.test(new Date(value))) {
                return new Date(value) > new Date($(params).val());
            }

            return isNaN(value) && isNaN($(params).val()) 
                || (Number(value) > Number($(params).val())); 
        },'Must be greater than {0}.');

      $("#booking_form").validate({
          rules: {
              // TODO: add rules for validation here 
              // The key name on the left side is the name attribute
              // of an input field. Validation rules are defined
              // on the right side
              guest_name: {
                required : true
              },
              guest_email :{
                required : true,
                email :true
              },
              checkin_date: {
                required : true,
              },
              checkout_date: {
                required : true,
                greaterThan: "#checkin_date"
              }           
         },
      
        // These are the validation error messages that will display 
        messages: {
          guest_name: {
              required: "Please provide your full name"
          },
          guest_email: {
            required: "Please provide an email",
            email: "Please enter a valid email address"
          },
          checkin_date: {
            required: "Check In date is required"
          },
          checkout_date: {
            required: "Check Out date is required",
            greaterThan: "Check Out date must be greater than Check In date"
          }
        },
      
     
        // This is the function that submits the form if there are no errors 
        submitHandler: function(form) {
          // alert("test");
            form.submit();
          }
        });
    });
</script>

<div class="new-booking">
      <h2>Create a New Booking</h2>

      <?php
        if($error_msg != '') {
          echo '<div class="server_errors">';
          echo "<span>Errors:</span><br />";
          echo '<ul>';
          echo $error_msg;
          echo '</ul>';
          echo '</div>';
        }
      ?>

      <form id="booking_form" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']);?>" method="post">

        <label>
          Guest Name:
          <input type="text" name="guest_name">
        </label>

        <label>
          Email Address:
          <input type="email" name="guest_email">
        </label>

        <label>
          Check In Date:                        
          <input type="date" onkeydown="return false" id="checkin_date" name="checkin_date" min="<?= date('Y-m-d', strtotime('-1 days')) ?>" />
        </label>

        <label>
          Check Out Date:                        
          <input type="date" onkeydown="return false" id="checkout_date" name="checkout_date" min="<?= date('Y-m-d') ?>" />
        </label>

        <button type="submit" name="button">Show Available Rooms</button>

      </form>

      <?php
        if ($confirmation_number != null) {
          echo "<h4>Congratulations! Your booking is confirmed</h4>";
          echo "You're confirmation number is: " . $confirmation_number;
        }
        available_rooms();
      ?>
</div>