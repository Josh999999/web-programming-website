<?php
//Validate user is and admin:
//Stat the session:
session_start();
if(!isset($_SESSION['userID']) || empty($_SESSION['userID']) || !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true || $_SESSION['access_level'] != 2){
    header("location: home.php");
}
else{
    //create a session error for duplicate product names:
    $_SESSION['product_nameError'] = "";
    require_once('connection.php');
    $table_name = "products";
    $connection_obj = new connectionClass($table_name);
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_FILES['create_product_image_input'])){
        //create error for a file upload:
        $_SESSION['fileError'] = "";

        //Make sure the order errors are null so they aren't displayed when they're not true:
        //Error for order page
        $_POST['create_product_name_input'] = trim(htmlspecialchars($_POST['create_product_name_input']));
        $_POST['create_product_description_input'] = trim(htmlspecialchars($_POST['create_product_description_input']));
        $_POST['create_product_price_input'] = trim(htmlspecialchars($_POST['create_product_price_input']));

        //Make sure product name is unique:
        if($connection_obj->get_product_names($_POST['create_product_name_input'])){
            $_SESSION['product_nameError'] = "A product with this name already exists.";
            header("location: add_product.php");
        }
        else{
            //Validate the file:
            //Declare variables for file upload:
            $directory = "../script/data/Images/";

            //Change the name of the file to add a date stamp to it:
            $temp = new DateTime();
            $temp = trim($temp->format('Y-m-d-H-i-s'));
            //Get the file type;
            $FileType = strtolower(pathinfo($_FILES['create_product_image_input']['name'],PATHINFO_EXTENSION));
            $FileName = $temp . "." . $FileType;
            $target_file = $directory . $FileName;
            var_export($target_file);
            $target_file_tmp = $directory . basename($_FILES['create_product_image_input']['name']);

            //acceptable file types:
            $img_file_types = array('jpeg', 'png', 'gif', 'bmp', 'jpg');

            //Check file is an actual image:
            //tmp_name is the name of the temporary location where the file is stored on
            //the temporary folder on the server. name is the original file name.
            $is_file = getimagesize($_FILES['create_product_image_input']['tmp_name']);
            if(!$is_file){
                //Change the files name:
                $_SESSION['product_nameError'] = "This file is not an image";
            }
            if(file_exists($target_file_tmp) || file_exists($target_file)){
                $_SESSION['product_nameError'] = "This file has already been uploaded";
            }
            if($_FILES['create_product_image_input']["size"] > 500000000){
                $_SESSION['product_nameError'] = "Image size must be less than 500MB";
            }
            if(!in_array($FileType, $img_file_types)){
                $_SESSION['product_nameError'] = "File must be of type: image";
            }
            if(!empty($_SESSION['product_nameError'])){
                header("location: add_product.php");
            }
            
            //Upload the image file:
            //Uploadting two files of the same name overwrites another:
            if(!move_uploaded_file($_FILES['create_product_image_input']['tmp_name'], $target_file)){
                $_SESSION['product_nameError'] = "Failed to upload file";
            }

            var_export($_POST);
            //Upload the product to the database:
            //produce the rest of the values:
            //Date listed
            $date_uploaded = new DateTime();
            $date_uploaded = $date_uploaded->format('Y-m-d');
            //Quantity:
            $quantity = 1;
            //userID:
            //$_SESSION['userID'];
            //Product type:
            $_POST['create_product_type_input'] = intval(trim(htmlspecialchars($_POST['create_product_type_input'])));

            //INSERT INTO products:
            $new_product_id = $connection_obj->add_product($_POST['create_product_name_input'], $_POST['create_product_description_input'],
                                        $_POST['create_product_price_input'], $date_uploaded, $FileName,
                                        $_POST['create_product_type_input'], $_SESSION['userID'], $quantity);
            header("location: display_product.php?product_id=$new_product_id&view_products=1");
        }
    }
    else{
        $_SESSION['product_nameError'] = "No file has been uploaded";
        header("location: add_product.php");
    }
}
?>