<a href="cikis.php">Oturumu kapat</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="admin.php">Admin sayfasına dön</a>
<br><br>

<?php
session_start();

if($_SESSION["tur"]=='admin')
{
    echo
    "
    <form action='' method='POST'>
    <center><h2>Ürün ekleme sistemi</h2></center>
    <table align='center' border='1'>
    <tr>
        <td>Eklenecek ürünün adı:</td>
        <td><input type='text' name='urn_ad' style='width:150px'></td>
    </tr>
    <tr>
    <td>Eklenecek ürünün serino:</td>
    <td><input type='number' name='urn_serino' style='width:150px'></td>
    </tr>
    <tr>
    <td>Eklenecek ürünün adeti:</td>
    <td><input type='number' name='urn_adet' style='width:150px'></td>
    </tr>
    <tr>
    <td>Eklenecek ürünün fotoğrafı:</td>
    <td><input type='file' name='urn_foto' style='width:150px'></td>
    </tr>
    <tr>
    <td colspan='2' align='center'><input type='submit' name='urunekle' value='Ürün ekle' style='height:50px;width:335px'></td>
    </tr>
    </table>
    </form>
    ";

    if(isset($_POST['urunekle']))
    {
        $db= new PDO("mysql:host=localhost;dbname=ali_oturum",'root','');
        $urn_ad=$_POST['urn_ad'];
        $urn_serino=$_POST['urn_serino'];
        $urn_adet=$_POST['urn_adet'];
        $urn_foto=$_POST['urn_foto'];

        $urunekle = $db->exec("INSERT INTO urunler(serino, adet, foto, ad) VALUES ('$urn_serino', '$urn_adet', '$urn_foto', '$urn_ad')");
        
        if($urunekle)
        {
            echo "Ürün ekleme işlemi başarılı";
        }
        else
        {
            echo "Ürün ekleme sırasında hata oluştu.";
        }
    }
}
else
{
    header('location:giris.php');
    exit;
}
?>


