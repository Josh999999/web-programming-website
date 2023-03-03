//Create function expression for current page

//Get the product inputs:
const product_inputs = document.querySelectorAll("#create_product_section input");

//Add event listeners to all the buttons:
document.getElementById("add_button_validate").addEventListener("click", validate_product);

//Reset the hidden attributes when the user leaves the page:
//Is leaving the page the same as reseting the page? - using onbeforeunload they are exactly the
//same as the browser doesn't recognise the difference between unloading the page from and link
//and unloading the page via reloading the page - they are both unloading:


document.addEventListener('DOMContentLoaded', function() {
    console.log(document.querySelectorAll("#create_product_section input"));
    document.querySelectorAll("#create_product_section span").forEach(input => {
        input.style.visibility = "hidden";
    })
});

//Checks any item in the text_input class to make sure they don't contain any special characters
function text_input(text_input){
    var is_text = true;
    var error_message = "No speical characters are allowed in this field";
    //Make sure the defining factor is correct:
    if (typeof text_input.value === 'string'){
        //No special characters regex:
        const text_special_chars_check = /^[A-Za-z0-9.();:,-]*$/;
        let is_text = text_special_chars_check.test(text_input.value.replace(/\s/g, ''));
        //If the input contains any special charactrs this will return false and the error message will
        //be displayed in an alert statement.
        return [is_text, error_message];
    }
    return [true, error_message];
}


//Checks inputs to make sure they're not null
function check_inputs(page_inputs1){
    for (var i = 0; i < page_inputs1.length; i++){
        if (page_inputs1[i].value == "" || page_inputs1[i].value == null){
            //returns the name of the null input so their error_span can be set to visible
            return [false, page_inputs1[i].name];
        }
    }
    return [true];
}

function check_price(price_element){
    let price = price_element.value;
    let price_check = /[^0-9.]/g;
    let is_price = price_check.test(price);
    if(is_price){
        return[false, "You need to enter a price"];
    }
    else if(parseFloat(price) < 0){
        return [false, "Price cannot be negative"];
    }
    else{
        return[true, "correct price type"];
    }
}

function validate_file(file){
    //Get the file name:
    let file_name = file.files[0].name;
    let file_extension = file_name.split('.');
    file_extension = file_extension[file_extension.length-1];
    let is_image = /(jpe?g|png|gif|bmp)$/i.test(file_extension);
    if (!is_image){
        return [false, "Please upload a valid image file"];
    }
    //Check file size - limit: 5000000bits:
    else if (file.size > 5000000){
        return [false, "File is too large"];
    }
    else{
        return [true, "correct file type"];
    }
}

function validate_product() {
    //Get all inputs:
    let is_null_inputs = check_inputs(product_inputs);
    if(!is_null_inputs[0]){
        let error_span = is_null_inputs[1] + "Error";
        document.getElementById(error_span).style.visibility = "visible";
    }
    else{
        let error = null;
        let causes_error = product_inputs.forEach(element => {
            if(element.type == "file"){
                error = validate_file(element);
            }
            else if(element.type == "number"){
                error = check_price(element);
            }
            else{
                error = text_input(element);
            }

            if(error[0] == false){
                alert(error[1]);
                throw 'break';
            }
        });
        if(!causes_error){
            document.getElementById("create_product_details").submit();
        }
    }
}