
<?php
    require('tfpdf/tfpdf.php');

    $pdf = new tFPDF();
    $pdf->AddPage();
    $pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
    $pdf->SetFont('DejaVu','',14);

    session_start();

    $db = new PDO("mysql:host=localhost;dbname=ali_oturum",'root','');
    $kullanici_id = $_SESSION['kullanici_id'];

    $sepetlist = $db->query("SELECT urunler.*, sepet.sepet_adet FROM sepet JOIN urunler ON sepet.urun_id = urunler.urun_id WHERE sepet.kullanici_id = $kullanici_id"); //db yi listeleyip urun bilgileri çekme
    $sepeturunler = $sepetlist->fetchAll(PDO::FETCH_ASSOC);

    foreach ($sepeturunler as $urun) {          // her ürün için db den alınan veriyi kullanarak hesaplama

        $urun_toplam_tutar = $urun['fiyat'] * $urun['sepet_adet'];

        $pdf->Cell(0, 10, "Ad: " . $urun['ad'],0,0,'C');
        $pdf->Ln(6); 
        
        
        $pdf->Cell(0, 10, "Fiyat: " . $urun['fiyat'],0,0,'C');
        $pdf->Ln(6); 

        $pdf->Cell(0, 10, "Adet: " . $urun['sepet_adet'],0,0,'C');
        $pdf->Ln(6); 
        
        
        $pdf->Cell(0, 10, "Tutar: " . $urun_toplam_tutar . " TL",0,0,'C');
        $pdf->Ln(8);
    }

    
    $pdf->Ln(8);
    if (isset($_SESSION['toplam_tutar'])) {
        $sepet_toplam_tutar = $_SESSION['toplam_tutar'];
        $pdf->Cell(0,30, "Toplam Tutar: " . $sepet_toplam_tutar . " TL",0, 1, 'C');
    }
    else {
        $pdf->Cell(0, 30, "Toplam Tutar: 0 TL",0, 1, 'C');
    }
    $pdf->Output();
?>