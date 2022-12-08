<div class="page-header">
    <h2><?= $total ?> Articles</h2>
</div>

<div class="">
    <table class="table table-striped table-bordered">
        <thead class="thead-lightx">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Title</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody class="">
            <?php foreach ($posts as $k => $v) : ?>
                <tr>
                    <td><?= $v->id ?></td>
                    <td><?= $v->title ?></td>
                    <td>
                        <a href="<?= Router::url("admin/posts/edit/" . $v->id) ?>">Editer</a>
                        <a onclick="return confirm('Voulez-vous vraiment supprimer ?')" href="<?= Router::url("admin/posts/delete/" . $v->id) ?>">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>