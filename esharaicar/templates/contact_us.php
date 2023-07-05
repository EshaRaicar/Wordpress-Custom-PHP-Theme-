
<script>
 
    $(function() {
        $("#contactus").validate({

          rules: {
              // TODO: add rules for validation here 
              // The key name on the left side is the name attribute
              // of an input field. Validation rules are defined
              // on the right side
              personname: {
                required : true
              },
              personemail :{
                required : true,
                email :true
              },
              comment: {
                required : true
              }
         },
      
        // These are the validation error messages that will display 
        messages: {
          personname: {
              required: "Please provide your full name"
            },
            personemail: {
              required: "Please provide an email",
              email: "Please enter a valid email address"
            },
            comment: {
              required: "Please provide a comment"
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

<div class="contact-us">
      <h2>Ask us some questions!</h2>

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

      <form id="contactus" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']);?>" method="post">

        <label>
          Full Name:
          <input type="text" name="personname">
        </label>

        <label>
          Email Address:
          <input type="email" name="personemail">
        </label>

        <label>
          Question/Feedback:                        
          <textarea name="comment"></textarea>
        </label>

        <button type="submit" name="button">Send</button>

      </form>

      <?php
        if ($contact_id != null) {
          echo "<h4>Congratulations! Your question/feedback has been sent successfully.</h4>";
        }
      ?>
</div>