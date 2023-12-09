<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration Form</title>
    <script src="UserFormBuilder.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <h1>User Registration Form</h1>

    <form method="post" action="process.php">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" required>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="retypepass">Retype Password:</label>
            <input type="password" name="retypepass" required>
        </div>

        <div class="form-group">
            <label for="education">Education:</label>
            <input type="text" name="education" maxlength="250">
        </div>

        <div class="form-group">
            <label for="phonenumber">Phone Number:</label>
            <input type="text" name="phonenumber" placeholder="Enter a valid number" required>
        </div>

        <div class="form-group">
            <label for="DOB">Date of Birth:</label>
            <input type="text" name="DOB" placeholder="DD/MM/YYYY" required>
        </div>

        <div class="form-group">
            <label for="COR">Country of Residence:</label>
            <select name="COR">
                <option value="US">US</option>
                <option value="UK">UK</option>
                <option value="IR">IR</option>
            </select>
        </div>

        <div class="form-group">
            <label for="street">Street:</label>
            <input type="text" name="street" maxlength="250">
        </div>

        <div class="form-group">
            <label for="number">Number:</label>
            <input type="text" name="number">
        </div>

        <div class="form-group">
            <label for="postcode">Postcode:</label>
            <input type="text" name="postcode" pattern="[A-Za-z\d\s]{6,8}" placeholder="Enter a valid postcode">
        </div>

        <div class="form-group">
            <label for="JSON">JSON Preferences:</label>
            <textarea name="JSON" rows="4" cols="50"></textarea>
        </div>

        <div class="form-group">
            <input type="submit" value="Register">
        </div>
    </form>

</body>
</html>