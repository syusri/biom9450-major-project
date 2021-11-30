function First_Name() {
    first = document.getElementById("firstName").value;
    regex = /^[A-Za-z' -]*$/;
      //check whether the first name has only allowed characters
      //We can compare "first" to a regular expression
    if (!regex.test(first)) {
        document.getElementById("error_firstName").innerHTML="First name should contain only letters, apostrophes, spaces and hyphens";
        return false;
    //We also need to make sure first name is not empty
    } else if (first == "") {
        document.getElementById("error_firstName").innerHTML="Please enter a first name";
        return false;
    //If we get to here, then the other tests have passed
    } else {
        document.getElementById("error_firstName").innerHTML="Success";
        return true;
    }
}
function Last_Name() {
    last = document.getElementById("lastName").value;
    regex = /^[A-Za-z' -]*$/;
      //check whether the last name has only allowed characters
      //We can compare "last" to a regular expression
    if (!regex.test(last)) {
        document.getElementById("error_lastName").innerHTML="Last name should contain only letters, apostrophes, spaces and hyphens";
        check = 1;
        return false;
    //We also need to make sure last name is not empty
    } else if (last == "") {
        document.getElementById("error_lastName").innerHTML="Please enter a last name";
        check = 1;
        return false;
    //If we get to here, then the other tests have passed
    } else {
        document.getElementById("error_lastName").innerHTML="Success";
        return true;
    }
}

function DOB() {
    dob = document.getElementById("dateofbirth").value;
    dob = new Date(dob);
        //patient must be older than 18
    date_compare = new Date("2003");
    //patient must be younger than 121
    date_compare_2 = new Date("1921");
    if (date_compare < dob) {
        document.getElementById("error_dateofbirth").innerHTML="Patient must be older than 18";
        return false;
    } 
    if (date_compare_2 > dob) {
        document.getElementById("error_dateofbirth").innerHTML="Patient must be younger than 121";
        return false;
    } 
    document.getElementById("error_dateofbirth").innerHTML="Success";
    return true;
}

function Weight() {
    //get weight from input, it will already be a number
    weight = document.getElementById("weight").value;
    if (weight == "") {
        document.getElementById("error_weight").innerHTML="Please enter correct weight";
        return false;
    }
    //check weight is at least 45kg and no more than 300kg
    if (weight < 45) {
        document.getElementById("error_weight").innerHTML="Please enter correct weight";
        return false;
    } else if (weight > 300) {
        document.getElementById("error_weight").innerHTML="Please enter correct weight";
        return false;
    } else {
        document.getElementById("error_weight").innerHTML="Success";
        return true;
    }
}

function First_Name_Contact() { //firstName_contact
    first = document.getElementById("firstName_contact").value;
    regex = /^[A-Za-z' -]*$/;
      //check whether the first name has only allowed characters
      //We can compare "first" to a regular expression
    if (!regex.test(first)) {
        document.getElementById("error_first_contact").innerHTML="First name should contain only letters, apostrophes, spaces and hyphens";
        return false;
    //We also need to make sure first name is not empty
    } else if (first == "") {
        document.getElementById("error_first_contact").innerHTML="Please enter a first name";
        return false;
    //If we get to here, then the other tests have passed
    } else {
        document.getElementById("error_first_contact").innerHTML="Success";
        return true;
    }
}

function Last_Name_Contact() { //lastName_contact
    last = document.getElementById("lastName_contact").value;
    regex = /^[A-Za-z' -]*$/;
      //check whether the last name has only allowed characters
      //We can compare "last" to a regular expression
    if (!regex.test(last)) {
        document.getElementById("error_last_contact").innerHTML="Last name should contain only letters, apostrophes, spaces and hyphens";
        return false;
    //We also need to make sure last name is not empty
    } else if (last == "") {
        document.getElementById("error_last_contact").innerHTML="Please enter a last name";
        return false;
    //If we get to here, then the other tests have passed
    } else {
        document.getElementById("error_lastName").innerHTML="Success";
        return true;
    }    
}

function Phone() { //phone
    phone = document.getElementById("phone").value;
    if (phone.length = 8) {
        document.getElementById("error_phone").innerHTML="Success";
        return true;
    } else {
        document.getElementById("error_phone").innerHTML="Please enter an 8 digit phone number";
        return false;
    }
}

function Relationship() { //relationship
    relationship = document.getElementById("relationship").value;
    regex = /^[A-Za-z' -]*$/;
      //check whether the last name has only allowed characters
      //We can compare "last" to a regular expression
    if (!regex.test(relationship)) {
        document.getElementById("error_relationship").innerHTML="Relationship should contain only letters, apostrophes, spaces and hyphens";
        return false;
    //We also need to make sure last name is not empty
    } else if (relationship == "") {
        document.getElementById("error_relationship").innerHTML="Please enter relationship";
        return false;
    //If we get to here, then the other tests have passed
    } else {
        document.getElementById("error_relationship").innerHTML="Success";
        return true;
    }    
}
function Medicare() { //medicare
    medicare = document.getElementById("medicare").value;
    if (medicare.length == 9) {
        document.getElementById("error_medicare").innerHTML="Success";
        return true;
    } else {
        document.getElementById("error_medicare").innerHTML="Medicare number is 9 digits";
        return false;
    }
}
function IRN() { //IRN
    irn = document.getElementById("IRN").value;
    if (irn == "") {
        document.getElementById("error_IRN").innerHTML="IRN is a number between 1 and 5";
        return false;
    }
    if (irn >= 1 || irn <= 5) {
        document.getElementById("error_IRN").innerHTML="Success";
        return true;
    } else {
        document.getElementById("error_IRN").innerHTML="IRN is a number between 1 and 5";
        return false;
    }
}
function Medicare_Expiry() { //expiry
    expiry = document.getElementById("expiry").value;
    if (expiry == "") {
        document.getElementById("error_expiry").innerHTML="Please enter a valid date";
        return false;
    }
    expiry = new Date(expiry);
    today = new Date();
    if (today >= expiry) {
        document.getElementById("error_expiry").innerHTML="This medicare card has expired";
        return false;
    } 
    if (today < expiry) {
        document.getElementById("error_expiry").innerHTML="Success";
        return true;
    }
    return false;
}

function validInfo() {
    var test = 0;
    if (First_Name() == true) {
        test = test + 1;
    }
    if (Last_Name() == true) {
        test = test + 1;
    }
    if (DOB() == true) {
        test = test + 1;
    }
    if (Weight() == true) {
        test = test + 1;
    }
    if (First_Name_Contact() == true) {
        test = test + 1;
    }
    if (Last_Name_Contact() == true) {
        test = test + 1;
    }
    if (Phone() == true) {
        test = test + 1;
    }
    if (Relationship() == true) {
        test = test + 1;
    }
    if (Medicare() == true) { 
        test = test + 1;
    }
    if (IRN() == true) {
        test = test + 1;
    }
    if (Medicare_Expiry() == true) {
        test = test + 1;
    }
    if (test == 11) {
        return true;
    } else {
        document.getElementById("submit_check").innerHTML="FAILED - please fix errors";
        return false;
    }
}