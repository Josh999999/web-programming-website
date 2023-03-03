<?php
class connectionClass{
    //Information about the database connection:
    public $username = "s5411715";
    public $password = "RUqRhujxREoN9K4bngiJrttWA47cyfbF";
    public $host = "db.bucomputing.uk";
    public $port = 6612;
    public $database = "s5411715";
    public $table = "";
    public $SELECT_ALL_STATEMENT = "";
    //Maybe change the list to a set dictionary (ASSOC array)
    public $products_list = ["guitar", "ampplifier", "string", "pick", "part", "book", "stand", "bag", "cable", "strap"];
    //Stored queries before they are composed and sent to the database:
    public $SELECT_username_password_STATEMENT = "SELECT user_id, username, password FROM customers WHERE username = ";
    public $SELECT_user_details_STATEMENT = "SELECT * FROM customers WHERE user_id = ";
    public $SELECT_products_rows = "SELECT COUNT(*) FROM products WHERE product_type_id = ";
    public $SELECT_basket_items_STATEMENT = "SELECT * FROM products WHERE product_id IN";
    public $SELECT_limit_products_STATEMENT = "SELECT * FROM products LIMIT WHERE ";
    public $SELECT_extra_products_STATEMENT = "SELECT COUNT(*) FROM products WHERE product_type_id > 2";
    public $SELECT_single_product_STATEMENT = "SELECT * FROM products WHERE product_id = ";
    public $SELECT_heighest_order_group_STATEMENT = "SELECT MAX(order_group_id) FROM order_groups";

    /*
        __construct is equivalent to __init__() in python. 
        It initalises more dynamic elements of the object
    */

    public function update_product($product_id, $name, $description, $price, $image_reference, $quantity){
        $connection = $this->mysqli_connect();
        $UPDATE_product_STATEMENT = "UPDATE products SET name='$name', description='$description', price=$price, image_reference='$image_reference', quantity=$quantity
                                     WHERE product_id='$product_id'";
        mysqli_query($connection, $UPDATE_product_STATEMENT);
        $this->mysqli_disconnect($connection);
    }

    public function add_product($name, $description, $price, $date_listed, $image_reference, $product_type_id, $user_id, $quantity){
        $connection = $this->mysqli_connect();
        $INSERT_product_statement = "INSERT INTO products(name, description, price, date_listed, image_reference, product_type_id, user_id, quantity) 
                                     VALUES('$name', '$description', $price, '$date_listed', '$image_reference', $product_type_id, $user_id, $quantity)";
        mysqli_query($connection, $INSERT_product_statement);
        $SELECT_product_byName_STATEMENT = "SELECT * FROM products WHERE name = '$name'";
        $data = mysqli_query($connection, $SELECT_product_byName_STATEMENT);
        $product_assoc_array = mysqli_fetch_all($data, MYSQLI_ASSOC);
        $this->mysqli_disconnect($connection);
        return $product_assoc_array[0]['product_id'];
    }

    //Get all the usernames from the customers table:
    public function get_product_names($product_name){
        $connection = $this->mysqli_connect();
        $result = mysqli_query($connection, "SELECT count(*) AS count_all FROM products WHERE name='$product_name'");
        $row = mysqli_fetch_array($result);
        $count = intval($row['count_all']);
        $this->mysqli_disconnect($connection);
        return $count;
    }

    public function get_all_products(){
        $connection = $this->mysqli_connect();
        $SELECT_ALL_products_STATEMENT = "SELECT * FROM products";
        $data = mysqli_query($connection, $SELECT_ALL_products_STATEMENT);
        $products = mysqli_fetch_all($data, MYSQLI_ASSOC);
        $this->mysqli_disconnect($connection);
        return $products;
    }

    public function get_product_types(){
        $connection = $this->mysqli_connect();
        $SELECT_ALL_products_STATEMENT = "SELECT * FROM product_types";
        $data = mysqli_query($connection, $SELECT_ALL_products_STATEMENT);
        $products = mysqli_fetch_all($data, MYSQLI_ASSOC);
        $this->mysqli_disconnect($connection);
        return $products;
    }

