// UserFormBuilder.js
// Content Security Policy (CSP)
const meta = document.createElement('meta');
meta.httpEquiv = 'Content-Security-Policy';
meta.content = "default-src 'self'";
document.head.appendChild(meta);

// Function to sanitize input and prevent XSS attacks
function sanitizeInput(input) {
    return input.replace(/</g, '&lt;').replace(/>/g, '&gt;');
}

// Function to validate date format
function isValidDate(dateString) {
    const regex = /^\d{2}\/\d{2}\/\d{4}$/;
    if (!regex.test(dateString)) return false;

    const parts = dateString.split('/');
    const day = parseInt(parts[0], 10);
    const month = parseInt(parts[1], 10);
    const year = parseInt(parts[2], 10);

    if (year < 1000 || year > 3000 || month < 1 || month > 12 || day < 1 || day > 31) {
        return false;
    }

    return true;
}

// Function to validate username format
function isValidUsername(username) {
    // Allow alphanumeric characters and hyphens
    const regex = /^[a-zA-Z0-9-]{5,50}$/;
    return regex.test(username);
}

// Function to validate password format
function isValidPassword(password) {
    // Require 1 upper, 1 lower, 1 special character, and at least 8 characters
    const regex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*]).{8,}$/;
    return regex.test(password);
}

// Function to validate education format
function isValidEducation(education) {
    // Allow only specified education levels
    const allowedEducations = ["High School", "Bachelor's Degree", "Master's Degree", "Doctorate"];
    return allowedEducations.includes(education);
}

// Function to validate phone number format
function isValidPhoneNumber(phoneNumber) {
    // Allow UK, Ireland, and US phone number formats
    const regexUK = /^(?:\+44|0)\d{10}$/;
    const regexIreland = /^(\+353|0)\d{9}$/;
    const regexUS = /^\+1\d{10}$/;
    return regexUK.test(phoneNumber) || regexIreland.test(phoneNumber) || regexUS.test(phoneNumber);
}

// Function to validate age based on date of birth
function isValidAge(dob) {
    const today = new Date();
    const birthDate = new Date(dob);
    const age = today.getFullYear() - birthDate.getFullYear();
    const monthDiff = today.getMonth() - birthDate.getMonth();

    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
        return age - 1;
    }

    return age;
}

// Function to validate country of residence
function isValidCountryOfResidence(cor) {
    // Allow only specified countries
    const allowedCountries = ["US", "UK", "IR"];
    return allowedCountries.includes(cor);
}

// Function to validate street format
function isValidStreet(street) {
    // Allow up to 250 characters
    return street.length <= 250;
}

// Function to validate number format
function isValidNumber(number) {
    // Check if it's not required
    if (!number.trim()) {
        return true;
    }

    // Check if it's not longer than 10 characters
    if (number.length > 10) {
        return false;
    }

    // Allow only numbers and letters
    const regex = /^[a-zA-Z0-9]+$/;
    return regex.test(number);
}

// Function to validate postcode format based on country of residence
function isValidPostcode(postcode, cor) {
    switch (cor) {
        case "UK":
            // UK postcode validation
            const regexUK = /^[A-Z0-9]{2,4}\s?\d[A-Z]{2}$/i;
            return regexUK.test(postcode);
        case "US":
            // US postcode validation
            const regexUS = /^\d{5}(?:-\d{4})?$/;
            return regexUS.test(postcode);
        case "IR":
            // Ireland postcode (Eircode) validation
            const regexIreland = /^[A-Z0-9]{3}\s?[A-Z0-9]{4}$/i;
            return regexIreland.test(postcode);
        default:
            return false;
    }
}

// Function to validate JSON preferences format
async function validateJSONWithJSONLint(json) {
    try {
        const response = await fetch('https://jsonlint.com/validate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ json }),
        });

        const result = await response.json();

        if (result && result.error) {
            console.error('JSON validation error:', result.error);
            return false;
        }

        return true;
    } catch (error) {
        console.error('Error validating JSON:', error);
        return false;
    }
}

// Function to validate JSON preferences format
async function isValidJSON(json) {
    try {
        // Validate JSON using external API
        const isJSONValid = await validateJSONWithJSONLint(json);

        if (!isJSONValid) {
            alert('Invalid JSON preferences. Please enter valid JSON.');
            return false;
        }

        // Add additional validation for JSON structure if needed
        const preferences = JSON.parse(json);
        // Add additional validation for JSON structure if needed

        return true;
    } catch (error) {
        console.error('Error validating JSON:', error);
        return false;
    }
}

