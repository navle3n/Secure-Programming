(function () {
    const meta = document.createElement('meta');
    meta.httpEquiv = 'Content-Security-Policy';
    meta.content = "default-src 'self'";
    document.head.appendChild(meta);
  
    function showError(message) {
        const errorMessageDiv = document.getElementById('errorMessage');
        errorMessageDiv.textContent = message;
    }
    
    function sanitizeInput(input) {
      const doc = new DOMParser().parseFromString(input, 'text/html');
      return doc.body.textContent || "";
    }
  
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
  
    function isValidUsername(username) {
      const regex = /^[a-zA-Z0-9-]{5,50}$/;
      return regex.test(username);
    }
  
    function isValidPassword(password) {
      const regex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*]).{8,}$/;
      return regex.test(password);
    }
  
    function isValidEducation(education) {
      const trimmedEducation = education.trim();
      const educationLength = trimmedEducation.length;
      return educationLength >= 100 && educationLength <= 300;
    }
  
    function updateCharCount() {
      const educationInput = document.getElementById('education');
      const charCountElement = document.getElementById('charCount');
  
      const charCount = educationInput.value.length;
      charCountElement.textContent = charCount + ' character' + (charCount !== 1 ? 's' : '');
    }
  
    const educationInput = document.getElementById('education');
    educationInput.addEventListener('input', updateCharCount);
    updateCharCount();
  
    function isValidPhoneNumber(phoneNumber) {
      const regexUK = /^(?:\+44|0)\d{10}$/;
      const regexIreland = /^(\+353|0)\d{9}$/;
      const regexUS = /^\+1\d{10}$/;
      return regexUK.test(phoneNumber) || regexIreland.test(phoneNumber) || regexUS.test(phoneNumber);
    }
  
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
  
    function isValidCountryOfResidence(cor) {
      const allowedCountries = ["US", "UK", "IR"];
      return allowedCountries.includes(cor);
    }
  
    function isValidStreet(street) {
      return street.length <= 250;
    }
  
    function isValidNumber(number) {
      if (!number.trim()) {
        return true;
      }
  
      if (number.length > 10) {
        return false;
      }
  
      const regex = /^[a-zA-Z0-9]+$/;
      return regex.test(number);
    }
  
    function isValidPostcode(postcode, cor) {
      switch (cor) {
        case "UK":
          const regexUK = /^[A-Z0-9]{2,4}\s?\d[A-Z]{2}$/i;
          return regexUK.test(postcode);
        case "US":
          const regexUS = /^\d{5}(?:-\d{4})?$/;
          return regexUS.test(postcode);
        case "IR":
          const regexIreland = /^[A-Z0-9]{3}\s?[A-Z0-9]{4}$/i;
          return regexIreland.test(postcode);
        default:
          return false;
      }
    }
  
    function isValidJSON(json) {
      try {
        const preferences = JSON.parse(json);
        if (
          preferences &&
          preferences.notificationSettings &&
          typeof preferences.notificationSettings.post === 'boolean' &&
          typeof preferences.notificationSettings.sms === 'boolean' &&
          typeof preferences.notificationSettings.push === 'boolean' &&
          ['immediate', 'daily', 'weekly'].includes(preferences.notificationSettings.frequency)
        ) {
          return true;
        } else {
          return false;
        }
      } catch (error) {
        return false;
      }
    }
  
    function validateForm() {
      const usernameInput = document.getElementById('username');
      const passwordInput = document.getElementById('password');
      const retypePasswordInput = document.getElementById('retypepassword');
      const educationInput = document.getElementById('education');
      const phoneNumberInput = document.getElementById('phonenumber');
      const dobInput = document.getElementById('DOB');
      const corInput = document.getElementById('corSelect');
      const streetInput = document.getElementById('street');
      const numberInput = document.getElementById('number');
      const postcodeInput = document.getElementById('postcode');
      const jsonInput = document.getElementById('JSON');
      const hiddenFields = document.getElementById('hiddenFields');
  
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
  
      if (!isValidUsername(usernameInput.value)) {
        showError('Invalid username. Please enter a valid username.');
        return false;
      }
  
      if (!isValidPassword(passwordInput.value)) {
        showError('Invalid password. Please enter a password with at least 8 characters, including one uppercase, one lowercase, and one special character.');
        return false;
      }
  
      if (passwordInput.value !== retypePasswordInput.value) {
        showError('Passwords do not match.');
        return false;
      }
  
      if (!isValidEducation(educationInput.value)) {
        showError('Invalid education. Please make sure the education is between 100 and 300 characters');
        return false;
      }
  
      if (!isValidPhoneNumber(phoneNumberInput.value)) {
        showError('Invalid phone number. Please enter a valid phone number.');
        return false;
      }
  
      if (!isValidDate(dobInput.value) || isValidAge(dobInput.value) < 18) {
        showError('Invalid Date of Birth. Please use the format DD/MM/YYYY and ensure you are at least 18 years old.');
        return false;
      }
  
      if (!isValidCountryOfResidence(corInput.value)) {
        showError('Invalid Country of Residence. Please select a valid country.');
        return false;
      }
  
      if (corInput.value && !isValidStreet(streetInput.value)) {
        showError('Invalid street. Please enter a valid street (up to 250 characters).');
        return false;
      }
  
      if (!isValidNumber(numberInput.value)) {
        showError('Invalid number. Please enter a valid number.');
        return false;
      }
  
      if (!isValidPostcode(postcodeInput.value, corInput.value)) {
        showError('Invalid postcode. Please enter a valid postcode based on your country of residence.');
        return false;
      }
  
      if (!isValidJSON(jsonInput.value)) {
        showError('Invalid JSON preferences. Please enter valid JSON schema.');
        return false;
      }
  
      return true;
    }
  
    function clearError() {
        const errorMessageDiv = document.getElementById('errorMessage');
        errorMessageDiv.textContent = '';
    }
    
    function toggleHiddenFields() {
      const hiddenFields = document.getElementById('hiddenFields');
      const corInput = document.getElementById('corSelect');
      hiddenFields.style.display = corInput.value !== '' ? 'block' : 'none';
    }
  
    toggleHiddenFields();
    document.getElementById('corSelect').addEventListener('change', toggleHiddenFields);
  
    const form = document.getElementById('registrationForm');
    form.addEventListener('submit', function (event) {
      event.preventDefault();
      if (validateForm()) {
        form.submit();
      }
    });
  })();
  