<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Content-Security-Policy: default-src 'self';");
// Include the User and ConcreteUserBuilder class definitions
require_once 'User.php';
require_once 'ConcreteUserBuilder.php';
require_once 'ConnConfig.php';

// Start the session
session_start();

function displayErrorAndLog($errorMessage) {
    echo $errorMessage;
    error_log($errorMessage);
    exit();
}

try {
    // Create a database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        displayErrorAndLog("Connection failed. Please try again later.");
    }

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            displayErrorAndLog("CSRF token validation failed. Possible CSRF attack.");
        }
        // Function to sanitize input
        function sanitizeInput($input) {
            return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
        }

        // Function to validate username format
        function isValidUsername($username) {
            // Allow alphanumeric characters and hyphens, 5 to 50 characters
            return preg_match('/^[a-zA-Z0-9-]{5,50}$/', $username);
        }

        // Function to validate password format
        function isValidPassword($password) {
            // Require 1 upper, 1 lower, 1 special character, and at least 8 characters
            return preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*]).{8,}$/', $password);
        }

        // Function to validate education format
        function isValidEducation($education) {
            // Allow only text with a minimum length of 100 and a maximum length of 300 characters
            $trimmedEducation = trim($education);
            $educationLength = mb_strlen($trimmedEducation);
            
            return $educationLength >= 100 && $educationLength <= 300;
        }

        // Function to validate phone number format
        function isValidPhoneNumber($phoneNumber, $cor) {
            // Allow UK, Ireland, and US phone number formats
            if ($cor === "UK") {
                $regex = '/^(?:\+44|0)\d{10}$/';
            } elseif ($cor === "IR") {
                $regex = '/^(\+353|0)\d{9}$/';
            } elseif ($cor === "US") {
                $regex = '/^\+1\d{10}$/';
            } else {
                return false; 
            }
            return preg_match($regex, $phoneNumber);
        }

        // Function to validate date format and age
        function isValidDateOfBirth($dob) {
            // Check format DD/MM/YYYY
            if (!preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $dob)) {
                return false;
            }

            // Check age at least 18
            $dobTimestamp = strtotime($dob);
            $minAgeTimestamp = strtotime('-18 years');
            return $dobTimestamp <= $minAgeTimestamp;
        }

        // Function to validate country of residence
        function isValidCountryOfResidence($cor) {
            // Allow only specified countries
            $allowedCountries = ["US", "UK", "IR"];
            return in_array($cor, $allowedCountries);
        }

        // Function to validate street format
        function isValidStreet($street) {
            // Allow up to 250 characters
            return mb_strlen($street) <= 250;
        }

        // Function to validate number format
        function isValidNumber($number) {
            // Customize based on your requirements
            // Example: Allow only numbers and letters
            return preg_match('/^[a-zA-Z0-9]+$/', $number);
        }

        // Function to validate postcode format based on country of residence
        function isValidPostcode($postcode, $cor) {
            switch ($cor) {
                case "UK":
                    // UK postcode validation
                    return preg_match('/^[A-Z0-9]{2,4}\s?\d[A-Z]{2}$/i', $postcode);
                case "US":
                    // US postcode validation
                    return preg_match('/^\d{5}(?:-\d{4})?$/', $postcode);
                case "IR":
                    // Ireland postcode (Eircode) validation
                    return preg_match('/^[A-Z0-9]{3}\s?[A-Z0-9]{4}$/i', $postcode);
                default:
                    return false;
            }
        }
        
       // Function to validate JSON preferences format
       require 'vendor/autoload.php'; // Include the JSON Schema Validator library

       function isValidJSON($json, $schema) {
            $validator = new JsonSchema\Validator;
            $jsonObject = json_decode($json);
            $validator->validate($jsonObject, (object)['$ref' => $schema]);
            if (!$validator->isValid()) {
                displayErrorAndLog("Invalid JSON preferences. Please enter valid JSON.");
                } else{
                return $validator->isValid();
            }
       }

        
        // Validate username
        if (!isValidUsername($_POST['username'])) {
            displayErrorAndLog("Invalid username. Please enter a valid username.");
        }

        // Check if the username already exists in the database
        $checkUsernameQuery = "SELECT COUNT(*) FROM users WHERE username = ?";
        $checkUsernameStmt = $conn->prepare($checkUsernameQuery);

        if (!$checkUsernameStmt) {
            displayErrorAndLog("Error in preparing the username check SQL statement. Please try again later.");
        }

        $checkUsernameStmt->bind_param("s", $_POST['username']);
        $checkUsernameStmt->execute();
        $checkUsernameStmt->bind_result($existingUserCount);
        $checkUsernameStmt->fetch();
        
        $checkUsernameStmt->close();

        if ($existingUserCount > 0) {
            displayErrorAndLog("Username already exists. Please choose a different username.");
        }
        
        // Validate password
        if (!isValidPassword($_POST['password'])) {
            displayErrorAndLog("Invalid password. Please enter a password with at least 8 characters, including one uppercase, one lowercase, and one special character.");
        }

        // Validate retype password
        if ($_POST['password'] !== $_POST['retypepassword']) {
            trigger_error('Passwords do not match.', E_USER_ERROR);
        }

       // Validate education
        if (!isValidEducation($_POST['education'])) {
            displayErrorAndLog("Invalid education. Please provide a detailed description of your education (100-300 characters).");
        }


        // Validate date of birth
        if (!isValidDateOfBirth($_POST['DOB'])) {
            displayErrorAndLog("Invalid Date of Birth. Please use the format DD/MM/YYYY and ensure you are at least 18 years old.");
        }

        // Validate country of residence
        if (!isValidCountryOfResidence($_POST['COR'])) {
            displayErrorAndLog("Invalid Country of Residence. Please select a valid country.");
        }

        // Validate street format (only if country of residence is provided)
        if ($_POST['COR'] && !isValidStreet($_POST['street'])) {
            displayErrorAndLog("Invalid street. Please enter a valid street (up to 250 characters).");
        }

        // Validate number format
        if (!isValidNumber($_POST['number'])) {
            displayErrorAndLog("Invalid number. Please enter a valid number.");
        }

        // Validate postcode format based on country of residence
        if (!isValidPostcode($_POST['postcode'], $_POST['COR'])) {
            displayErrorAndLog("Invalid postcode. Please enter a valid postcode based on your country of residence.");
        }

        $schema = "C:\wamp\www\Secure-Programming\schema.json";
        if (!isValidJSON($_POST['JSON'], $schema)) {
            displayErrorAndLog("Invalid JSON preferences. Please enter valid JSON.");
        }
        
        // Hash the password before storing in the database
        $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Create an instance of ConcreteUserBuilder
        $userBuilder = new ConcreteUserBuilder();

        // Set user attributes from the form data
        $user = $userBuilder
            ->setUsername($_POST['username'])
            ->setPassword($hashedPassword)
            ->setEducation($_POST['education'])
            ->setPhonenumber($_POST['phonenumber'])
            ->setDOB($_POST['DOB'])
            ->setCOR($_POST['COR'])
            ->setStreet($_POST['street'])
            ->setNumber($_POST['number'])
            ->setPostcode($_POST['postcode'])
            ->setJSON($_POST['JSON'])
            ->build();

        // Store user data in the database
        $sql = "INSERT INTO users (username, password, education, phonenumber, dob, cor, street, number, postcode, json_preferences)
        VALUES (?, ?, ?, ?, STR_TO_DATE(?, '%Y/%m/%d'), ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
       
        if (!$stmt) {
            displayErrorAndLog("Error in preparing the SQL statement. Please try again later.");
        }

       // Get values before binding parameters
        $username = $user->getUsername();
        $password = $user->getPassword();
        $education = $user->getEducation();
        $phonenumber = $user->getPhonenumber();
        $dob = $user->getDOB();
        $cor = $user->getCOR();
        $street = $user->getStreet();
        $number = $user->getNumber();
        $postcode = $user->getPostcode();
        $json = $user->getJSON();

        // Bind parameters
        $stmt->bind_param("ssssssssss",
        $username,
        $password,
        $education,
        $phonenumber,
        $dob,
        $cor,
        $street,
        $number,
        $postcode,
        $json
        );

        // Execute the statement
        if ($stmt->execute()) {
            // Registration successful, set session variable
            $_SESSION['registrationSuccess'] = true;
            // Registration successful, redirect to success page
            header("Location: registrationSuccess.php");
            exit();
        } else {
            displayErrorAndLog("Error in executing the SQL statement. Please try again later.");
        }

        // Close the statement
        $stmt->close();
    }
} catch (mysqli_sql_exception $e) {
    // Handle database-related exceptions
    displayErrorAndLog("A database error occurred. Please try again later. Details: " . $e->getMessage() . "\n" . $e->getTraceAsString());
} catch (Exception $e) {
    // Handle other unexpected exceptions
    displayErrorAndLog("An unexpected error occurred. Please try again later. Details: " . $e->getMessage() . "\n" . $e->getTraceAsString());
} finally {
    // Close the database connection
    $conn->close();
}
?>