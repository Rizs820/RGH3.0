<!DOCTYPE html>
<html>
<?php
    include("head.php");
?>
<body class="<?php echo $rm_theme_color;?>">
    <?php
        //include("loader.php");
        include("nav.php");

    ?>
    <section>
        <?php
            include("leftside.php");
            include("rightside.php");
        ?>
    </section>

    <section class="content">
        <?php
            //include("blaze/dash.blaze.php");
            include($act_path);
        ?>
    </section>
    <?php
        include("jquery.php");
    ?>
    
</body>

</html>