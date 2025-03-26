<?php
session_start();
require_once '../includes/database.php';  // Use centralized DB connection

// Redirect if already logged in
if (isset($_SESSION['customer_id'])) {
    header("Location: ../customer/customer_dashboard.php");
    exit();
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Trim and sanitize input
    $username = trim($_POST['customer_username']);
    $password = trim($_POST['customer_password']);

    // Validate inputs
    if (!empty($username) && !empty($password)) {
        
        // Prepare statement to prevent SQL injection
        $stmt = $conn->prepare("
            SELECT Customer_ID, Username, Password 
            FROM Customers 
            WHERE Username = ?
        ");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $user['Password'])) {
                // Set session variables
                $_SESSION['customer_id'] = $user['Customer_ID'];
                $_SESSION['customer_name'] = $user['Username'];

                // Redirect to dashboard
                header("Location: ../customer/customer_dashboard.php");
                exit();
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            $error = "No customer found with that username.";
        }
        
        $stmt->close();
    } else {
        $error = "Please fill in all fields.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- Centralized CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background:rgb(247, 243, 243);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 400px;
        }

        h2 {
            color: #4CAF50;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            text-align: left;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #45a049;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }

        a {
            display: inline-block;
            margin-top: 10px;
            color: #4CAF50;
            text-decoration: none;
        }

        a:hover {
            color: #45a049;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Customer Login</h2>

    <!-- Display error if there's any -->
    <?php if (!empty($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <!-- Login form -->
    <form method="POST">
        <label>Username:</label>
        <input type="text" name="customer_username" required>

        <label>Password:</label>
        <input type="password" name="customer_password" required>

        <button type="submit">Login</button>
    </form>

    <a href="../index.php">Back to Home</a>
</div>

</body>
</html>