let submit = document.querySelector('input[type="submit"]');

let pass1 = document.querySelector('input[name="password"]');
let pass2 = document.querySelector('input[name="confPassword"]');

function passChecker (e) {
    if (pass1.value != pass2.value) {
        e.preventDefault();
        window.alert("Both passwords aren't the same");
    }
}

submit.addEventListener('click',passChecker)

// password doesn't remain blank because of HTML required element