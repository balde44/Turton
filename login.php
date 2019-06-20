<?php
   session_start();
   if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
include("config.php");
      
    // Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($db);
}
   
?>
<html>
<head>
<title>Turton Property</title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href=https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" ></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" ></script>

</head>
<body>

<!-------NAVIGATIVON BAR------->
<section id="nav-bar">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#"><img src="logo3.png"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="#">HOME</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#About">ABOUT US</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#services">SERVICES</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#team">OUR TEAM</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#price">PRICING</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#testimonials">TESTIMONIALS</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#contact">CONTACT</a>
      </li>
    </ul>
<!------------Login and sign up buttons for new pages ---------------->
<button type="button" class="btn btn-primary"><a href="access.php">Login In</a></button>
  </div>
</nav>
</section>

  <!---------SLIDER---------> 
  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block img-fluid" src="house.jpg">
      <div class="carousel-caption">
      <h5>TURTON PROPERTY</h5>
      </div>
    </div>
    <div class="carousel-item">
      <img class="d-block img-fluid" src="child.jpg">
      <div class="carousel-caption">
      <h5>RENT AN APARTMENT.</h5>
      </div>
    </div>
    <div class="carousel-item">
      <img class="d-block img-fluid" src="new.jpg">
      <div class="carousel-caption">
      <h5>FIND YOUR HOME.</h5>
      </div>
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
</div>
    <!-------About------------>
<section id="About">
<div class="container">
<div class="row">
<div class="col-md-6">
  <h2> About Us<h2>
  <div class="about-content">
  Provide great service to our customers is the main goal of the company. We will go to the full extent to make sure that you get into a home that will be the best place for You and your family. Just let us know. We are here to serve you and if you anything feel free to conact us at anytime.
</div>
   <button type="button" class="btn btn-primary">Read More</button>
</div>
<div class="col-md-6 skill-bar">
   <p>Communication Skills</p>
   <div class="Progress">
       <div class="Progress-bar" style="width: 80%;">80%</div>  
   </div>
   <p>Customer Service</p>
   <div class="Progress">
       <div class="Progress-bar" style="width: 100%;">100%</div>  
   </div>
   <p>Budget Management</p>
   <div class="Progress">
        <div class="Progress-bar" style="width: 92%;">92%</div>  
   </div>
   <p>Collection Management</p>
   <div class="Progress">
        <div class="Progress-bar" style="width: 87%;">87%</div>  
   </div>
