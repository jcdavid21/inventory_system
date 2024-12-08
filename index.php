<!DOCTYPE html>
<!-- Coding by CodingNepal | www.codingnepalweb.com-->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title> Login and Registration Form in HTML & CSS | CodingLab </title>
    <link rel="stylesheet" href="./styles/index.css">
    <!-- Fontawesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="./scripts/jquery.js"></script>
    <script src="./scripts/sweetalert2.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
  <div class="container">
    <input type="checkbox" id="flip">
    <div class="cover">
      <div class="front">
        <img src="./imgs/—Pngtree—medical stethoscope_4730860.png" alt="">
      </div>
      <div class="back">
      </div>
    </div>
    <div class="forms">
        <div class="form-content">
          <div class="login-form">
            <div class="title">Login</div>
          <form action="#">
            <div class="input-boxes">
              <div class="input-box">
                <i class="fa-solid fa-user"></i>
                <input type="text" placeholder="Enter your username" id="uname" required>
              </div>
              <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" placeholder="Enter your password" id="password" required>
              </div>
              <!-- <div class="text"><a href="#">Forgot password?</a></div> -->
              <div class="button input-box">
                <input type="submit" value="Sumbit" id="submit">
              </div>
              <!-- <div class="text sign-up-text">Don't have an account? <label for="flip">Sigup now</label></div> -->
            </div>
        </form>
      </div>
    </div>
    </div>
  </div>

  <script src="./jquery/login.js"></script>
</body>
</html>