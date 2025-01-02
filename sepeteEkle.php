<a href="cikis.php">Oturumu kapat</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="kullanici.php">Kullanici sayfasına dön</a>
<br><br>


<?php

session_start();

$urun_id =$_POST['urun_id'];
$kullanici_id =$_SESSION['kullanici_id'];
$kullanici_adet = $_POST['kullanici_adet'];


if($urun_id && $kullanici_id &&isset($kullanici_adet) && $kullanici_adet > 0){

    $db = new PDO("mysql:host=localhost;dbname=ali_oturum", 'root', '');

    $urun_sorgu = $db->query("SELECT * FROM urunler WHERE urun_id =$urun_id");
    $urun = $urun_sorgu->fetch(PDO::FETCH_ASSOC);
    $stok_adet = $urun['adet'];

    if ($kullanici_adet > $stok_adet) {
        $_SESSION['favori_red'] = "Stokta yeterli ürün bulunmamaktadır!";
        header("Location: kullanici.php"); 
        exit();
    }
    else
    {
        $kontrol = $db->query("SELECT * FROM sepet WHERE kullanici_id =$kullanici_id and urun_id = $urun_id");
        $sepet_kontrol = $kontrol->fetch(PDO::FETCH_ASSOC);

        if ($sepet_kontrol) {
            // Eğer sepette ürün zaten varsa, adet artacak şekilde güncelliyoruz
            $sepet_adet = $sepet_kontrol['sepet_adet'];
            $yeni_adet = $sepet_adet + $kullanici_adet;

            if ($yeni_adet <= $stok_adet) {
                // Sepetteki adet stok limitini geçmiyorsa güncelleme yapıyoruz
                $sepetekle = $db->query("UPDATE sepet SET sepet_adet = $yeni_adet WHERE kullanici_id = $kullanici_id AND urun_id = $urun_id");
                $_SESSION['favori_mesaj'] = "Sepetteki Ürünün Adedi Arttırıldı!";
            } else {
                // Eğer sepetteki adet stok limitini geçiyorsa hata mesajı
                $_SESSION['favori_red'] = "Stokta yeterli ürün bulunmamaktadır!";
            }
        } else {
            // Sepette bu ürün yoksa yeni ürün ekliyoruz
            if ($kullanici_adet <= $stok_adet) {
                // Eğer istenen adet stokta varsa, sepete ekliyoruz
                $sepetekle = $db->query("INSERT INTO sepet (kullanici_id, urun_id, sepet_adet) VALUES ($kullanici_id, $urun_id, $kullanici_adet)");
                $_SESSION['favori_mesaj'] = "Ürün Sepetinize Eklendi";             
            } else {
                // Sepete ekleme işlemi stok limitini aşarsa
                $_SESSION['favori_red'] = "Stokta yeterli ürün bulunmamaktadır!";
            }
        }
    }  
}
header("Location: kullanici.php");
exit();



?>