    //Insert user into the database:
    public function insert_user($first_name, $username, $password, $last_name, $phone, $email, $address, $gender, $dob, $country, $post_code){
        $connection = $this->mysqli_connect();
        $INSERT_customer_STATEMENT = "INSERT INTO customers(username, password, first_name, last_name, phone, email, address, post_code, country, gender, dob, user_type_id)
                                      VALUES('$username', '$password', '$first_name', '$last_name', '$phone', '$email', '$address', '$post_code', '$country', $gender, '$dob', 1)";
        mysqli_query($connection, $INSERT_customer_STATEMENT);
        $this->mysqli_disconnect($connection);
    }

    //Get all the usernames from the customers table:
    public function get_usernames($username){
        $connection = $this->mysqli_connect();
        $result = mysqli_query($connection, "SELECT count(*) AS count_all FROM customers WHERE username='$username'");
        $row = mysqli_fetch_array($result);
        $count = intval($row['count_all']);
        $this->mysqli_disconnect($connection);
        return $count;
    }

    //Update a customers details:
    public function update_customers($user_id, $first_name, $last_name, $phone, $email, $address, $gender, $dob, $country, $post_code){
        $connection = $this->mysqli_connect();
        $UPDATE_customer_STATEMENT = "UPDATE customers SET first_name = '$first_name', last_name = '$last_name', phone = '$phone', 
                                             email = '$email', address = '$address', gender = $gender, dob='$dob', post_code = '$post_code',
                                             country = '$country'
                                      WHERE user_id='$user_id'";
        mysqli_query($connection, $UPDATE_customer_STATEMENT);
        $this->mysqli_disconnect($connection);
    }

    //Gets a full order by accessing orders by their group_id (puts all distinct 
    //item orders into 1 while keeping all of their details in the table).
    public function get_next_order_group(){
        $connection = $this->mysqli_connect();
        $data = mysqli_query($connection, $this->SELECT_heighest_order_group_STATEMENT);
        $max_array_assoc = mysqli_fetch_all($data, MYSQLI_ASSOC);
        $max_val = 1;
        if(!isset($max_array_assoc[0]['MAX(order_group_id)'])){
            $max_val = 1;
        }
        else{
            $max_val = intval($max_array_assoc[0]['MAX(order_group_id)']) + 1;
        }
        $this->mysqli_disconnect($connection);
        return $max_val;
    }

    //Get an individual products details by using the product_id:
    public function get_product($product_id){
        $connection = $this->mysqli_connect();
        $this->SELECT_single_product_STATEMENT = "SELECT * FROM products WHERE product_id = $product_id";
        $data= mysqli_query($connection, $this->SELECT_single_product_STATEMENT);
        $product_assoc_arr = mysqli_fetch_all($data, MYSQLI_ASSOC);
        $this->mysqli_disconnect($connection);
        return $product_assoc_arr;
    }

    /*
        Get a limited number of products by using the the limits created by the products page
        This is used for the pagination on the products page (products aren't all displayed on one page
        hey are displayed accross multiple pages, the selected page number helps determine which items
        select within a cetain specified limit at an offset related to the page number.
    */
    public function run_product_extra_limit_query($limit_lb, $total_itemsPerP, $_order_by_value){
        $connection = $this->mysqli_connect();
        $this->SELECT_limit_products_STATEMENT = "SELECT * FROM products WHERE product_type_id > 2 ORDER BY $_order_by_value LIMIT $limit_lb, $total_itemsPerP";
        $data= mysqli_query($connection, $this->SELECT_limit_products_STATEMENT);
        $limit_items_list_assoc_arr = mysqli_fetch_all($data, MYSQLI_ASSOC);
        $this->mysqli_disconnect($connection);
        return $limit_items_list_assoc_arr;
    }

    //Count the number of products (used for the number of pages to display):
    public function extra_row_count(){
        $connection = $this->mysqli_connect();
        $data = mysqli_query($connection, $this->SELECT_extra_products_STATEMENT);
        $extra_rows = mysqli_fetch_all($data, MYSQLI_ASSOC);
        $this->mysqli_disconnect($connection);
        return $extra_rows;
    }

