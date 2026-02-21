<?php
global $pdo;
try{
$option=array(pdo::ATTR_ERRMODE => pdo::ERRMODE_EXCEPTION,pdo::ATTR_DEFAULT_FETCH_MODE => pdo::FETCH_OBJ);    
$pdo=new pdo("mysql:host=localhost;dbname=php_project","root","",$option);
return $pdo;
}
catch(pdoException $e){
    echo "error" . $e->getMessage();
    exit;


}