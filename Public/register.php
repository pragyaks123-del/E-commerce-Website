<?php
session_start();

$message = "";
$messageClass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST["name"]);

    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    if (!isset($_SESSION["users"])) {
        $_SESSION["users"] = [];
    }

    // Check if fields are empty
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $message = "All fields are required.";
        $messageClass = "error-message";
    }

    // Check password match
    elseif ($password != $confirm_password) {
        $message = "Passwords do not match.";
        $messageClass = "error-message";
    }

    // Check if email is already registered
    elseif (isset($_SESSION["users"][$email])) {
        $message = "This email is already registered.";
        $messageClass = "error-message";
    }

    // Registration successful
    else {
        $_SESSION["users"][$email] = [
            "name" => $name,
           

            "email" => $email,
            "password" => password_hash($password, PASSWORD_DEFAULT)
        ];

        $_SESSION["user"] = $_SESSION["users"][$email];

        $message = "Registration successful! Welcome, " . htmlspecialchars($name);
        $messageClass = "success-message";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="register-page">

<main class="register-wrapper">
    <section class="welcome-panel">
        <div class="moon"></div>
        <div class="branch"></div>
        <div class="snow-hill"></div>
        <div class="welcome-content">
            <h2>Welcome Page</h2>
            <p>Create your account and start shopping with us today.</p>
            <div class="social-links">
                <span>t</span>
                <span>g+</span>
                <span>f</span>
            </div>
        </div>
    </section>

    <section class="form-panel">
        <div class="form-tabs">
            <a href="login.php">Sign in</a>
            <a class="active-tab" href="register.php">Register</a>
        </div>

        <form class="register-form" method="POST" action="register.php">
            <h1>Register</h1>

            <?php
            if (!empty($message)) {
                echo "<p class='$messageClass'>$message</p>";
            }
            ?>

            <label>Full Name</label>
            <input type="text" name="name" placeholder="Enter your full name..." required>

           

            <label>Email</label>
            <input type="email" name="email" placeholder="Enter email address..." required>

            <label>Password</label>
            <input type="password" name="password" placeholder="Enter password..." required>

            <label>Confirm Password</label>
            <input type="password" name="confirm_password" placeholder="Enter password again..." required>

            <button type="submit">Sign up</button>

            <p class="signin-link">
                Already have an account? <a href="login.php">Sign in.</a>
            </p>
        </form>
    </section>
</main>

</body>
</html>
