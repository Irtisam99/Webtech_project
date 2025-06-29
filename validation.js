document.getElementById("regForm").addEventListener("submit", validateForm);

function validateForm(e) {
    let hasError = false;

    document.querySelectorAll('.error').forEach(el => el.classList.remove('error'));
    document.querySelectorAll('.error-message').forEach(el => el.innerText = '');


    const nameField = document.getElementById("name");
    const name = nameField.value.trim();
    if (name === "") {
        nameField.classList.add('error');
        document.getElementById("nameError").innerText = "Name is required.";
        hasError = true;
    }  else if (!/^[A-Za-z\s]+$/.test(name)) {
        nameField.classList.add('error');
        document.getElementById("nameError").innerText = "Name must not contain numbers and special characters.";
        hasError = true;
    }

    
    const emailField = document.getElementById("email");
    const email = emailField.value.trim();
    const emailPattern = /^\d{2}-\d{5}-\d@student\.aiub\.edu$/;
    if (email === "") {
        emailField.classList.add('error');
        document.getElementById("emailError").innerText = "Email is required.";
        hasError = true;
    } else if (!emailPattern.test(email)) {
        emailField.classList.add('error');
        document.getElementById("emailError").innerText = "Email must follow the format: XX-XXXXX-X@student.aiub.edu";
        hasError = true;
    }


    const passwordField = document.getElementById("password");
    const password = passwordField.value;
    if (password === "") {
        passwordField.classList.add('error');
        document.getElementById("passwordError").innerText = "Password is required.";
        hasError = true;
    } else if (password.length < 8) {
        passwordField.classList.add('error');
        document.getElementById("passwordError").innerText = "Password must be at least 6 characters.";
        hasError = true;
    }

    
    const confirmField = document.getElementById("confirm_password");
    const confirmPassword = confirmField.value;
    if (confirmPassword === "") {
        confirmField.classList.add('error');
        document.getElementById("confirmPasswordError").innerText = "Please confirm your password.";
        hasError = true;
    } else if (password !== confirmPassword) {
        confirmField.classList.add('error');
        document.getElementById("confirmPasswordError").innerText = "Passwords do not match.";
        hasError = true;
    }

    
    const dobField = document.getElementById("dob");
    const dob = dobField.value;
    if (dob === "") {
        dobField.classList.add('error');
        document.getElementById("dobError").innerText = "Date of birth is required.";
        hasError = true;
    } else {
        const birthDate = new Date(dob);
        const age = new Date().getFullYear() - birthDate.getFullYear();
        if (age < 18) {
            dobField.classList.add('error');
            document.getElementById("dobError").innerText = "You must be at least 18 years old.";
            hasError = true;
        }
    }


    const countryField = document.getElementById("country");
    const country = countryField.value;
    if (country === "") {
        countryField.classList.add('error');
        document.getElementById("countryError").innerText = "Please select your country.";
        hasError = true;
    }

    
    const gender = document.querySelector('input[name="gender"]:checked');
    if (!gender) {
        document.querySelectorAll('input[name="gender"]').forEach(input => input.classList.add('error'));
        document.getElementById("genderError").innerText = "Please select a gender.";
        hasError = true;
    }

    
    const colorField = document.getElementById("color");
    const color = colorField.value;
    if (color === "") {
        colorField.classList.add('error');
        document.getElementById("colorError").innerText = "Please select a favorite color.";
        hasError = true;
    }

    
    const opinionField = document.getElementById("opinion");
    const opinion = opinionField.value.trim();
    if (opinion === "") {
        opinionField.classList.add('error');
        document.getElementById("opinionError").innerText = "Opinion is required.";
        hasError = true;
    } else {
        const wordCount = opinion.split(/\s+/).filter(w => w.length > 0).length;
        if (opinion.length > 200) {
            opinionField.classList.add('error');
            document.getElementById("opinionError").innerText = "Opinion must be less than 200 characters.";
            hasError = true;
        }
        if (wordCount < 10) {
            opinionField.classList.add('error');
            document.getElementById("opinionError").innerText = "Please write at least 10 words in the opinion.";
            hasError = true;
        }
    }

    
    const termsField = document.getElementById("agreeCheckbox");
    if (!termsField.checked) {
        document.getElementById("terms").classList.add('error');
        document.getElementById("termsError").innerText = "You must agree to the terms and conditions.";
        hasError = true;
    }

    if (hasError) {
        return false;
    } else {
    
        return true;
    }
}

document.getElementById('refreshGif').addEventListener('click', function() {
    var gif = document.getElementById('refreshGif');
    gif.src = "icon.gif";
    setTimeout(function() {
        gif.src = "icon.jpg";
    }, 2000);
});