    //Construct the object so it has the table name that you want to be querying:
    //Sets the select statement to get all the information from the SELECTED table
    public function __construct($table_name){
        $this->table = $table_name;
        $this->SELECT_ALL_STATEMENT = "SELECT * FROM $this->table";
    }

    //Function to connect to the mysqli database:
    /*
        The connect and disconnect to and from the database are put into
        functions, this is so that when running the functions that query
        the database, you don't have to re-write the connect and disconnect code again.
        Furthermore this is useful as it is bad practice to leave database connections
        open when not being used. This method gurantees that database
        connections are closed when each function is finished.

    */
    public function mysqli_connect(){
        $connection = mysqli_init();
        if (!$connection){
            echo "<p>Can't create the connection object </p>";
        }
        else{
            $connection = mysqli_init();
            mysqli_ssl_set($connection, NULL, NULL, NULL, '/public_html/sys_tests', NULL);
            mysqli_real_connect($connection, $this->host, $this->username, $this->password, $this->database, $this->port, NULL, MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT);
            return $connection;
        }
    }

    //Function to disconnect from the mysqli database:
    public function mysqli_disconnect($connection){
        mysqli_close($connection);
    }

    //Select all products:
    public function mysqli_select_all(){
        $connection = $this->mysqli_connect();
        //mysql_real_query returns if the query is possible or not (bool):
        $data = mysqli_query($connection, $this->SELECT_ALL_STATEMENT);
        $data_rows = mysqli_fetch_all($data, MYSQLI_ASSOC);
        $this->mysqli_disconnect($connection);
        return $data_rows;
    }

    //Select users: password, access level and username based on the given username:
    public function mysqli_select_userID_username_password($username){
        $connection = $this->mysqli_connect();
        $this->SELECT_username_password_STATEMENT = "SELECT user_id, username, password, user_type_id FROM customers WHERE username = '$username'";
        $data = mysqli_query($connection, $this->SELECT_username_password_STATEMENT);
        $username_password_assoc_arr = mysqli_fetch_all($data, MYSQLI_ASSOC);
        $this->mysqli_disconnect($connection);
        return $username_password_assoc_arr;
    }

    //Get all user details from a user_id:
    public function retrieve_user_details($user_id){
        $connection = $this->mysqli_connect();
        $this->SELECT_user_details_STATEMENT = "SELECT * FROM customers WHERE user_id = $user_id";
        $data = mysqli_query($connection, $this->SELECT_user_details_STATEMENT);
        $username_data_assoc_arr = mysqli_fetch_all($data, MYSQLI_ASSOC);
        $this->mysqli_disconnect($connection);
        return $username_data_assoc_arr;
    }

    public function delete_user_details($user_id){
        $connection = $this->mysqli_connect();
        $DELETE_user_details_STATEMENT = "DELETE FROM customers WHERE user_id = $user_id";
        mysqli_query($connection, $DELETE_user_details_STATEMENT);
        $this->mysqli_disconnect($connection);
    }

    //get all of the product information for the items in the basket:
    public function get_basket_items($items_list){
        $connection = $this->mysqli_connect();
        $items_list_str = implode(",", $items_list);
        $this->SELECT_basket_items_STATEMENT = "SELECT * FROM products WHERE product_id IN ($items_list_str)";
        $data = mysqli_query($connection, $this->SELECT_basket_items_STATEMENT);
        $basket_items_assoc_arr = mysqli_fetch_all($data, MYSQLI_ASSOC);
        $this->mysqli_disconnect($connection);
        return $basket_items_assoc_arr;
    }

    //Product limit query for the order by values:
    public function run_product_limit_query($limit_lb, $total_itemsPerP, $product_type, $order_by_value){
        $connection = $this->mysqli_connect();

        //Get the index out of the list item:
        $product_type = trim(strtolower($product_type));
        $product_index = array_search($product_type, $this->products_list) + 1;

        //Order by comes before limit in mysql (not other DBM's):
        $this->SELECT_limit_products_STATEMENT = "SELECT * FROM products WHERE product_type_id = $product_index ORDER BY $order_by_value LIMIT $limit_lb, $total_itemsPerP";
        $data= mysqli_query($connection, $this->SELECT_limit_products_STATEMENT);
        $limit_items_list_assoc_arr = mysqli_fetch_all($data, MYSQLI_ASSOC);
        $this->mysqli_disconnect($connection);
        return $limit_items_list_assoc_arr;
    }

