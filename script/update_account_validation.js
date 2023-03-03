//Create function expression for the input details

//Add event listener
document.getElementById("update_button_validate").addEventListener("click", check_update);

//Gets all inputs in the form:
var page_inputs = function () {return document.querySelectorAll("#account_section1 input");}


//Use "change" to detect when the input changes:
//Loop through all of them to add the event listeners
//.addEventListener("change", negative_inptSbmt_tampering);
let temp_list = page_inputs();
for (var i = 0; i < temp_list.length; i++){
    temp_list[i].addEventListener("change", negative_inptSbmt_tampering);
}

//Checks inputs to make sure they're not null
function check_inputs(page_inputs1){
    console.log(page_inputs1.length);
    for (var i = 0; i < page_inputs1.length; i++){
        if (page_inputs1[i].value == "" || page_inputs1[i].value == null){
            //returns the name of the null input so their error_span can be set to visible
            return [false, page_inputs1[i].name];
        }
    }
    return [true];
}

//Checks any item in the text_input class to make sure they don't contain any special characters
function text_input(){
    var is_text = true;
    var text_input = window.value
    var error_message = "No speical characters are allowed in this field";
    //Make sure the defining factor is correct:
    if (typeof text_input.value === 'string'){
        //No special characters regex:
        const text_special_chars_check = /^[A-Za-z0-9]*$/;
        is_text = text_special_chars_check.test(text_input.value.replace(/\s/g, ''));
        //If the input contains any special charactrs this will return false and the error message will
        //be displayed in an alert statement.
        return [is_text, error_message];
    }
    return [true, error_message];
}


//Verification functions:
function dob_input(){
    //Date format: YYYY/MM/DD
    var date_input = window.value;
    console.log(date_input.value);
    var is_date = true;
    var error_message = "Date is not in the right format";
    //Make sure the defining factor is correct:
    if (date_input.name == "dob_input"){
        //Remove all spaces and create a regex to check the date against
        date_input = date_input.value.replace(/\s/g, '');
        const date_check = /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/;
        if (date_check.test(date_input)){
            //If it matches the format of the regex continue else outputs false and the error message:
            //figures out which sperator is being used on the date and splits the string by it:
            let sep1 = RegExp("//");
            let sep2 = RegExp("\-");
            let sep3 = RegExp("\.");
            var date = "";
            if (sep1.test(date_input)){
                date = date_input.split('/');
            }
            if (sep2.test(date_input)){
                date = date_input.split('-');
            }
            if (sep3.test(date_input)){
                date = date_input.split('.');
            }

            console.log(date);

            //Puts the array values into varaibles and turns them to integers
            const yyyy = parseInt(date[0]);
            console.log(yyyy);
            const mm = parseInt(date[1]);
            const dd = parseInt(date[2]);
            //Lists of num of days in each month (represented by index value + 1)
            const mm_days_list = [31,28,31,30,31,30,31,31,30,31,30,31];
            
            //Check for leep year to increase feb (1 + 1 / 2) days of year by 1 (28 + 1/ 29)
            if (!(yyyy % 4) && (yyyy%100)){
                mm_days_list[1] += 1;
            }

            //Check to make sure they are of age (also checks the year integer)
            if (yyyy < 1990 || yyyy > 2003){
                error_message = yyyy + ": is not the correct boundary (must be between and 1990 and 2003)";
                is_date = false;
            }
            //Check the month integer is correct
            else if (mm > 13 || mm < 1){
                error_message = mm + ": is not a correct month";
                is_date = false;
            }
            //Check to make sure the right num of days has been inputted for the month
            //decrement mm to match the index for it
            else if (dd < 1 || dd > mm_days_list[mm-1]){
                error_message = dd + ": There are this many days in month: " + mm;
                is_date = false;
            }
            //Returns flase if there was an error with the message of the error that occured
            return [is_date, error_message];
        }
        else {return [false, error_message];}
    }
    else return [is_date, error_message];
}


function phone_input(){
    var phone_input = window.value;
    var error_message = "Invalid phone number try again!";
    //Make sure the defining factor is correct:
    if (phone_input.name == "phone_input"){
        //Remove all spaces and create a regex to check the phone against
        phone_input = phone_input.value.replace(/\s/g, '');
        const phone_check = /^\d{11}$/;
        var is_phone = phone_check.test(phone_input);
        //Returns flase if there was an error with the message of the error that occured
        return [is_phone, error_message];
    }
    else return [true, error_message];
}

