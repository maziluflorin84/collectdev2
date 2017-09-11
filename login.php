<?php
include "core/init.php";
logged_in_redirect();

if (empty($_POST) === false) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $errors[] = "You need to enter an email or password.";
    } elseif (email_exists($email) === false) {
        $errors[] = "We can\'t find that email";
    } else {
        if (strlen($password) > 32) {
            $errors[] = 'Password is too long';
        }
        $login = login($email, $password);
        if($login === false) {
            $errors[] = 'That email/password combination is incorrect';
        } else {
            $_SESSION['ID'] = $login;
            header('Location: index.php');
            exit();
        }
    }
} else {
    $errors[] = 'No data received';
}
include 'includes/overall/header.php';
if (empty($errors) === false) {
?>
    <h2>You cannot login because:</h2>
<?php
    echo output_errors($errors);
}
include 'includes/overall/footer.php';