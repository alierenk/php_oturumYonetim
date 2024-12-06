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
    <center><h2>Ürün silme sistemi</h2></center>
    <table align='center' border='1'>
    <tr>
    <td>Silmek istediğiniz ürünün ID sini giriniz:</td>
    <td><input type='number' name='urn_sil_id'></td>
    </tr>
    <tr>
    <td colspan='2' align='center'><input type='submit' name='sil' value='Ürünü Sil' style='height:30px;width:444px'></td>
    </tr>
    </table>
    </form> 
    ";

    if(isset($_POST['sil']))
    {
        $db= new PDO("mysql:host=localhost;dbname=ali_oturum",'root','');

        $sil_id=$_POST['urn_sil_id'];
        $favoriden_urun_sil=$db->exec("DELETE FROM favori WHERE urun_id =$sil_id");
        $urunsil=$db->exec("DELETE FROM urunler WHERE urun_id = $sil_id");
        
        if($urunsil && $favoriden_urun_sil)
        {
            echo "Ürün silme işlemi başarılı";
        }
    }
}
else
{
    header('location:giris.php');
    exit;
}
?>