</div>
</div>
</div>
</section>
   <!--------Service----------->
   <section id="services">
      <div class="container">
        <h1>Our Services</h1>
        <div class="row services">
          <div class="col-md-3 text-center">
           <div class="icon"> 
           <i class="fa fa-home"></i>
           </div>
           <h3>Property Maintenance</h3>
           <p>Anderson-Bailey Real Estate was founded in 2010 
             by Colleen Anderson and Vicki Bailey.</p>
          </div>
          <div class="col-md-3 text-center">
           <div class="icon"> 
           <i class="fa fa-money"></i>
           </div>
           <h3>Rent Collection</h3>
           <p>Anderson-Bailey Real Estate was founded in 2010 
             by Colleen Anderson and Vicki Bailey. We accept all 
            types of payements.</p>
          </div>
          <div class="col-md-3 text-center">
           <div class="icon"> 
           <i class="fa fa-line-chart"></i>
           </div>
           <h3>Evaluate Property</h3>
           <p>Anderson-Bailey Real Estate was founded in 2010 
             by Colleen Anderson and Vicki Bailey. Make sure 
            everything is clean and well.</p>
          </div>
          <div class="col-md-3 text-center">
           <div class="icon"> 
           <i class="fas fa-user-shield"></i>
           </div>
           <h3>Tenant Screening</h3>
           <p>Anderson-Bailey Real Estate was founded in 2010 
             by Colleen Anderson and Vicki Bailey. Make sure 
            everything is clean and well.</p>
          </div>
        </div>
    </div>
    </section>
    <!-----------Team Member---------->
    <section id="team">
      <div class="container">
        <h1>Our Team</h1> 
        <div class="row">
        <div class="col-md-3 profile-pic text-center">
          <div class="img-box">
            <img src="team1.jpg" class="img-responsive">
            <ul>
            <a href="#"><li><i class="fab fa-facebook-square"></i></li></a>
            <a href="#"><li><i class="fab fa-twitter-square"></i></li></a>
            <a href="#"><li><i class="fab fa-linkedin"></i></li></a>
          </ul>
          </div>
          <h2>Akshay Kumar</h2>
        <h3>Founder / CEO</h3>
        <p>Like this video and ask your questions in comment.</p>
          </div>
          <div class="col-md-3 profile-pic text-center">
          <div class="img-box">
            <img src="team2.jpg" class="img-responsive">
            <ul>
            <a href="#"><li><i class="fab fa-facebook-square"></i></li></a>
            <a href="#"><li><i class="fab fa-twitter-square"></i></li></a>
            <a href="#"><li><i class="fab fa-linkedin"></i></li></a>
          </ul>
          </div>
          <h2>Ranveer Singh</h2>
        <h3>Business head </h3>
        <p>Like this video and ask your questions in comment.</p>
          </div>
          <div class="col-md-3 profile-pic text-center">
          <div class="img-box">
            <img src="team3.jpg" class="img-responsive">
            <ul>
            <a href="#"><li><i class="fab fa-facebook-square"></i></li></a>
            <a href="#"><li><i class="fab fa-twitter-square"></i></li></a>
            <a href="#"><li><i class="fab fa-linkedin"></i></li></a>
          </ul>
          </div>
          <h2>Alia hhatt </h2>
        <h3>Marketing head</h3>
        <p>Like this video and ask your questions in comment.</p>
          </div>
          <div class="col-md-3 profile-pic text-center">
          <div class="img-box">
            <img src="team4.jpg" class="img-responsive">
            <ul>
            <a href="#"><li><i class="fab fa-facebook-square"></i></li></a>
            <a href="#"><li><i class="fab fa-twitter-square"></i></li></a>
            <a href="#"><li><i class="fab fa-linkedin"></i></li></a>
          </ul>
          </div>
          <h2>Arjun Kapur</h2>
        <h3>UI Desginer</h3>
        <p>Like this video and ask your questions in comment.</p>
          </div>
          </div>
</div>
</section>
<!-----------Promo-------------->
<section id="promo">
<div class="container">
  <p> Register Now And Get A Month Free Of Rent</p>
  <button type="button" class="btn btn-primary"><a href="register.php">Register Now</a></button>
</div>
</section>
<!------------Price plans/Apartments avialable---------->
<section id="price">
<div class="container">
    <h1>Price Plan</h1>
    <div class="row">
        <div class="col-md-3">
            <div class="single-price">
                <div class="price-head">
                    <h2>Free</h2>
                    <p>$0/<span>month</span></p>
                </div>
            <div class="price-content">
            <ul>
            <li><i class="fa fa-check-circle"></i>5GB Space</li>
            <li><i class="fa fa-check-circle"></i>10GB Bandwidth</li>
            <li><i class="fa fa-times-circle"></i>15 Email Account</li>
            <li><i class="fa fa-times-circle"></i>Unlimited Domain</li>
            <li><i class="fa fa-times-circle"></i>Unlimited Support</li>
            </ul>
            </div>
            <div class="price-button">
            <a class="buy-btn" href="#">Join Free</a>
            </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="single-price">
                <div class="price-head">
                    <h2>Start up</h2>
                    <p>$10/<span>month</span></p>
                </div>
            <div class="price-content">
            <ul>
            <li><i class="fa fa-check-circle"></i>10GB Space</li>
            <li><i class="fa fa-check-circle"></i>100GB Bandwidth</li>
            <li><i class="fa fa-check-circle"></i>15 Email Account</li>
            <li><i class="fa fa-times-circle"></i>Unlimited Domain</li>
            <li><i class="fa fa-times-circle"></i>Unlimited Support</li>
            </ul>
            </div>
            <div class="price-button">
            <a class="buy-btn" href="#">Buy Now</a>
            </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="single-price">
                <div class="price-head">
                    <h2>Business</h2>
                    <p>$50/<span>month</span></p>
                </div>
            <div class="price-content">
            <ul>
            <li><i class="fa fa-check-circle"></i>20GB Space</li>
            <li><i class="fa fa-check-circle"></i>200GB Bandwidth</li>
            <li><i class="fa fa-check-circle"></i>50 Email Account</li>
            <li><i class="fa fa-check-circle"></i>Unlimited Domain</li>
            <li><i class="fa fa-times-circle"></i>Unlimited Support</li>
            </ul>
            </div>
            <div class="price-button">
            <a class="buy-btn" href="#">Buy Now</a>
            </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="single-price">
                <div class="price-head">
                    <h2>Advanced</h2>
                    <p>$100/<span>month</span></p>
                </div>
            <div class="price-content">
            <ul>
            <li><i class="fa fa-check-circle"></i>50GB Space</li>
            <li><i class="fa fa-check-circle"></i>Unlimited Bandwidth</li>
            <li><i class="fa fa-check-circle"></i>Unlimited Email Account</li>
            <li><i class="fa fa-check-circle"></i>Unlimited Domain</li>
            <li><i class="fa fa-check-circle"></i>Unlimited Support</li>
            </ul>
            </div>
            <div class="price-button">
            <a class="buy-btn" href="#">Buy Now</a>
            </div>
            </div>
        </div>
    </div>
