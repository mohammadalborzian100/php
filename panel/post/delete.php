<?php
    require_once '../../functions/helpers.php';
    require_once '../../functions/pdo_connection.php';
      require_once "../../functions/cheak-login.php";
    global $pdo;
    if(isset($_GET['post_id']) && $_GET['post_id']!=="")
        {
        $query="SELECT * FROM PHP_PROJECT.POSTS where id=?;";
        $statement=$pdo->prepare($query);
        $statement->execute([$_GET['post_id']]);
        $posts=$statement->fetch();
        $basepath=dirname(dirname(__dir__));
        if(file_exists($basepath.$posts->image))
            {
                unlink($basepath.$posts->image);
            }
        $query="DELETE FROM php_project.posts where id=?;";
        $statement=$pdo->prepare($query);
        $statement->execute([$_GET['post_id']]);


        }
        redirect('panel/post');