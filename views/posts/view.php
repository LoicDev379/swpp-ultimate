<?php $title_for_layout = $post->title ?>
<div class="jumbotron">
    <h1><?= $post->title ?></h1>
    <p><?= $post->content ?></p>
    <p><a href="<?= Router::url("posts/index") ?>" class="btn btn-primary">&lArr; Retourner à l'accueil</a></p>
</div>