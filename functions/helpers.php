<?php
define("base_url","http://localhost/php-project/");
function redirect($url)
{
    header("location:".trim(base_url,'/ ').'/' .trim($url,'/ '));
    exit;
}
// redirect("panel/categoris");
function asset($file)
{
    return trim(base_url,'/ ').'/'.trim($file,'/ ');
}

function url($url)
{
    return trim(base_url,'/ ').'/'.trim($url,'/ ');
}

function dd($var)
{
    echo '<pre>';
    var_dump($var);
    exit;

}


