//Create function expression for current page

//Add event listeners to all the buttons:
//nextSPrevious_page will be used to handle them all to not repeat a large amount of code:
document.getElementById("next_button").addEventListener("click", nextSPrevious_page);
document.getElementById("previous_button").addEventListener("click", nextSPrevious_page);
document.getElementById("submit_button").addEventListener("click", nextSPrevious_page);

//Usefull for the global js document:
var form_ref = "form";

//Gets the value of the current page (stored inside a hidden input element and updated every time
//a new page is displayed)
var current_page_value = function () {return document.getElementById("current_page").value;}

//Gets a reference to the element with the ID value at the hidden current page element
//a.k.a gets a reference to the current page:
var current_page2 = function () {return document.getElementById(current_page_value());}


function get_page_data(current_page1 = current_page_value()){
    //Forms here aren't actually HTML forms, they are divs with a forms different inputs in them
    //being displayed as forms for effect (multi-forms)
    //Get the current form (div) and all the relevant data:
    //  - form id
    //  - a js reference to the form
    //  - the form number (for changing pages)
    //  - all the forms inputs
    //  - the js reference to the forms error_span element
    page_data = {
        page_id: current_page1,
        page_ref: document.getElementById(current_page1.page_id),
        page_number: parseInt(current_page1.substring(4, 6)),
        page_inputs: document.querySelectorAll("#" + current_page1 + " .create_account_inputs"),
        page_error_status: document.getElementById(current_page1 + "Error")
    }
    return page_data;
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

function show_submit_or_previous(form_num){
    //Depending on the form number being shown certain sets of buttons will become visible:
    //Submit and previous for the last form
    if (form_num > 3){
        next_btn = document.getElementById("next_button");
        next_btn.className = "create_forms hidden";
        submit_btn = document.getElementById("submit_button");
        submit_btn.className = "create_forms displayed";
        previous_btn = document.getElementById("previous_button");
        previous_btn.className = "create_forms displayed";
    }
    //Previous and next for all others but 1
    else if (form_num < 4){
        submit_btn = document.getElementById("submit_button");
        submit_btn.className = "create_forms hidden";
        next_btn = document.getElementById("next_button");
        next_btn.className = "create_forms displayed";
        previous_btn = document.getElementById("previous_button");
        previous_btn.className = "create_forms displayed";
        if (form_num < 2){
            previous_btn = document.getElementById("previous_button");
            previous_btn.className = "create_forms hidden";
        }
    }
}

//Verification functions:
function create_dob_input(){
    //Date format: YYYY/MM/DD
    var date_input = window.value;
    console.log(date_input.value);
    var is_date = true;
    var error_message = "Date is not in the right format";
    //Make sure the defining factor is correct:
    if (date_input.name == "create_dob_input"){
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

function create_phone_input(){
    var phone_input = window.value;
    var error_message = "Invalid phone number try again!";
    //Make sure the defining factor is correct:
    if (phone_input.name == "create_phone_input"){
        //Remove all spaces and create a regex to check the phone against
        phone_input = phone_input.value.replace(/\s/g, '');
        const phone_check = /^\d{11}$/;
        var is_phone = phone_check.test(phone_input);
        //Returns flase if there was an error with the message of the error that occured
        return [is_phone, error_message];
    }
    else return [true, error_message];
}

function create_post_code_input(){
    var post_code_input = window.value;
    var error_message = post_code_input.value + ": Is not a valid post code";
    //Make sure the defining factor is correct:
    if (post_code_input.name == "create_post_code_input"){
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

function create_email_input(){
    var email_input = window.value;
    var error_message = email_input.value + ": That is not a valid email, try again";
    //Make sure the defining factor is correct:
    if (email_input.name == "create_email_input"){
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


function create_password_input(){
    var password_input = window.value;
    let error_message = password_input.value + ": Is not a valid password, it must contain:\n(8+ symbols, 5+, letters, 1+ uppercase letter, 1+ lowercase letter, 1+ digits, 1+ sybols)";
    //Make sure the defining factor is correct:
    if (password_input.name == "create_password_input"){
        let is_password = true;
        password_input = password_input.value;
        if (password_input.replace(/\s/g, '').length != password_input.length){
            is_password = false;
            //checks the password has spaces
            error_message = password_input + ": Password can't have spaces!";
        }
        else if (password_input.length < 8){
            is_password = false;
            //checks the password length
            error_message = password_input + ": Password is too short (must be 8+ characters)";
        }
        else{
            //Creates a regex to check the password against:
            const check_password = /(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})/;
            if (!check_password.test(password_input)){
                is_password = false;
            }
        }
        //Returns flase if there was an error with the message of the error that occured
        return [is_password, error_message];
    }
    else {return [true, error_message];}
}


//Used to decrement the integer at the end of the current from id to access to next
//or the previous one.
var prev_next_page_object = {
    Previous: -1,
    Next: 1,
    Submit: 1
};

const function_list1 = ["create_password_input","create_email_input","create_post_code_input","create_phone_input","create_dob_input"];


var prev_next = "Next";

//prev_next is an event object
function nextSPrevious_page(prev_next){
    //get the current pages data
    cur_page_data = get_page_data();
    
    //Change current page value:
    //use the value of the button 
    //(next or previous to determine the new page id - will either be incremented or decremented by 1)
    //e.g. from3 will become form4 if the next button if pushed (3 + 4 - next is mapped to 1 in "prev_next_page_object")
    //form_ref = "form" - declared at the top of the page
    change_page = form_ref + ((parseInt(cur_page_data.page_number)) + parseInt(prev_next_page_object[prev_next.target.value]));
    document.getElementById("current_page").value = change_page;
    //Change the value of the hidden current page input and get that pages data
    change_page_data = get_page_data();

    //Validate form
    //Validate inputs arent null
    let checked_inputs = check_inputs(cur_page_data.page_inputs);

    if (parseInt(change_page_data.page_number) > parseInt(cur_page_data.page_number)){
        //Validation only occurs if the page were changing to has an id greater than the page we came from
        //This reduces the amount of code that will run and still ensures all data will still be validated before submission
        if (!checked_inputs[0]){
            cur_page_data.page_error_status.style = "visibility: inline";
            document.getElementById("current_page").value = cur_page_data.page_id;
            return null;
        }
        else{
            cur_page_data.page_error_status.style = "visibility: hidden";
            //Check inputs are valid
            for(var i = 0; i < cur_page_data.page_inputs.length; i++){
                window.value = cur_page_data.page_inputs[i];
                if (function_list1.includes(window.value.name)){
                    error_array = window[window.value.name]();
                    console.log(window.value);
                    console.log(error_array);
                    if (!error_array[0]){
                        alert(error_array[1]);
                        document.getElementById("current_page").value = cur_page_data.page_id;
                        return null;
                    }
                }

                var text_class = cur_page_data.page_inputs[i].className.split(" ");
                console.log(text_class);

                if (text_class[1] == "text_input"){
                    error_array = window[text_class[1]]();
                    console.log(error_array);
                    console.log("hi");
                    //The code uses the text_input class from elements to know which function to use on it.
                    if(!error_array[0]){
                        //If false is retuned alert the error message
                        alert(error_array[1]);
                        document.getElementById("current_page").value = cur_page_data.page_id;
                        return null;
                    }
                }
            }
            
            //If the error checks on page 4 are fine submit the form:
            if(cur_page_data.page_number > 3){
                document.getElementById("create_account_form").submit();
            }

            //Switch pages:
            //Change page 1 Visibility
            document.getElementById(cur_page_data.page_id).className = "create_forms hidden";
            //Change page 2 Visibility
            document.getElementById(change_page_data.page_id).className = "create_forms displayed";

            //Switch_buttons:
            show_submit_or_previous(change_page_data.page_number);
        }
    }

    else{
        //Switch pages:
        //Change page 1 Visibility
        document.getElementById(cur_page_data.page_id).className = "create_forms hidden";
        //Change page 2 Visibility
        document.getElementById(change_page_data.page_id).className = "create_forms displayed";
        //Switch_buttons:
        show_submit_or_previous(change_page_data.page_number);
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