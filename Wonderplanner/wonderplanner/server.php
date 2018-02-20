<?php
$servername = "localhost";
$username = "root";
$password = "1123";
$dbname = "wonderplanner";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    echo "connection failed";
}

// initializing variables
$fist_name = "";
$last_name = "";
$email = "";
$password_1 = "";
$password_2 = "";
$address="";
$city="";
$state="";
$zipcode="";

// REGISTER USER
if (isset($_POST['submit'])) {
  // receive all input values from the form
  $first_name = mysqli_real_escape_string($db, $_POST['contact-name']);
  $last_name = mysqli_real_escape_string($db, $_POST['contact-lname']);
  $email = mysqli_real_escape_string($db, $_POST['contact-email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['contact-password']);
  $password_2 = mysqli_real_escape_string($db, $_POST['contact-password2']);
  $address = mysqli_real_escape_string($db, $_POST['contact-address']);
  $city = mysqli_real_escape_string($db, $_POST['contact-city']);
  $state = mysqli_real_escape_string($db, $_POST['contact-state']);
  $zipcode = mysqli_real_escape_string($db, $_POST['contact-zipcode']);


    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($first_name || empty($last_name))) { array_push($errors, "Username is required"); }
    if (empty($email)) { array_push($errors, "Email is required"); }
    if (empty($password_1)) { array_push($errors, "Password is required"); }
    if ($password_1 != $password_2) {
  	array_push($errors, "The two passwords do not match");
    }

    // first check the database to make sure
    // a user does not already exist with the same username and/or email
    $user_check_query = "SELECT * FROM users WHERE first_name='$first_name' OR email='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
      if ($user['first_name'] === $first_name && $user['last_name'] === $last_name) {
        array_push($errors, "Username already exists");
      }

      if ($user['email'] === $email) {
        array_push($errors, "email already exists");
      }
    }

    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
    	$password = md5($password_1);//encrypt the password before saving in the database

    	$sql = "INSERT INTO users (first_name, last_name, email, password, address)
    			  VALUES('$first_name', '$last_name', '$email','$password', '$address')";
    	mysqli_query($db, $sql);
    	$_SESSION['$fist_name'] = $first_name;
      $_SESSION['$last_name'] = $last_name;
    	$_SESSION['success'] = "You are now logged in";
    	header('location: Sign_up.php');
    }


  if ($conn->query(sql) === TRUE) {
      echo "New record created successfully";
  } else {
      echo "Error: " . sql . "<br>" . $conn->error;
  }
}

  $conn->close();
  ?>
