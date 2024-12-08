<a href="cikis.php">Oturumu kapat</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="kullanici.php">Kullanici sayfasına dön</a>
<br><br>
<?php

session_start();

$db = new PDO("mysql:host=localhost;dbname=ali_oturum",'root','');



$kullanici_id =$_SESSION['kullanici_id'];

$favlist =$db->query("SELECT DISTINCT urunler.* FROM favori JOIN urunler ON favori.urun_id = urunler.urun_id WHERE favori.kullanici_id = $kullanici_id");
$favoriUrunler = $favlist->fetchAll(PDO::FETCH_ASSOC);
 
if (count($favoriUrunler) > 0)
 {
    echo "<h2 align='center'>Favorilerim</h2>";
    echo "<table align='center' border='1'>

        <tr>
            <td>Ürün ID</td>
            <td>Serino</td>
            <td>Adı</td>
            <td>Adet</td>
            <td>Fotoğraf</td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>";
 
        foreach ($favoriUrunler as $urun) 
        {
            echo "<tr>
                <td>{$urun['urun_id']}</td>
                <td>{$urun['serino']}</td>
                <td>{$urun['ad']}</td>
                <td>{$urun['adet']}</td>
                <td><img src='urunler/{$urun['foto']}' style='height:100px;width:100px;'></td>
                <td>
                <a href='favoriSil.php?urun_id={$urun['urun_id']}'>Favorilerden çıkar</a>
                </td>
            </tr>";
  
        }
}    
?>





















