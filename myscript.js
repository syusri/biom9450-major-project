// JS Script for validation

function validEmail() {
    let new_email = document.getElementById("email_address"); 
	let re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/
	let result = re.test(new_email.value); 
	console.log(result);
	
	if(result) {
		document.getElementById("email_result").innerHTML = "No errors";
		document.getElementById("email_result").style.color = "#17BF41";
		return true;
	} else {
		document.getElementById("email_result").innerHTML = "Email Address is invalid";
		document.getElementById("email_result").style.color = "red";
		return false;
	}
}

function validPassword() {
	let new_password = document.getElementById("password"); 
	let re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;

	if(new_password.value.match(re)) {
		document.getElementById("password_result").innerHTML = "No errors";
		document.getElementById("password_result").style.color = "#17BF41";
		return true;
	} else {
		document.getElementById("password_result").innerHTML = "Password must contain at least 8 characters and include uppercase, lowercase and numbers!";
		document.getElementById("password_result").style.color = "red";
		return false;
	}
}

function validPasswordMatch() {
	let new_password = document.getElementById("password"); 
	let new_re_password = document.getElementById("re_password"); 

	if(new_password.value != new_re_password.value) {
		document.getElementById("password_match_result").innerHTML = "Passwords must match";
		document.getElementById("password_match_result").style.color = "red";
		return false;
	} else {
		document.getElementById("password_match_result").innerHTML = "No errors";
		document.getElementById("password_match_result").style.color = "#17BF41";
		return true;
	}
}

function validFName() {
	let new_fname = document.getElementById("fname"); 
	let re = /^[ a-zA-Z\-\'’']+$/
	let result = re.test(new_fname.value); 
	console.log(result);
	
	if(result) {
		document.getElementById("fname_result").innerHTML = "No errors";
		document.getElementById("fname_result").style.color = "#17BF41";
		return true;
	} else {
		document.getElementById("fname_result").innerHTML = "First name should contain only letters, apostrophes, spaces and hyphens";
		document.getElementById("fname_result").style.color = "red";
		return false;
	}
}

function validLName() {
	let new_lname = document.getElementById("lname"); 
	let re = /^[ a-zA-Z\-\'’']+$/
	let result = re.test(new_lname.value); 
	console.log(result);
	
	if(result) {
		document.getElementById("lname_result").innerHTML = "No errors";
		document.getElementById("lname_result").style.color = "#17BF41";
		return true;
	} else {
		document.getElementById("lname_result").innerHTML = "Last name should contain only letters, apostrophes, spaces and hyphens";
		document.getElementById("lname_result").style.color = "red";
		return false;
	}
}

function validInfo()
{
    var valid = true;
    //call email function
    valid = valid && validEmail();

    //call password function
    valid = valid && validPassword();
	valid = valid && validPasswordMatch();

    //call first name function
    valid = valid && validFName();

    //call last name function
    valid = valid && validLName();

    //call dob function
    //valid = valid && validDateOfBirth();

	//call gender function
	//valid = valid && validGender();

	if(valid) {
		return valid;
	} else {
		window.alert("Some fields contain errors, please fix and resubmit");
		return valid;
	}

}