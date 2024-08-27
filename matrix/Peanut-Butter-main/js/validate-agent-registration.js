
function validateIDNumber() {
    const idNumberInput = document.getElementById('id_number');
    const idNumber = idNumberInput.value.trim();
    const idNumberPattern = /^\d{13}$/;

    if (!idNumberPattern.test(idNumber)) {
        alert("The National ID must be exactly 13 digits.");
        idNumberInput.focus();
        return false;
    }
    enterDateOfBirth(idNumber);
    return true;
}

function enterDateOfBirth(idNumber) {
    // Ensure the ID number is 13 digits long
    if (idNumber.length !== 13 || isNaN(idNumber)) {
        console.error("Invalid ID number");
        return;
    }

    // Extract year, month, and day from the ID number
    const yearPart = idNumber.substring(0, 2);
    const monthPart = idNumber.substring(2, 4);
    const dayPart = idNumber.substring(4, 6);

    // Determine the full year (assuming IDs are from 1900 to 2099)
    const currentYear = new Date().getFullYear();
    const century = yearPart > currentYear.toString().substring(2) ? "19" : "20";
    const year = century + yearPart;

    // Format the date as YYYY-MM-DD
    const dateOfBirth = `${year}-${monthPart}-${dayPart}`;

    // Insert the date into the input field with id "date_of_birth"
    document.getElementById('date_of_birth').value = dateOfBirth;
}

function validateNames() {
    const fname = document.getElementById('f_name');
    const lname = document.getElementById('l_name');

    if (fname.value === '') {
        alert("Please Enter your First Name.");
        fname.focus();
        return false;
    }
    if (lname.value === '') {
        alert("Please Enter your Last Name.");
        lname.focus();
        return false;
    }
    return true;
}

function validateEmail() {
    const email = document.getElementById('email');

    if (email.value === '') {
        // document.getElementById('emailError').textContent = 'Email is required';
        // document.getElementById('emailError').style.display = 'block';
        alert("Please Enter your email.");
        email.focus();
        return false;
    } else if (!validEmail(email.value)) {
        // document.getElementById('emailError').textContent = 'Please enter a valid email address';
        // document.getElementById('emailError').style.display = 'block';
        alert("Please enter a valid email address.");
        email.focus();
        return false;
    }
    return true;
}

function validEmail(email) {
    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    return emailPattern.test(email) ? true : false;
}

function validatePhoneNumber() {
    const phoneNumberInput = document.getElementById('cell_number');
    const phoneNumber = phoneNumberInput.value.trim();

    // Regular expression to match +268 followed by exactly 8 digits
    const phonePattern = /^\+268\d{8}$/;

    if (!phonePattern.test(phoneNumber)) {
        alert("Please enter a valid phone number in the format +268########.");
        phoneNumberInput.focus();
        return false;
    }
    return true;
}

function validateAccountNumber() {
    const accountNumberInput = document.getElementById('account_num');
    const bankName = document.getElementById('bank_name');

    const accountNumber = getAccountNumber(accountNumberInput);

    if (!validAccountNumber(bankName.value, accountNumber) && bankName.value === '') {
        alert('Please Select Your Bank Name!');
        bankName.focus();
        return false;
    } else if (!validAccountNumber(bankName.value, accountNumber)) {
        alert('Please confirm that entered account is correct!');
        accountNumberInput.focus();
        return false;
    }
    return true;
}

function validAccountNumber(bankName, accountNumber) {
    let accountNumberPattern;
    switch (bankName) {
        case 'First National Bank':
            accountNumberPattern = /^\d{11}$/;
            return accountNumberPattern.test(accountNumber);

        case 'NedBank Swaziland Ltd':
            accountNumberPattern = /^\d{11}$/;
            return accountNumberPattern.test(accountNumber);

        case 'Standard Bank Swaziland':
            accountNumberPattern = /^\d{11}$/;
            return accountNumberPattern.test(accountNumber);

        case 'Eswatini Bank':
            accountNumberPattern = /^\d{11}$/;
            return accountNumberPattern.test(accountNumber);

        // default:
        //     break;
    }
}

function getAccountNumber(accountNumberInput) {
    let input = accountNumberInput.value;
    let plainNumber = input.replace(/-/g, ''); // Remove all dashes
    return plainNumber; // Return the plain account number
}

// validate branch code 
function validateBranchCode() {
    const branchCodeInput = document.getElementById('branch_num');
    const branchCode = branchCodeInput.value.trim();
    const branchCodePatten = /^\d{6}$/;

    if (!branchCodePatten.test(branchCode)) {
        alert("Please ensure that branch code is valid.");
        branchCodeInput.focus();
        return false;
    }
    return true;
}



// Add an event listener to validate when the form is submitted
document.querySelector('.form-contact').addEventListener('submit', function (event) {
    if (!validateIDNumber() || !validateNames() || !validateEmail() || !validateAccountNumber() || !validateBranchCode()) {
        event.preventDefault(); // Prevent form submission if the ID number is invalid
    }
});

/* setup acc number format */
function formatAccountNumber(input) {
    let value = input.value.replace(/\D/g, ''); // Remove non-digits
    if (value.length > 3 && value.length <= 6) {
        value = value.replace(/(\d{3})(\d{1,3})/, '$1-$2');
    } else if (value.length > 6 && value.length <= 9) {
        value = value.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1-$2-$3');
    } else if (value.length > 9) {
        value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1-$2-$3-$4');
    }
    input.value = value;
}

/* set bank account numbers placeholders */

const inputWithDatalist = document.getElementById('bank_name');
const anotherInput = document.getElementById('account_num');

// Define placeholder text for each option
const placeholders = {
    'First National Bank': '111-111-111-11',
    'NedBank Swaziland Ltd': '222-222-222-22',
    'Standard Bank Swaziland': '333-333-333-33',
    'Eswatini Bank': '444-444-444-44'
};

// Update the placeholder of 'anotherInput' based on the selected item
inputWithDatalist.addEventListener('input', function () {
    const selectedOption = inputWithDatalist.value;
    anotherInput.placeholder = placeholders[selectedOption] || '###-####-###-##';
});
