<?php
    require_once '../../functions/helpers.php';
    require_once '../../functions/pdo_connection.php';
    global $pdo;
    if(!isset($_GET['post_id'])){
        redirect('panel/post');}
    if(isset($_GET['post_id']) &&$_GET['post_id'] !==0 ){
        $query="SELECT * FROM php_project.posts where id=?;";
        $statement=$pdo->prepare($query);
        $statement->execute([$_GET['post_id']]);
        $posts=$statement->fetch();

     

    if($posts!==false){
        if($posts->status==10)
            {
            $status=0;

            }
        else{
            $status=10;
        }
        $query="UPDATE php_project.posts set status=? where id=?;";
        $statement=$pdo->prepare($query);
        $statement->execute([$status,$_GET["post_id"]]);

    }
    redirect('panel/post');
    }
?>    

    