<p><?= $_SESSION['message'] ?></p>

<div class="forms">
    <div class="auth-header">
        <h1><?php e($title); ?></h1>
        <p>Créez votre compte</p>
    </div>
    <form id="Inscription" method="post">
        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
        <fieldset>
            <legend><b>INSCRIPTION</b></legend>
                    <p id="form-msg"><b>Veuillez remplir ces informations</b></p>

                    <label for="login">Login :</label>
                    <input tabindex="0" required type="text" id="login" name="login">
                    <p id="loginError"></p>
                    
                    <label for="email ">Email :</label>
                    <input tabindex="0" required type="email" name="email" id="email">
                    <p id="emailError"></p>
                    
                    <label for="country">Pays :</label>
                    <input tabindex="0" required type="text" id="country" name="country">
                    <p id="countryError"></p>
                    
                    <label for="zip">Code postal :</label>
                    <input tabindex="0" required type="text" id="zip" name="zip">
                    <p id="zipError"></p>
                    
                    <label for="password1">Mot de passe :
                        </label>
                        <input tabindex="0" required type="password" name="password1" id="password1">
                        <p id="password1Error"></p>
                    
                        <label id="password2Label" for="password2">Confirmez :</label>
                        <input tabindex="0" required type="password" name="password2" id="password2">
                        <p id="password2Error"></p>
                        
                        <span class="little margin-2">
                            <input tabindex="0" id="showPassword" name="showPassword" type="checkbox">Montrer le
                            mot de passe</span>
                            
                            <button type="submit" id="submit" name="ok">Envoyer</button>
                        </fieldset>
                    <div class="center">
                        <p class="text-black">Déjà un compte ?
                                <a href="<?php echo url('auth/login'); ?>">Se connecter</a>
                            </p>
                    </div>
                    </form>
        </div>