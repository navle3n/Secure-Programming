<?php
session_start();
setcookie("cookie", bin2hex(random_bytes(32)), ["samesite" => "Strict", "httponly" => true]);
// Generate CSRF token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
header_remove("X-Powered-By");
header("X-Frame-Options: SAMEORIGIN");
header("X-Content-Type-Options: nosniff");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration Form</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="container">
        <h1>User Registration Form</h1>

        <form method="post" action="process.php" id="registrationForm">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
                <small class="form-helper-text">Enter a username (5-50 characters, alphanumeric and hyphens allowed)</small>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
                <small class="form-helper-text">Please enter a password with at least 8 characters, including one uppercase, one lowercase, and one special character.</small>
            </div>

            <div class="form-group">
                <label for="retypepassword">Retype Password:</label>
                <input type="password" name="retypepassword" id="retypepassword" required>
            </div>

            <div class="form-group">
                <label for="education">Tell us about your education:</label>
                <textarea name="education" id="education" minlength="100" maxlength="300" placeholder="E.g. I study Computer Science at Aston University; I completed my BTEC Level 3 in College..."></textarea>
                <div class="education-info">
                    <small class="form-helper-text">Provide a detailed description of your education (100-300 characters)</small>
                    <div class="char-count" id="charCount">0 characters</div>
                </div>
            </div>

            <div class="form-group">
                <label for="phonenumber">Phone Number:</label>
                <input type="tel" name="phonenumber" placeholder="07123456900" id="phonenumber" required>
                <small class="form-helper-text">Enter a valid number </small>

            </div>

            <div class="form-group">
                <label for="DOB">Date of Birth:</label>
                <input type="text" name="DOB" placeholder="01/01/2001" id="DOB" required>
                <small class="form-helper-text">DD/MM/YYYY</small>

            </div>

            <div class="form-group">
                <label for="COR">Country of Residence:</label>
                <select name="COR" id="corSelect">
                    <option value="">Select Country</option>
                    <option value="US">US</option>
                    <option value="UK">UK</option>
                    <option value="IR">IR</option>
                </select>
            </div>
            
            <div id="hiddenFields" style="display: none;">
                <ul class="field-list">
                    <li>
                        <label for="street">Street:</label>
                        <input type="text" name="street" maxlength="250" id="street">
                    </li>
                    <li>
                        <label for="number">Number:</label>
                        <input type="text" name="number" id="number">
                    </li>
                    <li>
                        <label for="postcode">Postcode:</label>
                        <input type="text" name="postcode" placeholder="Enter a valid postcode" id="postcode">
                    </li>
                </ul>
            </div>

            <div class="form-group">
                <label for="JSON">JSON Preferences:</label>
                <textarea name="JSON" rows="4" cols="50" id="JSON"></textarea>
                <small class="form-helper-text">
                    <pre>
                    {
                        "notificationSettings": {
                            "post": true / false,
                            "sms": true / false,
                            "push": true / false,
                            "frequency": "immediate" / "daily" / "weekly"
                        }
                    } 
                    </pre>
                </small>
            </div>

            <div class="form-group">
                <input type="submit" value="Register">
            </div>
        </form>
    </div>
    <div id="errorMessage" style="color: red; margin-top: 10px;"></div>
    <script src="userFormBuilder.js"></script>
</body>
</html>