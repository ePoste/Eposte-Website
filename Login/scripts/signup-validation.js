let emailInput = document.querySelector("#email");
let passwordInput = document.querySelector('#pass') || document.querySelector('#password');
let retypePasswordInput = document.querySelector('#pass2');

let emailError = document.createElement('p');
emailError.style.color = "red";
document.querySelectorAll(".input-group")[0].append(emailError);
emailError.style.marginTop = "8px";

let passwordError = document.createElement('p');
passwordError.style.color = "red";
document.querySelectorAll(".input-group")[1].append(passwordError);
passwordError.style.marginTop = "8px";

let retypePasswordError = document.createElement('p');
if (retypePasswordInput) {
    retypePasswordError.style.color = "red";
    document.querySelectorAll(".input-group")[2].append(retypePasswordError);
    retypePasswordError.style.marginTop = "8px";
}

let defaultMSg = "";

let emailErrorMsg = "X Email format should be xyz@xyz.xyz.";
let emailEmpty = "X Email address should be non-empty";

function vaildateEmail() {
    let email = emailInput.value;
    let regexp = /^\S+@\S+\.\S+$/;
    if (regexp.test(email)) {
        emailInput.style.border = "1px solid gainsboro";
        emailInput.style.borderRadius = "4px";
        error = defaultMSg;
    } else if (email === "") {
        emailInput.style.border = "2px solid red";
        error = emailEmpty;
    } else {
        emailInput.style.border = "2px solid red";
        error = emailErrorMsg;
    }
    return error;
}

let passwordEmpty = "X Password should not be empty.";
let passwordErrorMsg = "X Password should be at least 8 characters.";

function validatePassword() {
    let password = passwordInput.value;
    let regexp = /^.{8,}$/;
    if (regexp.test(password)) {
        passwordInput.style.border = "1px solid gainsboro";
        passwordInput.style.borderRadius = "4px";
        error = defaultMSg;
    } else if (password === "") {
        passwordInput.style.border = "2px solid red";
        error = passwordEmpty;
    } else {
        passwordInput.style.border = "2px solid red";
        error = passwordErrorMsg;
    }
    return error;
}

let retypePasswordEmpty = "X Please retype password.";
let retypePasswordErrorMsg = "X Password does not match.";

function validateRetypePassword() {
    if (!retypePasswordInput) return defaultMSg;

    let passwordRetype = retypePasswordInput.value;
    let password = passwordInput.value;

    if (password === "" && passwordRetype === "") {
        retypePasswordInput.style.border = "2px solid red";
        error = retypePasswordEmpty;
    } else if (passwordRetype === "") {
        retypePasswordInput.style.border = "2px solid red";
        error = retypePasswordEmpty;
    } else if (passwordRetype !== password) {
        retypePasswordInput.style.border = "2px solid red";
        error = retypePasswordErrorMsg;
    } else {
        retypePasswordInput.style.border = "1px solid gainsboro";
        retypePasswordInput.style.borderRadius = "4px";
        error = defaultMSg;
    }
    return error;
}

function validate() {
    let valid = true;

    if (vaildateEmail() !== defaultMSg) {
        emailError.textContent = vaildateEmail();
        valid = false;
    }

    if (validatePassword() !== defaultMSg) {
        passwordError.textContent = validatePassword();
        valid = false;
    }

    if (retypePasswordInput && validateRetypePassword() !== defaultMSg) {
        retypePasswordError.textContent = validateRetypePassword();
        valid = false;
    }

    return valid;
}

function reserFormError() {
    emailError.textContent = defaultMSg;
    passwordError.textContent = defaultMSg;
    if (retypePasswordError) retypePasswordError.textContent = defaultMSg;

    const inputs = document.querySelectorAll("input");
    inputs.forEach(input => {
        input.style.border = "1px solid gainsboro";
        input.style.borderRadius = "4px";
    });
}
document.querySelector('form').addEventListener("reset", reserFormError);

// Live validation
emailInput.addEventListener("blur", () => {
    let error = vaildateEmail();
    emailError.textContent = error !== defaultMSg ? error : "";
});
emailInput.addEventListener("input", () => emailError.textContent = defaultMSg);

passwordInput.addEventListener("blur", () => {
    let error = validatePassword();
    passwordError.textContent = error !== defaultMSg ? error : "";
});
passwordInput.addEventListener("input", () => passwordError.textContent = defaultMSg);

if (retypePasswordInput) {
    retypePasswordInput.addEventListener("blur", () => {
        let error = validateRetypePassword();
        retypePasswordError.textContent = error !== defaultMSg ? error : "";
    });
    retypePasswordInput.addEventListener("input", () => retypePasswordError.textContent = defaultMSg);
}

// 🔐 SHA-256 Hashing Before Submit
async function hashPassword(password) {
    const encoder = new TextEncoder();
    const data = encoder.encode(password);
    const hashBuffer = await crypto.subtle.digest("SHA-256", data);
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
    return hashHex;
}

document.querySelector('form').addEventListener('submit', async function (e) {
    e.preventDefault();
    if (validate()) {
        const hashed = await hashPassword(passwordInput.value);
        passwordInput.value = hashed;
        if (retypePasswordInput) retypePasswordInput.value = hashed;
        this.submit();
    }
});
