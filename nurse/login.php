<?php
session_start();
include '../config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = md5($_POST['password']); 
    
    $sql = "SELECT n.*, h.name as hospital_name, h.id as hospital_id 
            FROM nurses n 
            JOIN hospitals h ON n.hospital_id = h.id 
            WHERE n.email='$email' AND n.password='$password'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['hospital_id'] = $user['hospital_id'];
        $_SESSION['hospital_name'] = $user['hospital_name'];
        $_SESSION['role'] = 'nurse';
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid email or password!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Nurse Login - Blood Bank</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="role-badge">Nurse Login</div>
            <h2>Nurse Access Only</h2>
            
            <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
            <form method="POST">
                <input type="email" name="email" placeholder="Email Address" 
                       value="sarah.nurse@gmail.com" required>
                <input type="password" name="password" placeholder="Password" 
                       value="nurse123" required>
                <button type="submit">Login</button>
            </form>
            
            <p class="switch-role">
                <a href="../index.php">Back to Home</a>
            </p>
        </div>
    </div>
</body>
</html>