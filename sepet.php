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

$db = new PDO("mysql:host=localhost;dbname=ali_oturum",'root','');

$kullanici_id =$_SESSION['kullanici_id'];


$sepetlist =$db->query("SELECT urunler.*, sepet.sepet_adet FROM sepet JOIN urunler ON sepet.urun_id = urunler.urun_id WHERE sepet.kullanici_id = $kullanici_id");
$sepeturunler = $sepetlist->fetchAll(PDO::FETCH_ASSOC);

if (count($sepeturunler) > 0)
 {
    echo "<h2 align='center'>Sepetim</h2>";
    echo "<table align='center' border='1'>

        <tr>
            <td>Ürün</td>
            <td>Fiyat</td>
            <td>Adet</td>
            <td>Toplam Tutar</td>
        </tr>";
 
        foreach ($sepeturunler as $urun) 
        {
            echo "<tr>            
            <td>
            <div class='.action-buttons-sepet' style='display: flex; align-items: center; padding: 10px;'>
            <form action='' method='POST' style='display: flex; align-items:center; margin-right: 10px;'>
                <input type='hidden' name='urun_id' value=''>   
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
                        <input type='submit' name='azalt' value='-'>
                        <input type='number' name='stok_ekle' value='{$urun['sepet_adet']}' style='width:50px'>
                        <input type='hidden' name='urun_id' value='{$urun['urun_id']}'>
                        <input type='submit' name='ekle' value='+'>
                </form>
            </td>
            </tr>";
  
        }
} 


?>
</html>