// Validate form on the client side
function validateForm() {
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const retypePasswordInput = document.getElementById('retypePassword');
    const educationInput = document.getElementById('education');
    const phoneNumberInput = document.getElementById('phoneNumber');
    const dobInput = document.getElementById('dob');
    const corInput = document.getElementById('corSelect'); // Update the id here
    const streetInput = document.getElementById('street');
    const numberInput = document.getElementById('number');
    const postcodeInput = document.getElementById('postcode');
    const jsonInput = document.getElementById('json');
    const hiddenFields = document.getElementById('hiddenFields');

    // Sanitize input to prevent XSS
    usernameInput.value = sanitizeInput(usernameInput.value);
    passwordInput.value = sanitizeInput(passwordInput.value);
    retypePasswordInput.value = sanitizeInput(retypePasswordInput.value);
    educationInput.value = sanitizeInput(educationInput.value);
    phoneNumberInput.value = sanitizeInput(phoneNumberInput.value);
    dobInput.value = sanitizeInput(dobInput.value);
    corInput.value = sanitizeInput(corInput.value);
    streetInput.value = sanitizeInput(streetInput.value);
    numberInput.value = sanitizeInput(numberInput.value);
    postcodeInput.value = sanitizeInput(postcodeInput.value);
    jsonInput.value = sanitizeInput(jsonInput.value);

    // Validate username format
    if (!isValidUsername(usernameInput.value)) {
        alert('Invalid username. Please enter a valid username.');
        return false;
    }

    // Validate password format
    if (!isValidPassword(passwordInput.value)) {
        alert('Invalid password. Please enter a password with at least 8 characters, including one uppercase, one lowercase, and one special character.');
        return false;
    }

    // Validate retype password
    if (passwordInput.value !== retypePasswordInput.value) {
        alert('Passwords do not match.');
        return false;
    }

    // Validate education format
    if (!isValidEducation(educationInput.value)) {
        alert('Invalid education. Please select a valid education level.');
        return false;
    }

    // Validate phone number format
    if (!isValidPhoneNumber(phoneNumberInput.value)) {
        alert('Invalid phone number. Please enter a valid phone number.');
        return false;
    }

    // Validate date format and age
    if (!isValidDate(dobInput.value) || isValidAge(dobInput.value) < 18) {
        alert('Invalid Date of Birth. Please use the format DD/MM/YYYY and ensure you are at least 18 years old.');
        return false;
    }

    // Validate country of residence
    if (!isValidCountryOfResidence(corInput.value)) {
        alert('Invalid Country of Residence. Please select a valid country.');
        return false;
    }

    // Validate street format (only if country of residence is provided)
    if (corInput.value && !isValidStreet(streetInput.value)) {
        alert('Invalid street. Please enter a valid street (up to 250 characters).');
        return false;
    }

    // Validate number format
    if (!isValidNumber(numberInput.value)) {
        alert('Invalid number. Please enter a valid number.');
        return false;
    }

    // Validate postcode format based on country of residence
    if (!isValidPostcode(postcodeInput.value, corInput.value)) {
        alert('Invalid postcode. Please enter a valid postcode based on your country of residence.');
        return false;
    }

    // Validate JSON preferences format
    if (!await isValidJSON(jsonInput.value)) {
        return false;
    }

    return true;
}

// Add an event listener to the country of residence select
document.getElementById('corSelect').addEventListener('change', toggleHiddenFields);

// Function to toggle the visibility of the hidden fields
function toggleHiddenFields() {
    const hiddenFields = document.getElementById('hiddenFields');
    const corInput = document.getElementById('corSelect');

    // Show the hidden fields only if a country is selected
    hiddenFields.style.display = corInput.value !== '' ? 'block' : 'none';
}

// Initialize the state based on the initial value of the country select
toggleHiddenFields();

// Add form submit event listener
const form = document.getElementById('registrationForm');
form.addEventListener('submit', async function (event) {
    event.preventDefault();
    if (await validateForm()) {
        form.submit(); // Proceed with form submission
    }
});
