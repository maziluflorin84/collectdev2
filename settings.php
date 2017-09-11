<?php
include 'core/init.php';
protect_page();

if (empty($_POST) === false) {
    $required_fields = array('email', 'first_name');
    foreach ($_POST as $key=>$value) {
        if (empty($value) && in_array($key, $required_fields) === true) {
            $errors[] = 'Fields marked with an asterisk are required';
            break 1;
        }
    }
    if (empty($errors) === true) {
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
            $errors[] = 'A valid email address is required';
        } else if (email_exists($_POST['email']) === true && $user_data['email'] !== $_POST['email']) {
            $errors[] = 'An account registered with the email \'' . $_POST['email'] . '\' already exists';
        }
    }
}

include 'includes/overall/header.php';
?>

    <h1>Settings</h1>

<?php
if (isset($_GET['success']) === true && empty($_GET['success']) === true) {
    echo '<p style="color: #008800; margin-top: 1em;">Your details have been updated!</p>';
} else {
    if (empty($_POST) === false && empty($errors) === true) {
        $update_data = array(
            'email' => $_POST['email'],
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name']
        );
        update_user($session_user_id, $update_data);
        header('Location:settings.php?success');
        exit();
    } else if (empty($errors) === false) {
        echo output_errors($errors);
    }
    ?>

    <form action="" method="post">
        <ul>
            <li>
                Email*:<br>
                <input type="email" name="email" value="<?php echo $user_data['email']; ?>">
            </li>
            <li>
                First Name*:<br>
                <input type="text" name="first_name" value="<?php echo $user_data['first_name']; ?>">
            </li>
            <li>
                Last Name:<br>
                <input type="text" name="last_name" value="<?php echo $user_data['last_name']; ?>">
            </li>
            <li>
                <input type="submit" value="Update">
            </li>
        </ul>
    </form>

<?php
}
include 'includes/overall/footer.php';
?>