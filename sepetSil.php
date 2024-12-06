<?php

session_start();

$urun_id =$_GET['urun_id'];
$kullanici_id =$_SESSION['kullanici_id'];
$adet = $_POST['adet'];

if ($urun_id && $kullanici_id) {

    
    $db = new PDO("mysql:host=localhost;dbname=ali_oturum", 'root', '');

    
    $sepet_sorgu = $db->query("SELECT sepet_adet FROM sepet WHERE urun_id =$urun_id AND kullanici_id = $kullanici_id");
    $sepet_urun = $sepet_sorgu->fetch(PDO::FETCH_ASSOC);

    if ($sepet_urun) {
        
        $adet = $sepet_urun['sepet_adet'];

        $sepetsil = $db->query("DELETE FROM sepet WHERE urun_id = $urun_id AND kullanici_id = $kullanici_id");
      
        $stok_geri_ekle = $db->query("UPDATE urunler SET adet = adet + $adet WHERE urun_id = $urun_id");
             
        $_SESSION['favori_mesaj'] = "Ürün Başarıyla Sepetinizden Kaldırıldı";
    }
}
header("Location: kullanici.php");
exit();

?>