<a href="cikis.php">Oturumu kapat</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="kullanici.php">Kullanici sayfasına dön</a>
<br><br>


<?php

session_start();

$urun_id =$_POST['urun_id'];
$kullanici_id =$_SESSION['kullanici_id'];
$adet = $_POST['adet'];


if($urun_id && $kullanici_id &&isset($adet) && $adet > 0){

    $db = new PDO("mysql:host=localhost;dbname=ali_oturum", 'root', '');

    $urun_sorgu = $db->query("SELECT * FROM urunler WHERE urun_id =$urun_id");
    $urun = $urun_sorgu->fetch(PDO::FETCH_ASSOC);
    $stok_adet = $urun['adet'];

    if ($adet > $stok_adet) {
        $_SESSION['favori_red'] = "Stokta yeterli ürün bulunmamaktadır!";
        header("Location: kullanici.php"); 
        exit();
    }
    else
    {
        $kontrol = $db->query("SELECT * FROM sepet WHERE kullanici_id =$kullanici_id and urun_id = $urun_id");
        $sepet_kontrol = $kontrol->fetch(PDO::FETCH_ASSOC);
        if(!$sepet_kontrol)
        {
            $sepetekle = $db->query("INSERT INTO sepet (kullanici_id, urun_id, sepet_adet) VALUES ($kullanici_id, $urun_id, $adet)");
            $_SESSION['favori_mesaj'] = "Ürün Sepetinize Eklendi";    
        }
        else
        {
            $sepetekle = $db->query("UPDATE sepet SET sepet_adet = sepet_adet + $adet WHERE kullanici_id = $kullanici_id AND urun_id = $urun_id");
            $_SESSION['favori_mesaj'] = "Sepetteki Ürünün Adedi Arttırıldı!";
        }
    }  
}
header("Location: kullanici.php");
exit();



?>

