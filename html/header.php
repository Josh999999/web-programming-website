<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../style/header.css?p=<?php print sha1(time()); ?>">
        <link rel="stylesheet" href="../style/template.css?p=<?php print sha1(time()); ?>">
        <meta charset="utf-8"/>
    </head>

    <?php
        //A session is always present on any file with a header:
        //The header and the footer is a separate file so that include can be run
        //on it on any page, and it will be present on it.
        //This is useful as it rudeces the amount of code needed to
        //write or at least the amount of code present on once page.
        session_start();
        if(isset($_SESSION['basket_items'])){
            $_basket_countItems = count($_SESSION['basket_items']);
        }
        //Make sure to set the basket count in the header so it is always set
        //no matter the page you are on.

        //This is useful as the basket it always present but doesn't neccesarily contain
        //any items.
    ?>

    <header id="header1">
        <header id="header2">
            <h1 id="header_title">My Guitar Shop</h1>

            <div id="basket_div">
                <input id="basket_button" type="button" class="alt_nav" value="Basket" onclick="window.location.href='\bbasket.php'">
                <h3 id="num_basket_items"><?php if(isset($_basket_countItems)) {echo $_basket_countItems;} else {echo "0";} ?></h3>
            </div>

            <input type="button" class="alt_nav" value="Account" onclick="window.location.href='\decide_account.php?type=logged_in'">

            <div id="guitar_header_img"></div>

            <div id="nav_list1">
                <input id="home" type="button" value="Home" onclick="window.location.href='\home.php'">
                <input id="guitars" type="button" value="Guitars" onclick="window.location.href='\products.php?type=guitar&next_page=true&page_number=1&order_by=none'">
                <input id="applifiers" type="button" value="Applifiers" onclick="window.location.href='\products.php?type=ampplifier&next_page=true&page_number=1&order_by=none'">
                <input id="extra-bits" type="button" value="Extra bits" onclick="window.location.href='\products.php?type=extra&next_page=true&page_number=1&order_by=none'">
            </div>

            <div class="dropdown">
                <button class="dropbtn"><img id="drop_down_img" src="../Images/drop_down.png"></button>
                <div id="nav_list2">
                    <input id="home" type="button" value="Home" onclick="window.location.href='\home.php'">
                    <input id="guitars" type="button" value="Guitars" onclick="window.location.href='\products.php?type=guitar&next_page=true&page_number=1&order_by=none'">
                    <input id="applifiers" type="button" value="Applifiers" onclick="window.location.href='\products.php?type=ampplifier&next_page=true&page_number=1&order_by=none'">
                    <input id="extra-bits" type="button" value="Extra bits" onclick="window.location.href='\products.php?type=extra&next_page=true&page_number=1&order_by=none'">
                </div>
            </div>

        </header>
    </header>
</html>