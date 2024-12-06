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
            <td>Adı</td>
            <td>Adet</td>
            <td>Fotoğraf</td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>";
 
        foreach ($sepeturunler as $urun) 
        {
            echo "<tr>            
                <td>{$urun['ad']}</td>
                <td>{$urun['sepet_adet']}</td>
                <td><img src='{$urun['foto']}' style='height:100px;width:100px;'></td>
                <td>
                <a href='sepetSil.php?urun_id={$urun['urun_id']}'>Sepetimden çıkar</a>
                </td>
            </tr>";
  
        }
}    
?>