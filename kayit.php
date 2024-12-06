<form action="kayit.php" method="post">
<head><title>Kayıt sayfası</title></head>
<table align="center">
<h2 align="center">Kayıt Ol</h2>

<tr>
    <td>
        Kullanıcı Adı:
    </td>
    <td>
        <input type="text" name="ads" style="width:150px">
    </td>
</tr>
<tr>
    <td>
        Sifre:
    </td>
    <td>
        <input type="password" name="sifre" style="width:150px">
    </td>
</tr>
<tr>
    <td colspan="2">
        <input type="submit" name="kayitol" value="Kayıt Ol" style="width:245px">
    </td>
</tr>
<tr>
    <td colspan="2">
        <input type="submit" name="girisedon" value="Giriş Sayfasına Dön" style="width:245px">
    </td>
</tr>
</table>
</form>

<?php
$db= new PDO("mysql:host=localhost;dbname=ali_oturum",'root','');

if(isset($_POST['kayitol']))
{
    $adsoyad=$_POST['ads'];
    $sifre=$_POST['sifre'];
    $k_turu='kullanici';
    
    $ekle = $db->exec("INSERT INTO kullanici(kullaniciAdi, sifre, kullanici_turu) VALUES ('$adsoyad','$sifre','$k_turu')");
    if($ekle){
        echo "Kayit Basarili";
    }
}
if(isset($_POST['girisedon']))
{
    header('location: giris.php');
    exit();
}

?>