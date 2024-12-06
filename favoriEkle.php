<?php

session_start();

$urun_id =$_POST['urun_id'];
$kullanici_id =$_SESSION['kullanici_id'];

if($urun_id && $kullanici_id){

    $db = new PDO("mysql:host=localhost;dbname=ali_oturum", 'root', '');

    $kontrol = $db->query("SELECT * FROM favori WHERE kullanici_id =$kullanici_id and urun_id = $urun_id");
    $favori_kontrol = $kontrol->fetch(PDO::FETCH_ASSOC);
    if($favori_kontrol)
    {
        $_SESSION['favori_red'] = "Bu ürün zaten favorilerinize eklenmiş.";
    }
    else
    {
        $favoriekle = $db->query("INSERT INTO favori(kullanici_id,urun_id) VALUES ($kullanici_id,$urun_id)");
        $_SESSION['favori_mesaj'] = "Ürün Favorilere Eklendi";
    }
}

header("Location: kullanici.php");
exit();

?>