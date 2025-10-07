<div class="p-2">
    <h1>Commentaires</h1>
<?php
foreach ($comments as $comment):?>
<div class="comment">
    <?= htmlspecialchars($comment["login"]) . ", le " . $comment['date'] . " : <br>"?>
    <p class="comment-content"> <?= htmlspecialchars($comment['commentaire'])?></p>
</diV>
    
<?php endforeach;?>
</div>











