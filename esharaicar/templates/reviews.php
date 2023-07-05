<script>
 
    $(function() {
        $("form").validate({
          errorElement: 'span',
          rules: {
              // TODO: add rules for validation here 
              // The key name on the left side is the name attribute
              // of an input field. Validation rules are defined
              // on the right side
              personname: {
                required : true
              },
              rating :{
                required : true
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
            rating: {
              required: "Please provide a rating"
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


<div class="write-review">
      <h2>Post a Review</h2>

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

      <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']);?>" method="post">
        <label>
          Name:
          <input type="text" name="personname">
        </label>

        <label>
          Reaction:
          <select name="rating">
            <option value="">-- Select --</option>
            <option value="1">Very Bad</option>
            <option value="2">Poor</option>
            <option value="3">Satisfactory</option>
            <option value="4">Good</option>
            <option value="5">Excellent</option>
          </select>
        </label>

        <label>
          Enter a Comment:
          <textarea name="comment"></textarea>
        </label>

        <button type="submit" name="button">Post Review</button>

      </form>
</div>
<?php
      the_reviews();
?>