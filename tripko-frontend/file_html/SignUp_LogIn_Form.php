<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Signup Form - TripKo</title>
    <link rel="stylesheet" href="../file_css/SignUp_LogIn_Form.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="container">
        <div class="form-box login">
            <?php if (isset($_GET['error'])): ?>
                <div class="error-message">
                    <?php 
                    switch($_GET['error']) {
                        case 'invalid':
                            echo 'Invalid username or password';
                            break;
                        case 'notfound':
                            echo 'User not found';
                            break;
                        case 'system':
                            echo 'System error, please try again';
                            break;
                        case 'empty':
                            echo 'Please fill in all fields';
                            break;
                        case 'session':
                            echo 'Your session has expired. Please log in again';
                            break;
                        case 'timeout':
                            echo 'Session timed out for security. Please log in again';
                            break;
                        case 'inactive':
                            echo 'Account is inactive. Please contact support';
                            break;
                        case 'exists':
                            echo 'Username already exists. Please choose another';
                            break;
                        default:
                            echo 'An error occurred. Please try again';
                    }
                    ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_GET['success'])): ?>
                <div class="success-message">
                    Registration successful! Please log in.
                </div>
            <?php endif; ?>
            <form action="../../tripko-backend/login.php" method="POST">
                <h1>Login</h1>
                <div class="input-box">
                    <input type="text" name="username" placeholder="Username" required minlength="3" maxlength="50">
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="password" placeholder="Password" required minlength="6">
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <div class="forgot-link">
                    <a href="#">Forgot Password?</a>
                </div>
                <button type="submit" class="btn">Login</button>
            </form>
        </div>

        <div class="form-box register">
            <form action="../../tripko-backend/register.php" method="POST" id="registerForm">
                <h1>Sign Up</h1>
                <div class="input-box">
                    <input type="text" name="username" placeholder="Username" required minlength="3" maxlength="50"
                           pattern="[a-zA-Z0-9_]+" title="Username can only contain letters, numbers, and underscore">
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="password" placeholder="Password" required minlength="6"
                           id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}"
                           title="Must contain at least one number, one uppercase and lowercase letter, and at least 6 characters">
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required
                           id="confirm_password">
                    <i class='bx bxs-lock'></i>
                </div>
                <button type="submit" class="btn">Sign Up</button>
            </form>
        </div>

        <div class="toggle-box">
            <div class="toggle-panel toggle-left">
                <h1>Hello, Welcome!</h1>
                <p>Don't have an account?</p>
                <button class="btn register-btn">Register</button>
            </div>

            <div class="toggle-panel toggle-right">
                <h1>Welcome Back!</h1>
                <p>Already have an account?</p>
                <button class="btn login-btn">Login</button>
            </div>
        </div>
    </div>
    
    <script>
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        var password = document.getElementById('password');
        var confirm = document.getElementById('confirm_password');
        
        if (password.value !== confirm.value) {
            e.preventDefault();
            alert('Passwords do not match!');
        }
    });
    </script>
    <script src="../file_js/SignUp_LogIn_Form.js"></script>
</body>
</html>