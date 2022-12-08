<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title_for_layout) ? $title_for_layout : "SwPp-UlTiMaTe" ?></title>

    <script src="<?= BASE_URL . "bootstrap" . DS . "4.0.0" . DS . "js" . DS . "bootstrap.min.js?t=" . time() ?>"></script>
    <script src="<?= BASE_URL . "bootstrap" . DS . "4.0.0" . DS . "jquery" . DS . "jquery-3.6.0.js?t=" . time() ?>"> </script>
    <link rel="stylesheet" href="<?= BASE_URL . "bootstrap" . DS . "4.0.0" . DS . "css" . DS . "bootstrap.min.css?t=" . time() ?>" />
    <link rel="stylesheet" href="<?= BASE_URL . "css" . DS . "style.css?t=" . time(); ?>" />

</head>

<body>

    <!-- Navbar pour le layout par default -->
    <nav class="navbar navbar-expand-sm bg-light">
        <div class="container">
            <h5 class="title"><a href="#" class="nav-link" title="Accueil">SwPp-UlTiMaTe</a></h5>
            <ul class="navbar-nav">
                <?php $pagesMenu = $this->request("Pages", "getMenu"); ?>
                <?php if (isset($pagesMenu)) : foreach ($pagesMenu as $p) : ?>
                        <li class="nav-item">
                            <a href="<?= BASE_URL . "pages" . DS . "view" . DS . $p->id ?>" class="navlink" title="<?= $p->title ?>"><?= $p->title ?></a>&nbsp;|&nbsp;
                        </li>
                <?php endforeach;
                endif; ?>
                <li><a href="<?= Router::url("posts/index") ?>" class="navlink" title="Voir les derniers articles du blog">Actualité</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <p><?= $this->Session->flash(); ?></p>
        <?= $content_for_layout; ?>
    </div>

</body>

</html>