<?php 
session_start();

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}

$error = '';

$admins = ['admin' => 'admin123'];
$customers = ['customer' => 'customer123'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (isset($admins[$username]) && $admins[$username] === $password) {
        $_SESSION['user'] = $username;
        $_SESSION['role'] = 'admin';
        header('Location: admin_dashboard.php');
        exit();
    } elseif (isset($customers[$username]) && $customers[$username] === $password) {
        $_SESSION['user'] = $username;
        $_SESSION['role'] = 'customer';
        header('Location: customer_dashboard.php');
        exit();
    } else {
        $error = 'Invalid credentials!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambo Market - Login</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 30px;
            background: #f5f5f5;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo-placeholder {
            width: 120px;
            height: auto;
            display: block;
            margin: 0 auto;
        }
        .system-title {
            text-align: center;
            font-size: 32px;
            color: #2c3e50;
            margin: 20px 0;
            font-weight: bold;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #2980b9;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- ✅ Logo Image and Title -->
    <div class="logo-container">
        <img src="logo.png" alt="Tambo Market Logo" class="logo-placeholder">
        <h1 class="system-title">Tambo Market Inventory System</h1>
    </div>

    <h2>Login</h2>

    <form method="POST">
        <div class="form-group">
            <label>Username:</label>
            <input type="text" name="username" required>
        </div>

        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>
        
        <button type="submit">Login</button>

        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
    </form>

</div>

</body>
</html>
