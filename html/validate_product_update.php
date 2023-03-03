<?php
//Validate user is and admin:
//Stat the session:
session_start();
if(!isset($_SESSION['userID']) || empty($_SESSION['userID']) || !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true || $_SESSION['access_level'] != 2){
    header("location: home.php");
}
else{
    //create a session error for duplicate product names:
    $_SESSION['update_product_nameError'] = "";
    require_once('connection.php');
    $table_name = "products";
    $connection_obj = new connectionClass($table_name);
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        //Make sure the order errors are null so they aren't displayed when they're not true:
        //Error for order page
        $_POST['name_input_value'] = trim(htmlspecialchars($_POST['name_input_value']));
        $_POST['description_input_value'] = trim(htmlspecialchars($_POST['description_input_value']));
        $_POST['price_input_value'] = trim(htmlspecialchars($_POST['price_input_value']));
        $_POST['quantity_input_value'] = trim(htmlspecialchars($_POST['quantity_input_value']));
        $product_id = trim(htmlspecialchars($_POST['hidden_product_id']));

        //Make sure product name is unique:
        $count = $connection_obj->get_product_names($_POST['name_input_value']);
        if(!empty($count) && $count > 1){
            $_SESSION['update_product_nameError'] = "A product with this name already exists.";
            header("location: display_product.php?product_id=$product_id&view_products=1");
        }
        
        //The chosen file will go in here:
        $Chosen_file = "";
        if(isset($_FILES['product_image_input']) && !empty($_FILES['product_image_input'])){
            //create error for a file upload:
            $_SESSION['fileError'] = "";

            //Validate the file:
            //Declare variables for file upload:
            $directory = "../script/data/Images/";

            //Change the name of the file to add a date stamp to it:
            $temp = new DateTime();
            $temp = trim($temp->format('Y-m-d-H-i-s'));
            //Get the file type;
            $FileType = strtolower(pathinfo($_FILES['product_image_input']['name'],PATHINFO_EXTENSION));
            $FileName = $temp . "." . $FileType;
            $Chosen_file = $FileName;
            $target_file = $directory . $FileName;
            var_export($target_file);
            $target_file_tmp = $directory . basename($_FILES['product_image_input']['name']);

            //acceptable file types:
            $img_file_types = array('jpeg', 'png', 'gif', 'bmp', 'jpg');

            //Check file is an actual image:
            //tmp_name is the name of the temporary location where the file is stored on
            //the temporary folder on the server. name is the original file name.
            $is_file = getimagesize($_FILES['product_image_input']['tmp_name']);
            if(!$is_file){
                //Change the files name:
                $_SESSION['update_product_nameError'] = "This file is not an image";
            }
            if(file_exists($target_file_tmp) || file_exists($target_file)){
                $_SESSION['update_product_nameError'] = "This file has already been uploaded";
            }
            if($_FILES['product_image_input']["size"] > 500000000){
                $_SESSION['update_product_nameError'] = "Image size must be less than 500MB";
            }
            if(!in_array($FileType, $img_file_types)){
                $_SESSION['update_product_nameError'] = "File must be of type: image";
            }
            
            //Upload the image file:
            if(!move_uploaded_file($_FILES['product_image_input']['tmp_name'], $target_file)){
                $_SESSION['update_product_nameError'] = "Failed to upload file";
            }
            if(!empty($_SESSION['update_product_nameError'])){
                header("location: display_product.php?product_id=$product_id&view_products=1");
            }
            else{
                //If everything has gone though okay delete the old file:
                $Image_ref = $_POST['hidden_image_ref'];
                $FilePath = $directory + $Image_ref;
                $deletedFile = unlink($FilePath);
                if(!$deletedFile){
                    $_SESSION['update_product_nameError'] = "Failed to delete file";
                }
            }
        }
        else{
            //Where the correct file is stored:
            $Chosen_file = $_POST['hidden_image_ref'];
        }

        //Update product:
        $connection_obj->update_product($product_id, $_POST['name_input_value'], $_POST['description_input_value'], 
                                        $_POST['price_input_value'], $Chosen_file, $_POST['quantity_input_value']);
        header("location: display_product.php?product_id=$product_id&view_products=1");

    }
    else{
        header("location: add_product.php");
    }
}
?>