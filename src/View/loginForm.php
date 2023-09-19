<script src="public/script.js" defer></script>

<h1>Register Form</h1>

<form id="registerForm">
    <label for="registerFirstName">Name</label>
    <input name="firstName" type="text" id="registerFirstName" placeholder="Enter your name"><br><br>

    <label for="registerLasttName">Last name</label>
    <input name="lastName" type="text" id="registerLasttName" placeholder="Enter your lastname"><br><br>

    <label for="registerEmail">Email</label>
    <input name="email" type="text" id="registerEmail" placeholder="Enter your email"><br><br>


    <label for="registerPassword">Password:</label>
    <input name="password" type="password" id="registerPassword" placeholder="Enter your password"><br><br>

    <label for="passwordComfirmation">Password:</label>
    <input name="password" type="password" id="passwordComfirmation" placeholder="Comfirme your password"><br><br>

    <button onclick="register()">Register</button>
</form>