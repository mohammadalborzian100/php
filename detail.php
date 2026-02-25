<?php
require_once "functions/helpers.php";
require_once "functions/pdo_connection.php"


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP tutorial</title>
    <link rel="stylesheet" href="<?= asset('assets/css/bootstrap.min.css') ?>" media="all" type="text/css">
    <link rel="stylesheet" href="<?= asset('assets/css/style.css') ?>" media="all" type="text/css">
</head>
<body>
<section id="app">
    <?php require_once "layouts/top-nav.php"?> 

    <section class="container my-5">
        <!-- Example row of columns -->
         <?php
            global $pdo;
          

            $query="SELECT php_project.posts.*,php_project.categories.name as category_name from php_project.posts
            INNER JOIN php_project.categories on php_project.posts.cat_id=php_project.categories.id  where posts.status=10 and posts.id=?;";
            $statement=$pdo->prepare($query);
            $statement->execute([$_GET['post_id']]);
            $post=$statement->fetch();
            
            IF($post !== FALSE){
            ?>
        <section class="row">
            <section class="col-md-12">
                <h1><?= $post->title ?></h1>
                <h5 class="d-flex justify-content-between align-items-center">
                    <a href="<?=url('categories.php?cat_id='.$post->cat_id)  ?>"> <?= $post->category_name ?></a>
                    <span class="date-time"><?= $post->created_at ?></span>
                </h5>
                <article class="bg-article p-3"><img class="float-right mb-2 ml-2" style="width: 18rem;" src="" alt=""><?= $post->body ?></article>
                <?php } else{ ?>
                    <section>post not found!</section>
                    <?php } ?>
             
            </section>
        </section>
    </section>

</section>
<script src="<?= asset('assets/js/bootstrap.min.js') ?>"></script>
<script src="<?= asset('assets/js/jquery.min.js') ?>"></script>
</body>
</html>