    //Run the limit query for a product search:
    public function run_product_limit_query_search($limit_lb, $total_itemsPerP, $search_name){
        $connection = $this->mysqli_connect();

        //Order by comes before limit in mysql (not other DBM's):
        $this->SELECT_limit_products_STATEMENT = "SELECT * FROM products WHERE name LIKE '%$search_name%' LIMIT $limit_lb, $total_itemsPerP";
        $this->SELECT_limit_products_STATEMENT;
        $data= mysqli_query($connection, $this->SELECT_limit_products_STATEMENT);
        $limit_items_list_assoc_arr = mysqli_fetch_all($data, MYSQLI_ASSOC);
        $this->mysqli_disconnect($connection);
        return $limit_items_list_assoc_arr;
    }

    //Get number of rows from a product_type:
    public function get_num_rows($product_type){
        $connection = $this->mysqli_connect();

        //Get the index of the item out of the list:
        $product_type = trim(strtolower($product_type));
        $product_index = array_search($product_type, $this->products_list) + 1;

        $SELECT_products_rows = "SELECT COUNT(*) FROM products WHERE product_type_id = $product_index";
        $data = mysqli_query($connection, $SELECT_products_rows);
        $num_rows = mysqli_fetch_all($data, MYSQLI_ASSOC);
        $this->mysqli_disconnect($connection);
        return $num_rows;
    }

    //Get the number of rows for a search (used for limit query):
    public function get_num_rows_search($search_name){
        $connection = $this->mysqli_connect();

        $SELECT_products_rows = "SELECT COUNT(*) FROM products WHERE name LIKE '%$search_name%'";
        $data = mysqli_query($connection, $SELECT_products_rows);
        $num_rows = mysqli_fetch_all($data, MYSQLI_ASSOC);
        $this->mysqli_disconnect($connection);
        return $num_rows;
    }

    //Reduce the quantity of a product_id from an order:
    public function remove_quantity($product_id, $reduced_quantity){
        $connection = $this->mysqli_connect();
        $UPDATE_STATEMENT = "UPDATE products SET quantity = $reduced_quantity WHERE product_id = $product_id";
        $data = mysqli_query($connection, $UPDATE_STATEMENT);
        $this->mysqli_disconnect($connection);
    }

    //Delete a product from an order if enough of the quantity is reduced:
    public function delete_product($product_id){
        $connection = $this->mysqli_connect();

        //Disbale forigen key for delete:
        //Do this by altering the table:

        $DELETE_STATEMENT = "DELETE FROM products WHERE product_id = $product_id";
        $data = mysqli_query($connection, $DELETE_STATEMENT);

        //Enable the forigen key back:

        $this->mysqli_disconnect($connection);
    }


    //Add an order from a basket ordering:
    public function add_order_group($order_group, $user_id, $date_ordered){
        $connection = $this->mysqli_connect();
        $this->INSERT_order_STATEMENT = "INSERT INTO order_groups(order_group_id, date_ordered, user_id) VALUES($order_group, '$date_ordered', $user_id)";
        $data = mysqli_query($connection, $this->INSERT_order_STATEMENT);
        $this->mysqli_disconnect($connection);
    }

    public function add_order($order_group, $quantity, $product_id){
        $connection = $this->mysqli_connect();
        $this->INSERT_order_STATEMENT = "INSERT INTO orders(order_group_id, quantity, product_id) VALUES($order_group, $quantity, $product_id)";
        $data = mysqli_query($connection, $this->INSERT_order_STATEMENT);
        $this->mysqli_disconnect($connection);
    }
}


//Test 1 - does mysqli install??:
/*
function check_library(){
    if (!function_exists("mysqli_init") && !extension_loaded("mysqli")){
        echo "<p>You dont have mysqli </p>";
        return false;
    }
    else{
        echo "<p>You have mysql installed!!</p>";
        return true;
    }
}

$result1 = check_library();
echo "<p>The result was: " . serialize($result1) . "</p>";
?>
*/