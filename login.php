<?php
session_start();
include "adb.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $email = strtolower(trim($_POST["email"]));
    $password = $_POST["password"];

    $sql = "SELECT id, name, email, password FROM customers WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        $customer = $result->fetch_assoc();

        if (password_verify($password, $customer["password"])) {

            $_SESSION["customer_id"] = $customer["id"];
            $_SESSION["customer_name"] = $customer["name"];

            header("Location: index.html");
            exit();

        } else {
            $message = "Wrong password.";
        }

    } else {
        $message = "Customer not found.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Login</title>
</head>

<body>

<h2>Customer Login</h2>

<p><?php echo $message; ?></p>

<form method="POST">

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Login</button>

</form>

<p>
    Don't have an account?
    <a href="signup.php">Create Account</a>
</p>

</body>
</html>