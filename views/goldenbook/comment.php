<div class="p-2">
    <h1>Laissez un commentaire</h1>
</div>

<form class="p-2 forms" action="" method="post">
    <fieldset>
        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">

        <legend><b>Commentaire</b></legend>
        <label for="comment">Entrez votre commentaire</label>
        <textarea name="comment" id="comment" maxlenght="1024"></textarea>
        <button type="submit" name="ok" id="ok">Poster</button>
    </fieldset>
</form>