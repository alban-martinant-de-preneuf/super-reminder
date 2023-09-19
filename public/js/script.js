// function register(){
//     let firstName = document.getElementById('registerFirstName').value;
//     let lastName = document.getElementById('registerLastName').value;
//     let email = document.getElementById('registerEmail').value;
//     let password = document.getElementById('registerPassword').value;
//     let comfirmPassword = document.getElementById('passwordComfirmation').value;

//     if(password === comfirmPassword){
//         alert('registration successfull')
//     }

//     const registerSubmit = document.getElementById('register_submit');

//     registerSubmit.addEventListener('click', register)
// }

const wrapper = document.getElementById('wrapper')
const getRegisterFormBtn = document.getElementById('get_register_form')
const getLoginFormBtn = document.getElementById('get_login_form')

async function getRegisterForm() {
    const res = await fetch('/super-reminder/registerForm')
    const data = await res.text()
    wrapper.innerHTML = data
}

async function getLoginForm() {
    const res = await fetch('/super-reminder/loginForm')
    const data = await res.text()
    wrapper.innerHTML = data
}

getRegisterFormBtn.addEventListener('click', getRegisterForm)
getLoginFormBtn.addEventListener('click', getLoginForm)
