function First_Name() {
    first = document.getElementById("firstName").value;
    regex = /^[A-Za-z' -]*$/;
      //check whether the first name has only allowed characters
      //We can compare "first" to a regular expression
    if (!regex.test(first)) {
        document.getElementById("error_firstName").innerHTML="First name should contain only letters, apostrophes, spaces and hyphens";
        check = 1;
        return false;
    //We also need to make sure first name is not empty
    } else if (first == "") {
        document.getElementById("error_firstName").innerHTML="Please enter a first name";
        check = 1;
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

//TODO
function DOB() {
    dob = document.getElementById("dateofbirth").value;
    return true;
}

function Weight() {
    //get weight from input, it will already be a number
    weight = document.getElementById("weight").value;
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

function validInfo() {
    test = 0;
    if (First_Name()) {
        test += 1;
    }
    if (Last_Name()) {
        test += 1;
    }
    if (DOB()) {
        test += 1;
    }
    if (Weight()) {
        test += 1;
    }
    if (test == 4) {
        return true;
    }
    document.getElementById("submit_check").innerHTML="FAILED - please fix errors";
    return false;
}