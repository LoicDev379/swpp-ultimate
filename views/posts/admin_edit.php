<div class="page-header">
    <h1>Editer un article</h1>
    <hr />
</div>

<!-- <= debug($post); ?> -->

<form method="POST" action="<?= Router::url("admin/posts/edit"); ?>">
    <?= $this->Form->input("title", "Titre"); ?>
    <?= $this->Form->input("slug", "Url"); ?>
    <?= $this->Form->input("id", "hidden"); ?>
    <?= $this->Form->input("content", "Contenu", ["type" => "textarea", "rows" => 5, "cols" => 10]); ?>
    <?= $this->Form->input("online", "En ligne", ["type" => "checkbox"]); ?>
    <div class="action">
        <input type="reset" class="btn btn-danger" value="Reset">&nbsp;&nbsp;&nbsp;
        <input type="submit" class="btn btn-primary" value="Envoyer">
    </div>
</form>