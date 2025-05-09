<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Medallion Theater | Sign Up</title>
    <script src="script/togglePassword.js" defer></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Georgia', serif;  }
  
    body {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: 
        linear-gradient(rgba(245, 249, 253, 0.9), rgba(245, 249, 253, 0.9)), 
        url('images/film.jpg') no-repeat center center fixed;
    background-size: cover;
    font-family: 'Georgia', serif;
    }
  
    a {
        text-decoration: none;
        color: #0a2c73;
    }
  
    a:hover {
        text-decoration: underline;
    }
    
    .wrapper {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }
    
    .register-box {
        position: relative;
        width: 420px;
        background: #ffffff;
        border-radius: 25px;
        padding: 6em 2.5em 3em 2.5em;
        color: #0a2c73;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }
    
    .login-header {
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #0a2c73;
        width: 150px;
        height: 70px;
        border-radius: 0 0 20px 20px;
    }
    
    .login-header h1 {
        font-size: 26px;
        color: #fff;
        letter-spacing: 2.8px;
        text-shadow: 0 0 5px #b2d7ff, 0 0 10px #457bca;
    }
    
    .login-header::before,
    .login-header::after {
        content: "";
        position: absolute;
        top: 0;
        width: 30px;
        height: 30px;
        background: transparent;
    }
    
    .login-header::before {
        left: -30px;
        border-top-right-radius: 50%;
        box-shadow: 15px 0 0 0 #0a2c73;
    }
    
    .login-header::after {
        right: -30px;
        border-top-left-radius: 50%;
        box-shadow: -15px 0 0 0 #0a2c73;
    }
    
    .input-box {
        position: relative;
        display: flex;
        flex-direction: column;
        margin: 20px 0;
    }
    
    .input-field {
        width: 100%;
        height: 55px;
        font-size: 16px;
        padding-inline: 20px 50px;
        border-radius: 14px;
        outline: none;
        background: transparent;
        color: #0a2c73;
        border: 2.7px solid #a8bedc;
        transition: border-color 0.3s ease;
        font-family: 'Georgia', serif;
        box-shadow: inset 2px 2px 6px #dbe9ff, inset -2px -2px 6px #a3b9e4;
    }
    
    .input-box input[type="file"],
    .input-box input[type="date"] {
        display: flex;
        align-items: center;
        justify-content: center;
        padding-top: 13px;
    }
    
    .label {
        position: absolute;
        top: 18px;
        left: 20px;
        color: #5a6880;
        transition: 0.2s;
        pointer-events: none;
    }
    
    .input-field:focus ~ .label,
    .input-field:valid ~ .label {
        top: -8px;
        left: 20px;
        font-size: 14px;
        font-weight: 600;
        background-color: #0a2c73;
        border-radius: 30px;
        border-color: #1b3a7a;
        padding: 0 10px;
        box-shadow:0 0 8px #1b3a7a;
        background: #f1f6ff;
    }
    
    .icon {
        position: absolute;
        top: 18px;
        right: 25px;
        font-size: 20px;
        cursor: pointer;
        color: #0a2c73;
    }
    
    .button {
        width: 100%;
        height: 50px;
        background: #0a2c73;
        color: #fff;
        font-size: 16px;
        font-weight: 600;
        border: none;
        border-radius: 14px;
        cursor: pointer;
        transition: backround 0.4s ease;
        margin-bottom: 20px;
    }
    
    .button:hover, .btn-submit:focus {
        background: linear-gradient(145deg, #274690, #1b3a7a);
        box-shadow: 0 8px 20px #1b3a7acc, 0 0 12px #457bcaaa inset;
    }
    
    .register {
        text-align: center;
    }
    
    .register p {
        font-size: 15px;
    }
    
    .register a {
        font-weight: 550;
    }
    
    @media only screen and (max-width: 564px) {
        .wrapper {
        padding: 20px;
        }
    
        .register-box {
        padding: 7.5em 1.5em 4em;
        }
    
        .input-box-group {
        flex-direction: column;
        }
    }

    /* Decorative medallion shapes */
    .medallion {
        position: absolute;
        border-radius: 50%;
        border: 6px solid #274690;
        box-shadow: 0 0 15px rgba(39,70,144,0.4), inset 0 0 15px rgba(39,70,144,0.6);
    }

    .medallion.top-left {
        width: 90px;
        height: 90px;
        top: -45px;
        left: -40px;
    }

    .medallion.bottom-right {
        width: 120px;
        height: 120px;
        bottom: -60px;
        right: -60px;
    }
</style>

<body>
    <div class="wrapper">
        <div class="register-box">
        <div class="medallion top-left"></div>
        <div class="medallion bottom-right"></div>
            <div class="login-header">
                <h1>Sign Up</h1>
            </div>
            <form action="remote/signUpProcess.php" method="POST" onsubmit="return validatePasswords()">
                <div class="input-box">
                    <input type="text" id="fullname" name="fullname" class="input-field" required>
                    <label for="fullname" class="label">Full Name</label>
                    <i class='bx bx-user icon'></i>
                </div>

                <div class="input-box">
                    <input type="email" id="email" name="email" class="input-field" required>
                    <label for="email" class="label">Email</label>
                    <i class='bx bx-envelope icon'></i>
                </div>

                <div class="input-box">
                    <input type="tel" id="contact" name="contact" class="input-field" required>
                    <label for="contact" class="label">Contact Number</label>
                    <i class='bx bx-phone icon'></i>
                </div>

                <div class="input-box">
                    <input type="password" id="password" name="password" class="input-field" required>
                    <label for="password" class="label">Password</label>
                    <i class='bx bx-hide icon show_password' alt="Show password" onclick="togglePassword('password')"></i>
                </div>

                <div class="input-box">
                    <input type="password" id="confirmPassword" name="confirmPassword" class="input-field" required>
                    <label for="confirmPassword" class="label">Confirm Password</label>
                    <i class='bx bx-hide icon show_password' alt="Show confirm password" onclick="togglePassword('confirmPassword')"></i>
                </div>

                <button type="submit" class="button" name="signUp">Sign Up</button>

                <div class="register">
                    <p>Already have an account? <a href="index.php">Log In</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
