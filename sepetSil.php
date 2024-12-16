<?php

session_start();

$urun_id =$_POST['urun_id'];
$kullanici_id =$_SESSION['kullanici_id'];


if ($urun_id && $kullanici_id) {

    
    $db = new PDO("mysql:host=localhost;dbname=ali_oturum", 'root', '');

    
    $sepet_sorgu = $db->query("SELECT sepet_adet FROM sepet WHERE urun_id =$urun_id AND kullanici_id = $kullanici_id");
    $sepet_urun = $sepet_sorgu->fetch(PDO::FETCH_ASSOC);

    if ($sepet_urun) {
        $sepetsil = $db->query("DELETE FROM sepet WHERE urun_id = $urun_id AND kullanici_id = $kullanici_id");
                 
        $_SESSION['favori_mesaj'] = "Ürün Başarıyla Sepetinizden Kaldırıldı";
    }
}
header("Location: sepet.php");
exit();

?>