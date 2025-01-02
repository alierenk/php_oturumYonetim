<!DOCTYPE html>
<html lang="tr">
    <head>
        <title>Kullanıcı Sayfası</title> 
        <link rel="stylesheet" href="style.css">
    </head>

    <a href="cikis.php">Oturumu kapat</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="favoriler.php">Favori Ürünler</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="sepet.php">Sepet</a>
    <br><br>

<?php
session_start();

if($_SESSION["tur"]=='kullanici' || $_SESSION["tur"]=='admin')
{
    if (isset($_SESSION['favori_mesaj'])) 
    {
        echo "<div class='favori-mesaj show'>" .
         $_SESSION['favori_mesaj'] .
             "</div>";
        unset($_SESSION['favori_mesaj']);
    }
    if(isset($_SESSION['favori_red']))
    {
        echo "<div class='favori-red show'>" .
         $_SESSION['favori_red'] .
             "</div>";
        unset($_SESSION['favori_red']);
    }
    
    $db = new PDO("mysql:host=localhost;dbname=ali_oturum",'root','');
    $listele = $db-> query("SELECT * FROM urunler");


    while($row =$listele->fetch())
    {
        $urun_id =$row['urun_id'];
        $urun_serino =$row['serino'];
        $urun_adi =$row['ad'];
        $urun_adet =$row['adet'];
        $urun_foto =$row['foto'];
        $urun_fiyat =$row['fiyat'];
    
        echo "
                <div class='product-container'>
                    <img src='urunler/$urun_foto' class='product-image' alt='Ürün Fotoğrafı'>
                    <div class='product-info'>
                        <div class='product-detail'><b>Serino:</b> $urun_serino</div>
                        <div class='product-deatil'><b>Adı:</b> $urun_adi</div>
                        <div class='product-detail'><b>Adet:</b> $urun_adet</div>
                        <div class='product-detail'><b>Fiyat:</b> $urun_fiyat</div>
                    </div>
                    <div class='action-buttons-kullanici'>
                        <form action='favoriEkle.php' method='POST'>
                            <input type='hidden' name='urun_id' value='$urun_id'>   
                            <button type='submit' class='like-btn'>
                                <img src='imgs/like.png' alt='Favori'>
                            </button>
                        </form>
                        
                        <form action='sepeteEkle.php' method='POST' style='display: flex; align-items: center;'>
                            <input type='hidden' name='urun_id' value='$urun_id'>
                            <input type='number' name='kullanici_adet' class='quantity-input' min='1' value='1' max='$urun_adet'>
                            <button type='submit' class='sepet-btn'>
                                <img src='imgs/sepet.png' alt='Sepet'>
                            </button>
                        </form>
                    </div>
                </div>"; 
    }
}
else
{
    header('location:giris.php');
    exit;
}
?>
</html>