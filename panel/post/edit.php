<?php
    require_once '../../functions/helpers.php';
    require_once '../../functions/pdo_connection.php';
      require_once "../../functions/cheak-login.php";
    global $pdo;
    if(!isset($_GET['post_id'])){
        redirect('panel/post');

    }
    $query="SELECT * FROM php_project.posts where id=?;";
    $statement=$pdo->prepare($query);
    $statement->execute([$_GET['post_id']]);
    $posts=$statement-> fetch();
    if($posts === false){
        redirect('panel/post');}
     




    if(isset($_POST['title'] )&& $_POST['title'] !==" "
    && isset($_POST['cat_id'] )&& $_POST['cat_id'] !==" "
    &&isset($_POST['body'] )&& $_POST['body'] !==" "
    )
    {
    $query="SELECT * FROM php_project.categories where id=?;";
    $statement=$pdo->prepare($query);
    $statement->execute([$_POST['cat_id']]);
    $category=$statement->fetch();

    if(isset($_FILES['image'])&&$_FILES['image']['name']!==' ')
        {
            $allowmimes=["png","jpeg","jpg","gif"];
            $imagemime=pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
            if(!in_array($imagemime,$allowmimes)){
                redirect("panel/post");}
                
            $basepath=dirname(dirname(__dir__));
            if(file_exists($basepath.$posts->image)){
                unlink($basepath.$posts->image);}
               
            
            $image=('/assets/images/post/').date('y_m_d_h_i_s').'.'.$imagemime;
            $image_upload=move_uploaded_file($_FILES['image']['tmp_name'],$basepath.$image);
            if($category!==false && $image_upload!==false){
            $query="UPDATE php_project.posts set title=? , cat_id=? ,body=? , image=? , updated_at=now() where id=?;";
            $statement=$pdo->prepare($query);
            $statement->execute([$_POST['title'],$_POST['cat_id'],$_POST['body'],$image,$_GET['post_id']]);}
       
                
                
                
        }

                

    else{
         if($category!==false){
        $query="UPDATE php_project.posts set title=? , cat_id=? ,body=? ,   updated_at=now() where id=?;";
        $statement=$pdo->prepare($query);
        $statement->execute([$_POST['title'],$_POST['cat_id'],$_POST['body'],$_GET['post_id']]);}
        }

        redirect('panel/post');
    }









?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP panel</title>
    <link rel="stylesheet" href="<?= asset('assets/css/bootstrap.min.css') ?>" media="all" type="text/css">
    <link rel="stylesheet" href="<?= asset('assets/css/style.css') ?>" media="all" type="text/css">
</head>

<body>
    <section id="app">
<?php require_once '../layouts/top-nav.php'; ?>

        <section class="container-fluid">
            <section class="row">
                <section class="col-md-2 p-0">
                    <?php require_once '../layouts/sidebar.php'; ?>
                </section>
                <section class="col-md-10 pt-3">

                    <form action="" method="post" enctype="multipart/form-data">
                        <section class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" id="title"  value="<?= $posts->title ?>">
                        </section>
                        <section class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" name="image" id="image">
                            <img src="<?= asset($posts->image) ?>" alt="" width="150">
                        </section>
                        <section class="form-group">
                            <label for="cat_id">Category</label>
                            <select class="form-control" name="cat_id" id="cat_id">
                            <?php
                            global $pdo;
                            $query="SELECT * FROM php_project.categories;";
                            $statement=$pdo->prepare($query);
                            $statement->execute();
                            $categories=$statement->fetchall();
                            foreach($categories as $category){ ?>
                                <option value="<?= $category->id ?>" <?php if($category->id==$posts->cat_id) echo "selected" ?> ><?= $category->name ?></option>

                            <?php } ?>

                        </select>
                       
                        </section>
                        <section class="form-group">
                            <label for="body">Body</label>
                            <textarea class="form-control" name="body" id="body" rows="5" ><?= $posts->body ?></textarea>
                        </section>
                        <section class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </section>
                    </form>

                </section>
            </section>
        </section>

    </section>

  <script src="<?= asset('assets/js/jquery.min.js') ?>"></script>
<script src="<?= asset('assets/js/bootstrap.min.js') ?>"></script>
</body>

</html>