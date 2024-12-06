<html>
<head>
    <title>Giris sayfasi</title>
</head>

<form action="giris.php" method="post">

<table align="center">
<h2 align="center">Giriş yap</h2>
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
        <input type="submit" name="giris" value="Login" style="width:245px">
    </td>
</tr>
<tr>
    <td colspan="2">
        <input type="submit" name="kayit" value="Kayıt Ol" style="width:245px">
    </td>
</tr>
</table>

</form>

<?php

if(isset($_POST['kayit']))
{
    header("Location: kayit.php");
}

if(isset($_POST['giris']))
{
    session_start();
    $kullanici_adi=$_POST['ads'];
    $sifre=$_POST['sifre'];

    $list = new PDO("mysql:host=localhost;dbname=ali_oturum",'root','');
    $listele = $list-> query("SELECT * FROM kullanici");

    while($row =$listele->fetch())
    {
        if($kullanici_adi==$row['kullaniciAdi'] && $sifre ==$row['sifre'])
        {   
            $_SESSION['kullanici_id']=$row['kullanici_id'];
            $_SESSION["kullaniciadi"]=$kullanici_adi;
            $_SESSION["kullanicisifre"]=$sifre;
            $_SESSION["tur"] =$row['kullanici_turu'];

            if($row['kullanici_turu']=='admin')
            {
                header('location: admin.php');
            }
            elseif($row['kullanici_turu']=='kullanici')
            {
                header('location: kullanici.php');
            }
            elseif($row['kullanici_turu']=='moderator')
            {
                header('location: moderator.php');
            }
        }
        else
        {
            echo "Giriş Başarısız Yanlış kullanıcı adı veya şifre";
        }
    }
}

?>
</html>