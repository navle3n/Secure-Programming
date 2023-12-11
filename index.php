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
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div class="form-group">
                <label for="retypepassword">Retype Password:</label>
                <input type="password" name="retypepassword" id="retypepassword" required>
            </div>

            <div class="form-group">
                <label for="education">Education:</label>
                <input type="text" name="education" pattern="High School|Bachelor's Degree|Master's Degree|Doctorate" title="Please select a valid education level" maxlength="250" id="education" >
            </div>

            <div class="form-group">
                <label for="phonenumber">Phone Number:</label>
                <input type="tel" name="phonenumber" placeholder="Enter a valid number" id="phonenumber" required>
            </div>

            <div class="form-group">
                <label for="DOB">Date of Birth:</label>
                <input type="text" name="DOB" placeholder="DD/MM/YYYY" id="DOB" required>
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
                <label for="street">Street:</label>
                <input type="text" name="street" maxlength="250" id="street">

                <label for="number">Number:</label>
                <input type="text" name="number" id="number">

                <label for="postcode">Postcode:</label>
                <input type="text" name="postcode" placeholder="Enter a valid postcode" id="postcode">
            </div>

            <div class="form-group">
                <label for="JSON">JSON Preferences:</label>
                <textarea name="JSON" rows="4" cols="50" id="JSON"></textarea>
            </div>
            <div class="form-group">
                <input type="submit" value="Register">
            </div>
        </form>
    </div>
    <script src="userFormBuilder.js"></script>
</body>
</html>