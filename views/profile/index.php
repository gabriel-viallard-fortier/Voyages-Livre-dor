
<div class="p-2 text-black">
    <h1>Modifiez votre compte</h1>
</div>
            <form id="Inscription" method="post">
                <fieldset>
                    <legend><b>Profil</b></legend>
                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">

                    <label for="login">Login :</label>
                    <input tabindex="0" required type="text" id="login" name="login" value="<?= htmlspecialchars($_SESSION['user']['login']) ?>">
                    <p id="loginError"></p>
                    
                    <label for="email ">Email :</label>
                    <input tabindex="0" required type="email" name="email" id="email" value="<?= htmlspecialchars($_SESSION['user']['email']) ?>">
                    <p id="emailError"></p>
                    
                    <label for="country">Pays :</label>
                    <input tabindex="0" required type="text" id="country" name="country" value="<?= htmlspecialchars($_SESSION['user']['country']) ?>">
                    <p id="countryError"></p>
                    
                    <label for="zip">Code postal :</label>
                    <input tabindex="0" required type="text" id="zip" name="zip" value="<?= htmlspecialchars($_SESSION['user']['zip']) ?>">
                    <p id="zipError"></p>

                    <label for="oldPassword">Mot de passe actuel :</label>
                    <input tabindex="0" required type="password" name="oldPassword" id="oldPassword">


                    <label for="password1">Nouveau mot de passe :</label>
                    <input tabindex="0" required type="password" name="password1" id="password1">

                    <label id="password2Label" for="password2">Confirmez :</label>
                    <input tabindex="0" required type="password" name="password2" id="password2">
                    <p id="password2Error"></p>

                    <button type="submit" id="submit" name="ok">Envoyer</button>
                </fieldset>
            </form>
        </div>

</body>

</html>