</div>
</section>
<!--------Testimonials-------->
<section id="testimonials">
<div class="container">
<h1>Testimonials</h1>
<p class="text-center">Subcribe Easy Tutorilas YouTube Channel to watch more videos.</p>
<div class="row">
 <div class="col-md-4 text-center">
    <div class="profile">
    <img src="user1.jpg" class="user">
    <blockquote>Like this video and ask your questions in comment section, don't forget to Subscribe Easy Tutorials YouTube channel to watch more videos of website designing, digital marketing and photoshop.</blockquote>
        <h3>Avinash Kr <span>Co-Founder at XYZ</span></h3>
    </div>      
 </div>
    <div class="col-md-4 text-center">
    <div class="profile">
    <img src="user2.jpg" class="user">
    <blockquote>Like this video and ask your questions in comment section, don't forget to Subscribe Easy Tutorials YouTube channel to watch more videos of website designing, digital marketing and photoshop.</blockquote>
        <h3>Bharat Kunal <span>Manager at XYZ</span></h3>
    </div>      
 </div>
    <div class="col-md-4 text-center">
    <div class="profile">
    <img src="user3.jpg" class="user">
    <blockquote>Like this video and ask your questions in comment section, don't forget to Subscribe Easy Tutorials YouTube channel to watch more videos of website designing, digital marketing and photoshop.</blockquote>
        <h3>Prabhakar D <span>Founder / CEO at XYZ</span></h3>
    </div>      
 </div>
</div>
</div>
</section>
<!-----------Get in Touch-------->
<section id="contact">
 <div class="container">
    <h1>Get In Touch</h1>
    <div class="row">
    <div class="col-md-6">
    <form class="contact-form">
    <div class="form-group">
    <input type="text" class="form-control" placeholder="Your Name">    
    </div>
    <div class="form-group">
    <input type="number" class="form-control" placeholder="Phone no.">    
    </div>
    <div class="form-group">
    <input type="email" class="form-control" placeholder="Email id">    
    </div>
    <div class="form-group">
    <textarea class="form-control" rows="4" placeholder="Your Message"></textarea>    
    </div>
    <button type="submit" class="btn btn-primary">SEND MESSAGE</button>
    </form>
    </div>
    <div class="col-md-6 contact-info">
        <div class="follow"><b>Address:  </b><i class="fas fa-map-marker"></i> XYZ Road, Bangalore, IN</div>
        <div class="follow"><b>Phone:  </b><i class="fas fa-phone"></i> +1 1234567890</div>
        <div class="follow"><b>Email:</b><i class="fa fa-envelope-o"></i>example@website.com</div>
        <div class="follow"><label><b>Get Social:</b></label>
            <a href="#"><i class="fab fa-facebook-square"></i></a>
            <a href="#"><i class="fab fa-twitter-square"></i></a>
        </div>
    </div>
    </div>
 </div>
</section>
<!-----------Footer------->
    <section id="footer">
        <div class="container text-center">
            <p>Made by Turton Property</p>
        </div>
    </section>
    <!------Footer End------>
    <script src="js/scroll.js"></script>
    <script>
  var scroll = new SmoothScroll('a[href*="#"]');
    </script> 
    </div>
  </div>

</section>
</body>
</html>