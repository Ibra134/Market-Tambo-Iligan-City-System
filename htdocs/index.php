<?php
session_start();

$current_page = basename($_SERVER['PHP_SELF']);
if (($current_page != 'index.php') && isset($_SESSION['customer'])) {
    header("Location: customer_dashboard.php");
    exit();
}
if (($current_page != 'index.php') && isset($_SESSION['admin'])) {
    header("Location: admin_dashboard.php");
    exit();
}

include 'db_config.php';
include 'header.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $form_type = $_POST['form_type'];

    if ($form_type === 'admin') {
        $sql = "SELECT * FROM Market_administrators WHERE Name = ? AND Password = ?";
    } elseif ($form_type === 'customer') {
        $sql = "SELECT * FROM Customers WHERE Name = ? AND Password = ?";
    } else {
        echo "Invalid form type.";
        exit();
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if ($form_type === 'admin') {
            $_SESSION['admin'] = $username;
            header("Location: admin_dashboard.php");
            exit();
        } elseif ($form_type === 'customer') {
            $_SESSION['customer'] = $username;
            header("Location: customer_dashboard.php");
            exit();
        }
    } else {
        $error = "Invalid credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Tambo Inventory</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 900px;
            width: 100%;
            background: #fff;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            padding: 30px;
        }

        .form-box {
            width: 45%;
            padding: 20px;
            text-align: center;
        }

        h2 {
            color: #4CAF50;
            margin-bottom: 20px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            background: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #45a049;
        }

        .error {
            color: red;
            font-size: 14px;
        }

        .register {
            margin-top: 15px;
        }

        .register a {
            color: #4CAF50;
            text-decoration: none;
        }

        .register a:hover {
            color: #45a049;
        }

        @media screen and (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            
            .form-box {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="container">

    <div class="form-box">
        <h2>Admin Login</h2>
        <form method="POST" action="">
            <input type="hidden" name="form_type" value="admin">
            <input type="text" name="username" placeholder="Admin Username" required>
            <input type="password" name="password" placeholder="Admin Password" required>
            <button type="submit">Login</button>
        </form>

        <?php if (isset($error) && $_POST['form_type'] === 'admin'): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
    </div>

    <div class="form-box">
        <h2>Customer Login</h2>
        <form method="POST" action="">
            <input type="hidden" name="form_type" value="customer">
            <input type="text" name="username" placeholder="Customer Username" required>
            <input type="password" name="password" placeholder="Customer Password" required>
            <button type="submit">Login</button>
        </form>

        <?php if (isset($error) && $_POST['form_type'] === 'customer'): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <div class="register">
            <p>Don't have an account? <a href="customer_register.php">Register here</a></p>
        </div>
    </div>
</div>

</body>
</html>
