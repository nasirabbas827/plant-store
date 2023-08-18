<?php include 'config.php';
// Get image data from database 
$result = $con->query("SELECT * FROM `plant_table` WHERE `category`='Summer Plants' or `category`='Winter Plants' or `category`='Indoor Plants' or `category`='Outdoor Plants'");
if(isset($_POST['done']))
{
    header('Location:http://localhost/rmPlantStore/login.php');
}
?>

<?php
include("header.php");?>
<section >
    <h2 style="text-align:center; font-weight:bold; margin-top:20px;">Plant List</h2>

  <?php  if ($result->num_rows > 0) 
  {
     while ($row = $result->fetch_assoc())
    {
    ?>


<div class="card">
<img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['photo']); ?>" width=100% />
<h3><?php echo $row['title'] ?></h3>
  <p class="price"><?php echo $row['sale'] ?></p>
 <p> <h4><?php echo $row['description'] ?></h4></p>
  <p><button name="done">Buy Now</button></p>
</div>


<?php
      }
    }
                        ?>

<!-- custom css file link  -->
<link rel="stylesheet" href="css/style.css" type="text/css">



</div>

</div>
</section>


<body>
<form action="plants.php" method="Post">
 <div class="container">
    <div class="row">

        <div class="col-md-3">
          <div class="card">
            <img class="img-fluid" alt="100%x280" src="https://images.unsplash.com/photo-1570295835271-04c05b4ed943?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80">
              <div class="card-body">
                <h4 class="card-title"style="color:green;">AloeVera Plant</h4>
                  <p class="card-text" style="color:black;">With supporting text below as a natural lead-in to additional content.</p>
                  <div class=""><div  class="buttons d-flex flex-row"> <div class="cart"><i class=""></i></div> <button name="done" class="btn btn-success cart-button px-5"><span class="dot"></span>Add to cart </button> </div> </div>
              </div>
          </div>
        </div>

                                <div class="col-md-3">
                                    <div class="card">
                                        <img class="img-fluid" alt="100%x280" src="https://images.unsplash.com/photo-1530307498023-e8fa285c07b5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80">
                                        <div class="card-body">
                                            <h4 class="card-title" style="color:green;">Indoor Plant</h4>
                                            <p class="card-text" style="color:black;">With supporting text below as a natural lead-in to additional content.</p>
                                            <div class=""><div class="buttons d-flex flex-row"> <div class="cart"><i class=""></i></div><button name="done" class="btn btn-success cart-button px-5" > <span class="dot"></span>Add to cart</button> </div> </div>
                                        </div>
                                    </div>
                                </div>
      
                                <div class="col-md-3">
                                    <div class="card">
                                        <img class="img-fluid" alt="100%x280" src="https://images.unsplash.com/photo-1541854835593-8795b2d1b228?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80">
                                        <div class="card-body">
                                            <h4 class="card-title" style="color:green;" >Green Snake Plant</h4>
                                            <p class="card-text" style="color:black;" >With supporting text below as a natural lead-in to additional content.</p>
                                            <div class=""><div class="buttons d-flex flex-row"> <div class="cart"><i class=""></i></div> <button class="btn btn-success cart-button px-5"> <span class="dot"></span>Add to cart</button> </div> </div>
                                        </div>  
                                    </div>
                                </div>
                                        
                                      
                                <div class="col-md-3">
                                    <div class="card">
                                        <img class="img-fluid" alt="100%x280" src="https://images.unsplash.com/photo-1494789540273-617a5015d44b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80">
                                        <div class="card-body">
                                            <h4 class="card-title" style="color:green;" >Potted Plant</h4>
                                            <p class="card-text" style="color:black;" >With supporting text below as a natural lead-in to additional content.</p>
                                            <div class=""><div class="buttons d-flex flex-row"> <div class="cart"><i class=""></i></div> <button id="done" class="btn btn-success cart-button px-5"> <span class="dot"></span>Add to cart</button> </div> </div>
                                        </div>
                                    </div>
                                </div>     

                                <div class="col-md-3">
                                    <div class="card">
                                        <img class="img-fluid" alt="100%x280" src="https://images.unsplash.com/photo-1494789540273-617a5015d44b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80">
                                        <div class="card-body">
                                            <h4 class="card-title" style="color:green;" >Greenish Plant</h4>
                                            <p class="card-text" style="color:black;" >With supporting text below as a natural lead-in to additional content.</p>
                                            <div class=""><div class="buttons d-flex flex-row"> <div class="cart"><i class=""></i></div> <button id="done" class="btn btn-success cart-button px-5"> <span class="dot"></span>Add to cart</button> </div> </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="card">
                                        <img class="img-fluid" alt="100%x280" src="https://images.unsplash.com/photo-1526262779955-2cc2306057c7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=862&q=80">
                                        <div class="card-body">
                                            <h4 class="card-title" style="color:green;" >Edge Hill</h4>
                                            <p class="card-text" style="color:black;" >With supporting text below as a natural lead-in to additional content.</p>
                                            <div class=""><div class="buttons d-flex flex-row"> <div class="cart"><i class=""></i></div> <button id="done" class="btn btn-success cart-button px-5"> <span class="dot"></span>Add to cart</button> </div> </div>
                                        </div>
                                    </div>
                                </div>
                                        
        

                        
    </div>
  </div>
</form>


<div
         class="text-center p-3"
         style="background-color: #386ddb";>
      
      <a class="text-white" href=""
         > © 2023 Copyright: Made By Rimsha Khan</a
        >
    </div>

</body>
</html>





   
