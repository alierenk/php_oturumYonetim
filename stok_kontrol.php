<a href="cikis.php">Oturumu kapat</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="admin.php">Admin sayfasına dön</a>
<br><br>


<?php
ob_start();
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
            <td>Ürün Adı</td>
            <td>Adet</td>
            <td>Fotoğraf</td>
            <td>Stok Ekle</td>
            <td>Stok Azalt</td>
        </tr>";

        foreach ($list as $urun) 
        {
            echo "<tr>
                <td>{$urun['urun_id']}</td>
                <td>{$urun['serino']}</td>
                <td>{$urun['ad']}</td>
                <td>{$urun['adet']}</td>
                <td><img src='urunler/{$urun['foto']}' style='height:100px;width:100px;'></td>
                <td>
                    <form action='' method='POST'>
                        <input type='number' name='stok_ekle' min='1' value='1' style='width:50px'>
                        <input type='hidden' name='urun_id' value='{$urun['urun_id']}'>
                        <input type='submit' name='ekle' value='Ekle'>
                    </form>
                </td>
                <td>
                <form action='' method='POST'>
                        <input type='number' name='stok_azalt' min='1' value='1' style='width:50px'>
                        <input type='hidden' name='urun_id' value='{$urun['urun_id']}'>
                        <input type='submit' name='azalt' value='Azalt'>
                    </form>
                </td>
            </tr>";
  
        }   
    }
    if (isset($_POST['ekle'])) {
        $urun_id = $_POST['urun_id'];
        $stok_ekle_sayi =$_POST['stok_ekle'];

        $stokadd = $db->query("UPDATE urunler SET adet = adet + $stok_ekle_sayi WHERE urun_id = $urun_id");

        ob_clean();
        header("Location: stok_kontrol.php");
        exit();
    }
    if (isset($_POST['azalt'])) {
        $urun_id = $_POST['urun_id'];
        $stok_azalt_sayi = (int)$_POST['stok_azalt'];

        $stmt = $db->query("UPDATE urunler SET adet = GREATEST(adet - $stok_azalt_sayi, 0) WHERE urun_id = $urun_id");

        ob_clean();
        header("Location: stok_kontrol.php");
        exit();
    }
}
else
    {
        ob_clean();
        header('Location: giris.php');
        exit;   
    }
?>