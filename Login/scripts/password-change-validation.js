// Objective: Validate the password change form
let currentPasswordInput = document.querySelector('#current-password');
let passwordInput = document.querySelector('#new-password');
let retypePasswordInput = document.querySelector('#confirm-password');

let currentPasswordError = document.createElement('p');
currentPasswordError.style.color = "#cc0000";
document.querySelectorAll(".change-group")[0].append(currentPasswordError);
currentPasswordError.style.marginTop = "8px";
//password error paraghaph
let passwordError = document.createElement('p');
passwordError.style.color = "#cc0000";
document.querySelectorAll(".change-group")[1].append(passwordError);
passwordError.style.marginTop = "8px";
//retype-password error paraghaph
let retypePasswordError = document.createElement('p');
retypePasswordError.style.color = "#cc0000";
document.querySelectorAll(".change-group")[2].append(retypePasswordError);
retypePasswordError.style.marginTop = "8px";



//define a global variables
let defaultMSg = "";


//method to validate current password
let currentPasswordEmpty = "X Current password should not be empty."
let currentPasswordErrorMsg = "X Current password should be at least 8 characters."
function validateCurrentPassword() {
    let currentPassword = currentPasswordInput.value;
    let regexp = /^.{2,}$/;
    if (regexp.test(currentPassword)) {
        currentPasswordInput.style.border = "1px solid #ebebe7";
        error = defaultMSg;
    }
    else if(currentPassword == "") {
        currentPasswordInput.style.border = "1px solid #cc0000";
        error = currentPasswordEmpty;
    }
    else {
        currentPasswordInput.style.border = "1px solid #cc0000";
        error = currentPasswordErrorMsg;
    }
    return error;
}

//method to validate password
let passwordEmpty = "X New password should not be empty."
let passwordErrorMsg = 
    "X New password should be at least 8 characters."
function validatePassword() {
    let password = passwordInput.value;
    let regexp = /^.{8,}$/;
    if (regexp.test(password)) {
        passwordInput.style.border = "1px solid #ebebe7";
        error = defaultMSg;
    }
    else if(password == "") {
        passwordInput.style.border = "1px solid #cc0000";
        error = passwordEmpty;
    }
    else {
        passwordInput.style.border = "1px solid #cc0000";
        error = passwordErrorMsg;
    }
    return error;
}

//method to validate retype-password
let retypePasswordEmpty = "X Please retype your new password."
let retypePasswordErrorMsg = "X Password does not match."
function validateRetypePassword() {
    let passwordRetype = retypePasswordInput.value;
    let password = passwordInput.value;

    if (password === "" && passwordRetype === "") {
        retypePasswordInput.style.border = "1px solid #cc0000";
        error = retypePasswordEmpty; 
    } 
    else if (passwordRetype === "") {
        retypePasswordInput.style.border = "1px solid #cc0000";
        error = retypePasswordEmpty; 
    } 
    else if (passwordRetype !== password) {
        retypePasswordInput.style.border = "1px solid #cc0000";
        error = retypePasswordErrorMsg;
    } 
    else {
        retypePasswordInput.style.border = "1px solid #ebebe7";
        error = ""; // Passwords match
    }
    return error;
}


function validate(){
    let valid = true;//global validation 
    if(validateCurrentPassword() !== defaultMSg) {
        currentPasswordError.textContent = validateCurrentPassword();
        valid = false;
    }
    //password onsubmit
    if(validatePassword() !== defaultMSg) {
        passwordError.textContent = validatePassword();
        valid = false;
    }

    //retype-password onsubmit
    if(validateRetypePassword() !== defaultMSg) {
        retypePasswordError.textContent = validateRetypePassword();
        valid = false;
    }

    return valid;
};

// event listner to empty the text input
const inputs = document.querySelectorAll("input");
function reserFormError() {
    currentPasswordError.textContent = defaultMSg;
    passwordError.textContent = defaultMSg;
    retypePasswordError.textContent = defaultMSg;
    for (let i = 0; i < inputs.length; i++) {
        inputs[i].style.border = "1px solid gainsboro";
        inputs[i].style.borderRadius = "4px";
    }
}

//add event listner to the First Name 

    //add event listner to the password
    currentPasswordInput.addEventListener("blur",()=>{ // arrow function
        let error = validateCurrentPassword();
        if(error == defaultMSg) {
            currentPasswordError.textContent = "";
        }
        else if(error == currentPasswordEmpty ) {
            currentPasswordError.textContent = currentPasswordEmpty;
        }
        else {
            currentPasswordError.textContent = currentPasswordErrorMsg;
        }
        })
    
        currentPasswordInput.addEventListener("input",()=>{ 
            currentPasswordError.textContent = defaultMSg;
        })

    //add event listner to the password
passwordInput.addEventListener("blur",()=>{ // arrow function
    let error = validatePassword();
    if(error == defaultMSg) {
        passwordError.textContent = "";
    }
    else if(error == passwordEmpty ) {
        passwordError.textContent = passwordEmpty;
    }
    else {
        passwordError.textContent = passwordErrorMsg;
    }
    })

passwordInput.addEventListener("input",()=>{ 
        passwordError.textContent = defaultMSg;
    })

//add event listner to the retype-password
retypePasswordInput.addEventListener("blur",()=>{ // arrow function
    let error = validateRetypePassword();
    if (error === defaultMSg){
        retypePasswordError.textContent = "";
    }
    else if(error === retypePasswordErrorMsg) {
        retypePasswordError.textContent = retypePasswordErrorMsg;
    }
    else if(error === retypePasswordEmpty ) {
        retypePasswordError.textContent = retypePasswordEmpty;
    }
    })

    retypePasswordInput.addEventListener("input",() => { 
        retypePasswordError.textContent = defaultMSg;
    })

    