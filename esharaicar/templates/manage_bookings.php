<script>
 
    $(function() {
        $("#manage_form").validate({

          rules: {
              // TODO: add rules for validation here 
              // The key name on the left side is the name attribute
              // of an input field. Validation rules are defined
              // on the right side
              confirmation_number: {
                required : true
              }
         },
      
        // These are the validation error messages that will display 
        messages: {
          confirmation_number: {
              required: "Confirmation number is required"
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
      <h2>Manage Your Bookings</h2>

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

      <form id="manage_form" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']);?>" method="post">

        <label>
          Confirmation Number:
          <input type="text" name="confirmation_number">
        </label>

        <button type="submit" name="button">View Booking Details</button>

      </form>

      <?php
        if ($cancelled) {
            echo "<h4>Your booking was cancelled successfully!</h4>";
        }
        booking_details();
      ?>
</div>