let form = document.querySelector('form');
let email = document.querySelector('input[type="email"]');
let pass = document.querySelector('input[type="password"]');

function validator (e) {
    if (pass.value == '' && email.value == '')
    {
        e.preventDefault();
        fieldsArr[0].style.backgroundColor = 'red';
        fieldsArr[1].style.backgroundColor = 'red';
        window.alert('Please fill in your details');
    }
    else if (email.value == '')
    {
        e.preventDefault();
        fieldsArr[0].style.backgroundColor = 'red';
        fieldsArr[1].style.backgroundColor = 'transparent';
        window.alert('Please enter an email');
    }
    else if (pass.value == '')
    {
        e.preventDefault();
        fieldsArr[0].style.backgroundColor = 'transparent';
        fieldsArr[1].style.backgroundColor = 'red';
        window.alert('Please enter a password');
    }
}

form.addEventListener('submit',validator);

let fieldsArr = document.getElementsByClassName('fieldsDiv');

// fieldsArr[0].style.backgroundColor; ~ email
// fieldsArr[1].style.backgroundColor; ~ pass



// later on check against database for correct email/pass