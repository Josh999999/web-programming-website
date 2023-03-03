<!DOCTYPE html>

<?php
    include('header.php');
?>

<html>
    <head>
        <title>Homepage</title>
        <link rel="stylesheet" href="../style/home_style.css?p=<?php print sha1(time()); ?>">
        <meta charset="utf-8"/>
        <meta name="author" content="me" />
        <script src="file.js" defer></script>
        
    </head>
    
    <?php
        //The homepage contains nothing but some text and all the regular things found
        //On every page: header, head, footer.
    ?>
    
    <div id="search_bar">
        <?php
        include('search_bar.php');
        ?>
    </div>

    <body>
        <div id="out_body2">
            <div id="body2">
                <article id="welcome_text">
                    <h2>Welcome to my guitar shop</h2>
                    <br>
                    <p>
                        <u>Welcome to my guitar shop!</u><br>
                        Here we sell all kinds of guitars and<br> 
                        guitar related items such as<br> 
                        (guitar picks, amplifiers and more!)<br>
                        Don't forget to create an account so<br>
                        you to can sell upload and sell your own<br> 
                        guitars and your own guitar related items<br> 
                        here too!!<br>
                    </p>
                </article>
            </div>
        </div>
    </body>

    
</html>

<?php
    include('footer.php');
?>