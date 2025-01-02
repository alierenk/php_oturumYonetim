<!DOCTYPE html>
<html lang="tr">
    <head>
        <link rel="stylesheet" href="style.css">
    </head>
<a href="cikis.php">Oturumu kapat</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="kullanici.php">Kullanici sayfasına dön</a>
<br><br>

<?php

session_start();

if (isset($_SESSION['favori_red'])) {
    echo "<div class='favori-red show'>" . $_SESSION['favori_red'] . "</div>";
    unset($_SESSION['favori_red']);
}

$db = new PDO("mysql:host=localhost;dbname=ali_oturum",'root','');
$urun_listele=$db->query("SELECT * FROM urunler");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $urun_id = $_POST['urun_id'];
    $sepet_sayisi = $_POST['sepet_adet'];
    $kullanici_id = $_SESSION['kullanici_id'];

    $urun_sorgu = $db->query("SELECT * FROM urunler WHERE urun_id = $urun_id");
    $urun = $urun_sorgu->fetch(PDO::FETCH_ASSOC);

    if ($urun) 
    {
        $stok_adet = $urun['adet'];
        
        // Artış yapılmadan önce stok kontrolü
        if (isset($_POST['ekle'])) {
            if ($sepet_sayisi < $stok_adet) {
                $sepet_sayisi++;
            } else {
                $_SESSION['favori_red'] = "Stokta yeterli ürün bulunmamaktadır!";
                header("Location: " . $_SERVER['PHP_SELF']); // Sayfayı yeniden yüklüyoruz
                exit();
            }
        }
        if (isset($_POST['azalt']) && $sepet_sayisi > 1) 
        {
            $sepet_sayisi--;
        }   
        $update_query = $db->query("UPDATE sepet SET sepet_adet = $sepet_sayisi WHERE urun_id = $urun_id AND kullanici_id = $kullanici_id");
    }
}

$kullanici_id =$_SESSION['kullanici_id'];

$sepetlist =$db->query("SELECT urunler.*, sepet.sepet_adet FROM sepet JOIN urunler ON sepet.urun_id = urunler.urun_id WHERE sepet.kullanici_id = $kullanici_id");
$sepeturunler = $sepetlist->fetchAll(PDO::FETCH_ASSOC);

$toplam_tutar = 0;



if (count($sepeturunler) > 0)
    {
    echo "<h2 align='center'>Sepetim &nbsp;&nbsp;<a href='cikti.php' style='font-size: 16px; color:gray; text-decoration: none;'>[PDF Yazdır]</a></h2>";
    echo "<table align='center' border='1'>

        <tr>
            <td>Ürün</td>
            <td>Fiyat</td>
            <td>Adet</td>
            <td>Toplam Tutar</td>
        </tr>";
 
        foreach ($sepeturunler as $urun) 
        {
            $urun_toplam_tutar = $urun['fiyat'] * $urun['sepet_adet'];
            $toplam_tutar += $urun_toplam_tutar;

            echo "<tr>            
            <td>
            <div class='.action-buttons-sepet' style='display: flex; align-items: center; padding: 10px;'>
            <form action='sepetSil.php' method='POST' style='display: flex; align-items:center; margin-right: 10px;'>
                <input type='hidden' name='urun_id' value='{$urun['urun_id']}'>   
                <button type='submit' class='sepet_sil-btn'>
                    <img src='imgs/sepet_sil.png' alt='sepet_sil-btn'>
                </button>
            </form>

            <div style='display: flex; align-items: center;'>
                <img src='urunler/{$urun['foto']}' style='height:100px;width:100px;'>
                <div style='display: flex; justify-content: left; align-items: center; height:100px; width: 250px; text-align: center; margin-left: 30px;'>
                    {$urun['ad']}
                </div>
            </div>
        </div>
         </td>
            <td>    
                {$urun['fiyat']}
            </td>
            <td>
            <form action='' method='POST'>
                <div style='display: flex; justify-content: center; align-items: center; gap: 4px;'>
                    <input type='submit' name='azalt' value='-' style='width: 25px; height: 25px; cursor: pointer;'>
                    <input type='number' name='sepet_adet' value='{$urun['sepet_adet']}' min='1' max='{$urun['adet']}'  style='width: 35px; height: 20px; text-align: center;'>
        
        
                    <input type='submit' name='ekle' value='+' style='width: 25px; height: 25px; cursor: pointer;'>
                </div>
                    <input type='hidden' name='urun_id' value='{$urun['urun_id']}'>
            </form>
            </td>
            <td>
            {$urun_toplam_tutar}
            </td>
            </tr>";
  
        }  
    } 
$_SESSION['toplam_tutar'] = $toplam_tutar;
?>
</html>


