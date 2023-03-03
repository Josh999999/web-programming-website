<!DOCTYPE html>

<?php
    include('header.php');
?>

<html>
    <head>
        <title>Homepage</title>
        <link rel="stylesheet" href="../style/products_style.css?p=<?php print sha1(time()); ?>">
        <meta charset="utf-8"/>
        <meta name="author" content="me" />
        <script src="file.js" defer></script>
    </head>
    
    <?php
    //The search page acts exactly the same as the products page but uses the searched for attribute
    //to determine what to render on the page:
    require_once('connection.php');
    $table_name = "products";
    $connection_obj = new connectionClass($table_name);

    //Test to see if the GET request was for a search
    if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['search_input'])){
        if(!empty($_GET['search_input'])){
            //Sets the current page to the page number in the request
            $_cur_page = $_GET['page_number'];

            //Sets the order_by values
            $_total_items_pp = 5;
            $nums_rows = null;
            $_order_by_value = "product_id";
            $search_by = $_GET['search_input'];

            //When you get time role these functions into 1 with an if statement dummy!
            $num_rows = intval($connection_obj->get_num_rows_search($search_by)[0]['COUNT(*)']);
            $total_pages = ceil($num_rows / $_total_items_pp);
        }
    }
    ?>

    <body>
        <div id="body2">
            <aside id="products_sidebar">
                <div id="search_bar">
                    <?php
                    include('search_bar.php');
                    ?>
                </div>

                <div id="products_nav">
                    <?php
                        //This creates a link to each "page" in the search page by looping through each
                        //number in total_pages and displaying that as a link (represents page number)
                        if ($_cur_page <= $total_pages){
                            for ($i = 1; $i <= $total_pages; $i++){
                                if ($i == $_cur_page){
                                    echo "<a>| $i |</a>";
                                }
                                else{
                                    //Links back to products with information on which page to display
                                    echo "<a href='search_page.php?next_page=true&page_number=$i&search_input=$search_by'>| $i |</a>";
                                }
                            }
                        }
                    ?>
                </div>
            </aside>

            <div id="products_display_area">
                <?php
                    //This all operates the same was as on the prodcuts page:
                    if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['next_page']) && !empty($_GET['search_input']) or $_cur_page == 1){
                        $_cur_page = intval($_GET['page_number']);
                        $_limit_lb = ($_cur_page -1) * $_total_items_pp;
                        $array = null;
                        $array = $connection_obj->run_product_limit_query_search($_limit_lb, $_total_items_pp, $search_by);
                        if(empty($array)){
                            ?>
                            <h4 class="product_container"><?php echo "There are no products of this name";?></h4>
                            <?php
                        }
                        $i = $_limit_lb + 1;

                        //Displays the products:
                        foreach ($array as $row) {
                            ?>
                            <div class="product_container" id="<?php echo "" . $row['product_id'] . "";?>">
                            <br>
                                <dl>
                                    <dt><?php echo "<p>Product: " . $row['name'] . ":</p>"; ?></dt>
                                    <?php
                                    $product_id = $row['product_id'];
                                    ?>
                                    <dd><a href="<?php echo "display_product.php?product_id=$product_id&view_products=1"; ?>"><img src="<?php echo "../script/data/Images/" . $row['image_reference'];?>"></a></dd>
                                    <dd><?php echo "Price: " . $row['price']; ?></dd>
                                </dl>
                            <br>
                            </div>
                            <?php
                            $i++;
                        }
                    }
                ?>
            </div>
        </div>
    </body>
</html>

<?php
    include('footer.php');
?>