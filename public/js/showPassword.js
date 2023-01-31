var pass = document.getElementById('password')
var eye = document.getElementById('eye')
var pass1 = document.getElementById('password-confirmation')
var eye1 = document.getElementById('eye1')

function showPassword(pass, eye){
    if(pass.type === "password") {
        pass.type = "text";
        eye.ariaHidden='true'
        eye.style.color='#5887ef';
        eye.classList.replace("bxs-hide", "bxs-show");
    } else {
        pass.type = "password";
        eye.style.color='#7a797e';
        eye.ariaHidden='false'
        eye.classList.replace("bxs-show", "bxs-hide");
    }
}
