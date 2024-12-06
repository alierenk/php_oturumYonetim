<a href="cikis.php">Oturumu kapat</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="admin.php">Admin sayfasına dön</a>
<br><br>

<?php

session_start();
if($_SESSION["tur"]=='admin')
{
    $db= new PDO("mysql:host=localhost;dbname=ali_oturum",'root','');

    $admin_listele=$db->query("SELECT * FROM urunler");
    $list = $admin_listele->fetchAll(PDO::FETCH_ASSOC);

    if (count($list) > 0)
 {
    echo "<table align='center' border='1'>
        <tr>
            <td>Ürün ID</td>
            <td>Serino</td>
            <td>Adı</td>
            <td>Adet</td>
            <td>Fotoğraf</td>
        </tr>";
 
        foreach ($list as $urun) 
        {
            echo "<tr>
                <td>{$urun['urun_id']}</td>
                <td>{$urun['serino']}</td>
                <td>{$urun['ad']}</td>
                <td>{$urun['adet']}</td>
                <td><img src='{$urun['foto']}' style='height:100px;width:100px;'></td>
            </tr>";
  
        }     
}
}
else
{
    header('location:giris.php');
    exit;
}
?>