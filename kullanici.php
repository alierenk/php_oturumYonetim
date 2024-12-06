<html>
    <head>
        <title>Kullanıcı Sayfası</title> 
        <style>
            .favori-mesaj{
            background-color: #4CAF50; 
            color: white; 
            padding: 15px; 
            position: fixed; 
            bottom: 20px; 
            left: 50%;
            transform: translateX(-50%); 
            z-index: 1000; 
            border-radius: 5px
            }
            .favori-red{
            background-color: #FF0000; 
            color: white; 
            padding: 15px; 
            position: fixed; 
            bottom: 20px; 
            left: 50%;
            transform: translateX(-50%); 
            z-index: 1000; 
            border-radius: 5px
            }
        </style>
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
    
    echo "<h2 align='center'>Ürünler</h2>";

    while($row =$listele->fetch())
    {
        $urun_id =$row['urun_id'];
        $urun_serino =$row['serino'];
        $urun_adi =$row['ad'];
        $urun_adet =$row['adet'];
        $urun_foto =$row['foto'];
    
        echo "<table align='center' border='1'>
        <tr>
            <td>
                <img src='$urun_foto' style='height:200px;width:200px'><br>
            </td>
            <td>
                <b>Serino:</b> $urun_serino<br>
                <b>Adı:</b> $urun_adi<br> 
                <b>Adet:</b> $urun_adet<br><br>&nbsp;
                <form action='favoriEkle.php' method='POST'>
                    <input type='hidden' name='urun_id' value='$urun_id'>   
                    <button type='submit' style='border: none; background: none; cursor: pointer;'>
                    <img src='like.png' alt='Favori' style='height:50px;width:50px;'>
                    </button>
                </form>
                
                
                <form action ='sepeteEkle.php' method='POST'style='display: flex; align-items: center;'>
                <input type='hidden' name='urun_id' value='$urun_id'>
                <input type='number' name='adet' style='height: 25px; width: 40px; margin-right: 1px; min='1' value='1''>
                <button type='submit' style='border: none; background: none; cursor: pointer;'>
                    <img src='sepet.png' alt='Favori' style='height:45px;width:45px;'>
                    </button>
                    
                </form>
            </td>
        </tr>
        </table>"; 
    }
}
else
{
    header('location:giris.php');
    exit;
}
?>
</html>