function post_code_input(){
    var post_code_input = window.value;
    var error_message = post_code_input.value + ": Is not a valid post code";
    //Make sure the defining factor is correct:
    if (post_code_input.name == "post_code_input"){
        var is_post_code = true;
        //Converting the string to uppercase to assit the regex check
        post_code_input = post_code_input.value.toUpperCase();
        //Remove all spaces and create a regex to check the post_code against
        post_code_input = post_code_input.replace(/\s/g, '');
        const post_code_check = /[A-Z]{1,2}[0-9]{1,2} ?[0-9][A-Z]{2}/i;
        is_post_code = post_code_check.test(post_code_input);
        //Returns flase if there was an error with the message of the error that occured
        return [is_post_code, error_message];
    }
    else {return [true, error_message];}
}

function email_input(){
    var email_input = window.value;
    var error_message = email_input.value + ": That is not a valid email, try again";
    //Make sure the defining factor is correct:
    if (email_input.name == "email_input"){
        var is_email = true;
        //Remove all spaces and create a regex to check the email against
        email_input = email_input.value.replace(/\s/g, '');
        const email_check = /^\w+([.-]?\w+)@\w+([.-]?\w+)(.\w{2,3})+$/;
        is_email = email_check.test(email_input);
        //Returns flase if there was an error with the message of the error that occured
        return [is_email, error_message];
    }
    else {return [true, error_message];}
}

//Password changing doesn't exist yet:
/*
function password_input(){
    var password_input = window.value;
    var error_message = password_input.value + ": Is not a valid password, it must contain:\n(8+ symbols, 5+, letters, 1+ uppercase letter, 1+ lowercase letter, 1+ digits, 1+ sybols)";
    if (password_input.name == "password_input"){
        var is_password = true;
        password_input = password_input.value;
        if (password_input.replace(/\s/g, '').length != password_input.length){
            is_password = false;
            error_message = password_input + ": Password can't have spaces!";
        }
        else if (password_input.length < 8){
            is_password = false;
            error_message = password_input + ": Password is too short (must be 8+ characters)";
        }
        else{
            const check_password = /(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})/;
            if (!check_password.test(password_input)){
                is_password = false;
            }
        }
        return [is_password, error_message];
    }
    else {return [true, error_message];}
}
*/

//Code a quick function so that if there is a change in the 
//text boxes it will remove the submit button from the page:
function negative_inptSbmt_tampering(){
    //Switch buttons:
    if (document.getElementById("save_changes_button").style.visibility == "visible")
        //only triggers when the submit button is visible (clickable) so this doesn't occur
        //Every time a text box is changed:
        document.getElementById("save_changes_button").style.visibility = "hidden";
        document.getElementById("update_button_validate").style.visibility = "visible"; 
}


//Contains the list of all the functions used on this page:
const function_list1 = ["password_input","email_input","post_code_input","phone_input","dob_input"];

//prev_next is an event object
function check_update(){
    //Make the last error disapear - last error stored in local storage:
    var keys = Object.keys(localStorage);
    if(keys.includes("last_error_element")){
        //If there was an error last time turn it to hidden:
        document.getElementById(localStorage.getItem("last_error_element")).style.visibility = "hidden";
    }

    //Get all the inputs
    var inputs_array = page_inputs();
    
    //check for null fields:
    var error_array = check_inputs(inputs_array);
    if (!error_array[0]){
        //If there is an error make the span from the inputs where the error came from visible:
        var error_location_str = error_array[1] + "Error";
        //Set localStorge "last_error_element" attribute so we know which elements error_span is being displayed
        //if we leave the page
        localStorage.setItem("last_error_element", error_location_str);
        //turn the elements error_span to true (error_spans on the form are only to display the null errors)
        document.getElementById(error_location_str).style.visibility = "visible";
    }
    else{
        //If not continue to the main checks:
        for(var i = 0; i < inputs_array.length; i++){
            //Puts the element into the window to be accessed globaly
            window.value = inputs_array[i];
            if (function_list1.includes(window.value.name)){
                //Names of each element to be specifically checked are stored as functions.
                //The code uses the name of the element to know which function to use on it.
                error_array = window[window.value.name]();
                if(!error_array[0]){
                    //If false is retuned alert the error message
                    alert(error_array[1]);
                    document.getElementById("save_changes_button").style.visibility = "hidden";
                    return null;
                }
            }

            if (inputs_array[i].className == "text_input"){
                error_array = window[window.value.className]();
                //The code uses the text_input class from elements to know which function to use on it.
                if(!error_array[0]){
                    //If false is retuned alert the error message
                    alert(error_array[1]);
                    document.getElementById("save_changes_button").style.visibility = "hidden";
                    return null;
                }
            }
        }

        //If there are no errors show the submit button:
        //Switch buttons:
        document.getElementById("update_button_validate").style.visibility = "hidden"; 
        document.getElementById("save_changes_button").style.visibility = "visible";
    }
}


/*
//test1 - Works: toUpperCase disregards numbers!!
var string = "Upper1"
console.log(string.toUpperCase());
*/

/*
Make sure to add this later when the database is working, you don't want 2 users
with the same name, other wise they will both have access to a single account.
function check_username(username_input){

}
*/