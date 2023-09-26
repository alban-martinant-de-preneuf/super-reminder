<script src="public/script.js" defer></script>

<h1>Register Form</h1>

<form id="register_form">
    <label for="registerFirstName">Name</label>
    <input name="firstname" type="text" id="registerFirstName" placeholder="Enter your name"><br><br>

    <label for="registerLasttName">Last name</label>
    <input name="lastname" type="text" id="registerLasttName" placeholder="Enter your lastname"><br><br>

    <label for="registerEmail">Email</label>
    <input name="email" type="email" id="registerEmail" placeholder="Enter your email"><br><br>

    <label for="registerPassword">Password:</label>
    <input name="password" type="password" id="registerPassword" placeholder="Enter your password"><br><br>

    <label for="passwordComfirmation">Password comfirmation:</label>
    <input name="password2" type="password" id="passwordComfirmation" placeholder="Comfirm your password"><br><br>

    <p id="message"></p>
    <input type="submit" id="register_submit" value="Register"></input>
</form>