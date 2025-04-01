// Select common input fields (only if they exist)
let emailInput = document.querySelector("#email");
let passwordInput = document.querySelector('#pass') || document.querySelector('#password');
let retypePasswordInput = document.querySelector('#pass2');

// Create error message elements
let emailError = document.createElement('p');
emailError.style.color = "red";
let passwordError = document.createElement('p');
passwordError.style.color = "red";
let retypePasswordError = document.createElement('p');
retypePasswordError.style.color = "red";

// Append error paragraphs to corresponding input groups if they exist
if (document.querySelectorAll(".input-group")[0]) document.querySelectorAll(".input-group")[0].append(emailError);
if (document.querySelectorAll(".input-group")[1]) document.querySelectorAll(".input-group")[1].append(passwordError);
if (document.querySelectorAll(".input-group")[2] && retypePasswordInput) document.querySelectorAll(".input-group")[2].append(retypePasswordError);

emailError.style.marginTop = passwordError.style.marginTop = retypePasswordError.style.marginTop = "8px";

let defaultMSg = "";

// ------------------ Validation Functions ------------------

// Email validation
function validateEmail() {
    let email = emailInput.value;
    let regexp = /^\S+@\S+\.\S+$/;
    if (regexp.test(email)) {
        emailInput.style.border = "1px solid gainsboro";
        emailInput.style.borderRadius = "4px";
        return defaultMSg;
    } else if (email === "") {
        emailInput.style.border = "2px solid red";
        return "X Email address should be non-empty";
    } else {
        emailInput.style.border = "2px solid red";
        return "X Email format should be xyz@xyz.xyz.";
    }
}

// Password validation
function validatePassword() {
    let password = passwordInput.value;
    let regexp = /^.{8,}$/;
    if (regexp.test(password)) {
        passwordInput.style.border = "1px solid gainsboro";
        passwordInput.style.borderRadius = "4px";
        return defaultMSg;
    } else if (password === "") {
        passwordInput.style.border = "2px solid red";
        return "X Password should not be empty.";
    } else {
        passwordInput.style.border = "2px solid red";
        return "X Password should be at least 8 characters.";
    }
}

// Confirm password validation
function validateRetypePassword() {
    if (!retypePasswordInput) return defaultMSg; // Skip if not a signup form

    let passwordRetype = retypePasswordInput.value;
    let password = passwordInput.value;

    if (password === "" && passwordRetype === "") {
        retypePasswordInput.style.border = "2px solid red";
        return "X Please retype password.";
    } else if (passwordRetype === "") {
        retypePasswordInput.style.border = "2px solid red";
        return "X Please retype password.";
    } else if (passwordRetype !== password) {
        retypePasswordInput.style.border = "2px solid red";
        return "X Password does not match.";
    } else {
        retypePasswordInput.style.border = "1px solid gainsboro";
        retypePasswordInput.style.borderRadius = "4px";
        return defaultMSg;
    }
}

// Reset function
function resetFormError() {
    if (emailError) emailError.textContent = defaultMSg;
    if (passwordError) passwordError.textContent = defaultMSg;
    if (retypePasswordError) retypePasswordError.textContent = defaultMSg;

    const inputs = document.querySelectorAll("input");
    inputs.forEach(input => {
        input.style.border = "1px solid gainsboro";
        input.style.borderRadius = "4px";
    });
}
document.querySelector('form').addEventListener("reset", resetFormError);

// ------------------ Field Event Listeners ------------------

// Email
if (emailInput) {
    emailInput.addEventListener("blur", () => {
        emailError.textContent = validateEmail();
    });
    emailInput.addEventListener("input", () => {
        emailError.textContent = defaultMSg;
    });
}

// Password
if (passwordInput) {
    passwordInput.addEventListener("blur", () => {
        passwordError.textContent = validatePassword();
    });
    passwordInput.addEventListener("input", () => {
        passwordError.textContent = defaultMSg;
    });
}

// Confirm Password
if (retypePasswordInput) {
    retypePasswordInput.addEventListener("blur", () => {
        retypePasswordError.textContent = validateRetypePassword();
    });
    retypePasswordInput.addEventListener("input", () => {
        retypePasswordError.textContent = defaultMSg;
    });
}

// ------------------ SHA-256 Hashing ------------------
async function hashPassword(password) {
    const encoder = new TextEncoder();
    const data = encoder.encode(password);
    const hashBuffer = await crypto.subtle.digest("SHA-256", data);
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    return hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
}

// ------------------ Submit Handler ------------------
document.querySelector('form').addEventListener('submit', async function (e) {
    e.preventDefault();

    const emailValid = validateEmail();
    const passwordValid = validatePassword();
    const retypeValid = validateRetypePassword();

    if (emailValid !== defaultMSg) emailError.textContent = emailValid;
    if (passwordValid !== defaultMSg) passwordError.textContent = passwordValid;
    if (retypeValid !== defaultMSg) retypePasswordError.textContent = retypeValid;

    if (emailValid !== defaultMSg || passwordValid !== defaultMSg || retypeValid !== defaultMSg) {
        return false; // Don't submit if validation fails
    }

    const hashed = await hashPassword(passwordInput.value);
    passwordInput.value = hashed;
    if (retypePasswordInput) retypePasswordInput.value = hashed;

    this.submit(); // Submit form after hashing
});
