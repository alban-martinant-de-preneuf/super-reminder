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
const decoBtn = document.getElementById('deco_btn')


async function getRegisterForm() {
    const res = await fetch('/super-reminder/registerForm')
    const data = await res.text()
    wrapper.innerHTML = data
    const registerForm = document.getElementById('register_form')
    activeSubmit(registerForm, "/super-reminder/register")
}

async function getLoginForm() {
    const res = await fetch('/super-reminder/loginForm')
    const data = await res.text()
    wrapper.innerHTML = data
    const loginForm = document.getElementById('login_form')
    activeSubmit(loginForm, "/super-reminder/login")
}

async function logout(e) {
    e.preventDefault()
    const res = await fetch('/super-reminder/logout')
    if (res.ok) {
        window.location.href = "/super-reminder/"
    }
}

async function activeSubmit(form, route) {
    form.addEventListener('submit', async (e) => {
        e.preventDefault()
        const formData = new FormData(form)
        const res = await fetch(route, {
            method: 'POST',
            body: formData,
        })
        const data = await res.json()
        if (data.message === 'Connected') {
            window.location.href = "/super-reminder/"
        } else if (data.message === 'Registered') {
            message.innerHTML = "Vous êtes bien enregistré, vous allez être redirigé vers la page de connexion"
            setTimeout(() => {
                getLoginForm()
            }, 2000)
        } else {
            const message = document.getElementById('message')
            message.innerHTML = data.message
        }
    })
}


getRegisterFormBtn?.addEventListener('click', getRegisterForm)
getLoginFormBtn?.addEventListener('click', getLoginForm)
decoBtn?.addEventListener('click', logout)