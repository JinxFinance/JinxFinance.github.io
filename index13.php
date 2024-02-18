<?php
// Database connection
$db = new PDO('mysql:host=localhost;dbname=test', 'username', 'password');

// Start the session
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['register'])) {
        // Registration form submitted
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Insert the new user into the database
        $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        $reset_link = "http://yourwebsite.com/reset_password.php?token=$token";
        mail($email, "Password Reset Request", "Click here to reset your password: $reset_link");
    } elseif (isset($_POST['login'])) {

        $token = $_POST['token'];
        $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        $stmt = $db->prepare("UPDATE users SET password = :password WHERE reset_token = :token");
        $stmt->bindParam(':password', $new_password);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        // Login form submitted
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Retrieve the user from the database
        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify the password
        if ($user && password_verify($password, $user['password'])) {
            // Password is correct, create a new session for the user
            $_SESSION['username'] = $user['username'];
        } else {
            // Password is incorrect, display an error message
            echo "Invalid username or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Finance Webpage</title>
    <link rel="stylesheet" href="style.css">
    <style>
        form {
            margin: 20px;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input {
            margin-bottom: 10px;
        }
    </style>
    <script src="script.js"></script>
    <script>
        function calculate() {
            var principal = document.getElementById('principal').value;
            var rate = document.getElementById('rate').value;
            var time = document.getElementById('time').value;
            var interest = (principal * rate * time) / 100;
            alert('Simple Interest: ' + interest);
        }
    </script>
    
</head>
<body>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="principal">Principal:</label>
        <input type="number" id="principal" name="principal" required>
        <label for="rate">Rate of Interest:</label>
        <input type="number" id="rate" name="rate" step="0.01" required>
        <label for="time">Time (in years):</label>
        <input type="number" id="time" name="time" required>
        <input type="submit" value="Calculate">
    </form>

    <?php
    if (!empty($interest)) {
        echo "<p>Simple Interest: $interest</p>";
    }
    ?>
</body>
</html>