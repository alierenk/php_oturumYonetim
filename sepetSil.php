<?php

session_start();

$urun_id =$_GET['urun_id'];
$kullanici_id =$_SESSION['kullanici_id'];

$i = 0;
if($i == 0){

        $db = new PDO("mysql:host=localhost;dbname=ali_oturum", 'root', '');

        $sepetsil = $db->query("DELETE FROM sepet where urun_id = $urun_id");
        if($sepetsil)
        {
            $_SESSION['favori_mesaj'] = "Ürün Başarıyla Sepetinizden Kaldırıldı"; 
        }
        
}
header("Location: kullanici.php");
exit();

?>