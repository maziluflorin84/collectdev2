<nav>
    <ul>
    <?php if (logged_in()) { ?>
        <li><a href="index.php">My Devices</a></li>
        <li><a href="add_device.php">Add Device</a></li>
    <?php } else { ?>
        <li><a href="register.php">Register</a></li>
    <?php } ?>
    </ul>
</nav>