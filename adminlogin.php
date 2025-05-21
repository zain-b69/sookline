<?php
session_start();
require_once 'db.php';

$error_message = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result_admin = $stmt->get_result();

    if ($result_admin && $result_admin->num_rows > 0) {
        $res = $result_admin->fetch_assoc();
        if ($password == $res['password']) {
            $_SESSION['admin_id'] = $res['id'];
            $_SESSION['username'] = $res['username'];
            header('Location: dashboard.php');
            exit();
        } else {
            $error_message = "Mot de passe incorrect (admin).";
        }
    } else {
        $stmt = $conn->prepare("SELECT * FROM clients WHERE email = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result_client = $stmt->get_result();

        if ($result_client && $result_client->num_rows > 0) {
            $res_client = $result_client->fetch_assoc();
            if ($password == $res_client['password']) {
                $_SESSION['client_id'] = $res_client['id'];
                $_SESSION['prenom'] = $res_client['prenom'];
                header('Location: acc2.php');
                exit();
            } else {
                $error_message = "Mot de passe incorrect (client).";
            }
        } else {
            $error_message = "Nom d'utilisateur ou email incorrect.";
        }
    }

    // Si il y a un message d'erreur, le stocker et rediriger
    if (!empty($error_message)) {
        $_SESSION['message'] = $error_message;
        header('location: login.php');
        exit();
    }
}
?>
