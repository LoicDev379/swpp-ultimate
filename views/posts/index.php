<div class="page-header">
    <h1>Articles récents du blog</h1>
    <hr />
</div>
<?php foreach ($posts as $k => $v) : ?>
    <h2><?= $v->title ?></h2>
    <div class=""><?= $v->content ?></div>
    <p><a href="<?= Router::url("posts/view/id:{$v->id}/slug:$v->slug") ?>" class="btn btn-primary">Lire la suite &rArr;</a></p>
<?php endforeach; ?>

<!-- La pagination de la page index -->
<ul class="pagination">
    <?php for ($i = 1; $i <= $nbrePages; $i++) : ?>
        <li class="page-item <?= ($i == $this->request->page) ? "active" : ""; ?>">
            <a href="?page=<?= $i ?>" class="page-link"><?= $i ?></a>
        </li>
    <?php endfor; ?>
</ul>

<!-- <= debug($posts); ?> -->