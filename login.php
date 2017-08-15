<?php
include "core/init.php";

if (empty($_POST) === false) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $errors[] = "You need to enter an email or password.";
    } elseif (user_exists($email) === false) {
        $errors[] = "We can\'t find that email";
    } else {
        if (strlen($password) > 32) {
            $errors[] = 'Password is too long';
        }
        $login = login($email, $password);
        if($login === false) {
            $errors[] = 'That email/password combination is incorrect';
            print_r($errors);
        } else {
            $_SESSION['ID'] = $login;
            header('Location: index.php');
            exit();
        }
    }
}
include 'includes/overall/header.php';
?>
Markup
<?php
include 'includes/overall/footer.php';
?>