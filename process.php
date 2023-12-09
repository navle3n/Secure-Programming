//process.php
<?php

// Include the User and ConcreteUserBuilder class definitions
require_once 'User.php';
require_once 'ConcreteUserBuilder.php';

// Database connection details
$servername = "your_servername";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";

try {
    // Create a database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Create an instance of ConcreteUserBuilder
        $userBuilder = new ConcreteUserBuilder();

        // Set user attributes from the form data
        $user = $userBuilder
            ->setUsername($_POST['username'])
            ->setPassword($_POST['password'])
            ->setRetypepass($_POST['retypepass'])
            ->setEducation($_POST['education'])
            ->setPhonenumber($_POST['phonenumber'])
            ->setDOB($_POST['DOB'])
            ->setCOR($_POST['COR'])
            ->setStreet($_POST['street'])
            ->setNumber($_POST['number'])
            ->setPostcode($_POST['postcode'])
            ->setJSON($_POST['JSON'])
            ->build();

        // Display the built user details 
        // echo "<h2>User Details:</h2>";
        // echo "<p>Username: " . $user->getUsername() . "</p>";
        // echo "<p>Password: " . $user->getPassword() . "</p>";
        // echo "<p>Retype Password: " . $user->getRetypepass() . "</p>";
        // echo "<p>Education: " . $user->getEducation() . "</p>";
        // echo "<p>Phone Number: " . $user->getPhonenumber() . "</p>";
        // echo "<p>Date of Birth: " . $user->getDOB() . "</p>";
        // echo "<p>Country of Residence: " . $user->getCOR() . "</p>";
        // echo "<p>Street: " . $user->getStreet() . "</p>";
        // echo "<p>Number: " . $user->getNumber() . "</p>";
        // echo "<p>Postcode: " . $user->getPostcode() . "</p>";
        // echo "<p>JSON: " . $user->getJSON() . "</p>";

        
            // Store user data in the database
            $sql = "INSERT INTO users (username, password, education, phonenumber, dob, cor, street, number, postcode, json_preferences)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);

            if (!$stmt) {
                throw new Exception("Error in preparing the SQL statement: " . $conn->error);
            }

            $stmt->bind_param("ssssssssss", 
                $user->getUsername(),
                $user->getPassword(),
                $user->getEducation(),
                $user->getPhonenumber(),
                $user->getDOB(),
                $user->getCOR(),
                $user->getStreet(),
                $user->getNumber(),
                $user->getPostcode(),
                $user->getJSON()
            );

            if (!$stmt->execute()) {
                throw new Exception("Error in executing the SQL statement: " . $stmt->error);
            }

            echo "User data stored successfully in the database.";

            $stmt->close();
        }
    }

    ?>