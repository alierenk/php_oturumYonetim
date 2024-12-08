<?php

session_start();

$urun_id =$_GET['urun_id'];
$kullanici_id =$_SESSION['kullanici_id'];

$i = 0;
if($i == 0){

        $db = new PDO("mysql:host=localhost;dbname=ali_oturum", 'root', '');

        $favorisil = $db->query("DELETE FROM favori where urun_id = $urun_id");
        if($favorisil)
        {
            $_SESSION['favori_mesaj'] = "Ürün Başarıyla Favorilerden Kaldırıldı"; 
        }
        
}
header("Location: favoriler.php");
exit();

?>