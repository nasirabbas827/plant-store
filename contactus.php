<?php
include 'config.php';
$message = "";

if (isset($_POST['submit'])) 
{
   
            $name = $_POST['name'];
            $email = $_POST['email'];
            $message = $_POST['message'];
            $msgdate = date("y-m-d");

 $query="INSERT INTO `query_table`( `customer`, `message`, `email`, `msg_date`) VALUES ('$name','$message','$email','$msgdate')";
$insert = mysqli_query($con, $query);



            $message = "Your message has been sent successfully";
}
?>



<?php
include("header.php");?>

<!-- custom css file link  -->
<link rel="stylesheet" href="css/style.css" type="text/css">

<main>
        
<!-- Wrapper container -->
<div class="container py-4">

 

  <!-- Bootstrap 5 starter form -->
  <form  action="" method="post" data-sb-form-api-token="API_TOKEN" >

  <h3  style="text-align:center; font-weight:bold;" >Contact Us</h3>

    <!-- Name input -->
    <div class="mb-3">
      <label class="form-label" for="name">Name</label>
      <input class="form-control" id="name" type="text" placeholder="Name" data-sb-validations="required" />
      <div class="invalid-feedback" data-sb-feedback="name:required">Name is required.</div>
    </div>

    <!-- Email address input -->
    <div class="mb-3">
      <label class="form-label" for="email">Email Address</label>
      <input class="form-control" id="email" type="email" placeholder="Email Address" data-sb-validations="required, email" />
      <div class="invalid-feedback" data-sb-feedback="emailAddress:required">Email Address is required.</div>
      <div class="invalid-feedback" data-sb-feedback="emailAddress:email">Email Address Email is not valid.</div>
    </div>

    <!-- Message input -->
    <div class="mb-3">
      <label class="form-label" for="message">Message</label>
      <textarea class="form-control" id="message" type="text" placeholder="Message" style="height: 10rem;" data-sb-validations="required"></textarea>
      <div class="invalid-feedback" data-sb-feedback="message:required">Message is required.</div>
    </div>

    <!-- Form submissions success message -->
    <div class="d-none" id="submitSuccessMessage">
      <div class="text-center mb-3">Form submission successful!</div>
    </div>

    <!-- Form submissions error message -->
    <div class="d-none" id="submitErrorMessage">
      <div class="text-center text-danger mb-3">Error sending message!</div>
    </div>

    <!-- Form submit button -->
    <div class="d-grid">
      <button class="btn btn-primary btn-lg disabled" id="submit"  type="submit">Submit</button>
    </div>

  </form>

</div>

<!-- SB Forms JS -->
<script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>







</main>

    <?php
        echo $message;
                        ?>


</body>
</html>