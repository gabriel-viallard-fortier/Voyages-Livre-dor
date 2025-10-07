
        <?= $_SESSION['message'] ?>
        <div class="forms">
            <form id="Inscription" method="post">
                <fieldset>
                    <legend><b>Profil</b></legend>
                    <p id="form-msg"><b>Veuillez remplir ces informations</b></p>

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
                    
                    <span class="little margin-2">
                        <input tabindex="0" id="showPassword" name="showPassword" type="checkbox">Montrer le
                        mot de passe</span>
                    <p id="password1Error"></p>

                    <label id="password2Label" for="password2">Confirmez :</label>
                    <input tabindex="0" required type="password" name="password2" id="password2">
                    <p id="password2Error"></p>

                    <button type="submit" id="submit" name="ok">Envoyer</button>
                </fieldset>
            </form>
        </div>

</body>

</html>