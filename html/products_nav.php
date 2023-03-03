<!DOCTYPE html>
<html>
    <head>
        <title>Homepage</title>
        <link rel="stylesheet" href="../style/products_nav_style.css">
        <meta charset="utf-8"/>
        <meta name="author" content="me" />
        <script src="file.js" defer></script>
    </head>

    <?php
        //This page just displays the products order_by navbar for the products page:
            //The inputs on this navbar are used to determine in which order to display the products
            //This can be determined by the buttons in the navbar - these buttons each link to the products page
            //but each one will be use a GET request to set they attribute they represent to be the one that is used
            //to order and in tern display the products:
            //Here window.location is used to send the GET request to reduce the need for multiple forms for each button.
    ?>

    <nav id="products_navbar">
        <h3>Sort by: </h3>
        <label class="products_navbar_label">Make</label>
        <input class="products_navbar_input" type="checkbox" id="make" name="make" value="make" onclick="window.location.href='<?php echo'\products.php?type=' . $_page_type . '&next_page=true&page_number=1&order_by=name';?>'">
        <label class="products_navbar_label">Model</label>
        <input class="products_navbar_input" type="checkbox" id="model" name="model" value="model" onclick="window.location.href='<?php echo'\products.php?type=' . $_page_type. '&next_page=true&page_number=1&order_by=description';?>'">
        <label class="products_navbar_label">Price</label>
        <input class="products_navbar_input" type="checkbox" id="price" name="price" value="price" onclick="window.location.href='<?php echo'\products.php?type=' . $_page_type . '&next_page=true&page_number=1&order_by=price';?>'">
        <label class="products_navbar_label">Quantity</label>
        <input class="products_navbar_input" type="checkbox" id="quantity" name="quantity" value="quantity" onclick="window.location.href='<?php echo'\products.php?type=' . $_page_type . '&next_page=true&page_number=1&order_by=quantity';?>'">
    </nav>
</html>