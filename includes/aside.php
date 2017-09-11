<aside>
    <?php
    if(logged_in() === true){
        include 'widgets/logged_in.php';
    } else {
        include 'widgets/login.php';
    }
    ?>
</aside>