<?php
include 'core/init.php';
include 'includes/overall/header.php';

if (empty($_POST) === false) {
    $required_fields = array('email', 'password', 'password_again', 'first_name');
    foreach ($_POST as $key=>$value) {
        if (empty($value) && in_array($key, $required_fields) === true) {
            $errors[] = 'Fields marked with an asterisk are required';
            break 1;
        }
    }
    if (empty($errors) === true) {
        if (user_exists($_POST['email']) === true) {
            $errors[] = 'An account registered with the email \'' . $_POST['email'] . '\' already exists';
        }
        if (strlen($_POST['password']) < 6) {
            $errors[] = 'Your password must be at least 6 characters';
        }
        if ($_POST['password'] !== $_POST['password_again']) {
            $errors[] = 'Passwords do not match';
        }
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
            $errors[] = 'A valid email address is required';
        }
    }
}
?>

<h1>Register</h1>

<?php
if (isset($_GET['success']) && empty($_GET['success'])) {
    echo '<p style="color: #008800; margin-top: 1em;">Account has been created!</p>';
} else {
    if (empty($_POST) === false && empty($errors) === true) {
        $register_data = array(
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name']
        );

        register_user($register_data);
        header('Location: register.php?success');
        exit();
    } else if (empty($errors) === false) {
        echo output_errors($errors);
    }
?>

    <form action="" method="post">
        <ul>
            <li>
                Email*:<br>
                <input type="email" name="email">
            </li>
            <li>
                Password*:<br>
                <input type="password" name="password">
            </li>
            <li>
                Password again*:<br>
                <input type="password" name="password_again">
            </li>
            <li>
                First Name*:<br>
                <input type="text" name="first_name">
            </li>
            <li>
                Last Name:<br>
                <input type="text" name="last_name">
            </li>
            <li>
                <input type="submit" value="Register">
            </li>
        </ul>
    </form>
    * required
<?php
}
include 'includes/overall/footer.php';
?>