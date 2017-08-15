<aside>
    <?php
    if(logged_in() === true){
        echo 'Logged in';
    } else {
        include 'widgets/login.php';
    }
    ?>
</aside>