<a href="cikis.php">Oturumu kapat</a>

<br><br>

<?php

session_start();
if($_SESSION["tur"]=='admin')
{
echo "<center><b>Admin Sayfasi</b></center><br>";

echo "<table align='center' border='0'>
    <tr>
        <td>
        Ürün eklemek için:
        </td>
        <td>
        <a href='urunekle.php'>
        Tıklayınız
        </a>
        </td>
    </tr>
    <tr>
        <td>
        Ürün silmek için:
        </td>
        <td>
        <a href='urunsil.php'>
        Tıklayınız
        </a>
        </td>
    </tr>
    <tr>
    <td>
        Ürünleri görmek için 
    </td>
    <td>
    <a href='admin_list_urun.php'>Tıklayınız</a>
    </td>
    </tr>
</table>";
}
else
{
    header('location:giris.php');
    exit;
}


?>