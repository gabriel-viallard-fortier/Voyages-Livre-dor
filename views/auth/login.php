<div class="forms">
    <div class="p-2">
        <h1>Connectez-vous à votre compte</h1>
    </div>
    <form class="forms p-2" id="connection" name="login_form" method="post" action="<?php echo url('auth/login'); ?>">
        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
        <fieldset>
            <legend><?php e($title); ?></legend>
            <label for="email ">Email :</label>
            <input tabindex="1" class="margin-2" type="email" name="email" id="email">
            <label for="password">Mot de passe :</label>
            <input tabindex="1" type="password" class="margin-2" name="password" id="passsword">
            <button type="submit" name="ok">Envoyer</button>
        </fieldset>
        <div class="center">
            <p class="p-2 text-black">Pas encore de compte ?
                <a href="<?php echo url('auth/register'); ?>">S'inscrire</a>
            </p>
        </div>
    </form>
