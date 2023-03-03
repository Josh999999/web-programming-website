<!DOCTYPE html>
<html>
    <head>
        <title>Homepage</title>
        <link rel="stylesheet" href="../style/products_style.css">
        <meta charset="utf-8"/>
        <meta name="author" content="me" />
        <script src="file.js" defer></script>
    </head>

    <?php
        //This just displays the search bar for each page:
    ?>
    
    <body>
        <div id="search_bar">
            <form method="get" action="search_page.php">
                <input id="search_input" name="search_input" type="text">
                <input id="search_button" name="search_button" type="submit">
                <input name="page_number" value="1" type="hidden">
                <input name="next_page" value="true" type="hidden">
            </form>
        </div>
    </body>
</html>