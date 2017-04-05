<?php 
// Include the main TCPDF library (search for installation path).
require_once('lib/tcpdf/tcpdf.php');


/**
*  pdf
*/
class MYPDF extends TCPDF {
    


    //get max height
    public function getmaxH(array $txt, array $width)
    {
        $maxi=0;
        $i=0;
        $num_txt = count($txt);

        for ($i=0;$i<$num_txt; $i++) 
        {
            $comp=$this->getNumLines($txt[$i], $width[$i]);
            if ($comp>$maxi)
            {
                $maxi=$comp;    
            }

        }
        return $maxi*6;

    }
}

$heads = $_POST['head'];
$data = json_decode($_POST['data'], true);
$titles =json_decode($_POST['titles'], true);
$w = json_decode($_POST['widthTitles'], true);

$pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);
// set default header data
$pdf->SetHeaderData("../../../../img/Snor.PNG", 20,"Snorsoft",$heads);
$pdf->SetMargins(8, 20, 8);

$pdf->Addpage();

/*
:MultiCell    (       $w,
    $h,
    $txt,
    $border = 0,
    $align = ‘J’,
    $fill = false,
    $ln = 1,
    $x = “,
    $y = “,
    $reseth = true,
    $stretch = 0,
    $ishtml = false,
    $autopadding = true,
    $maxh = 0,
    $valign = ’T’,
    $fitcell = false 
) 



TCPDF::Cell (       $w,
    $h = 0,
    $txt = “,
    $border = 0,
    $ln = 0,
    $align = “,
    $fill = false,
    $link = “,
    $stretch = 0,
    $ignore_min_height = false,
    $calign = ’T’,
    $valign = ’M’ 
)             
*/ 
// data of titles
$num_headers = count($titles);
//$w = array(10,25,25, 55,30,30,20);
//$pdf->SetFillColor(183, 66, 66);
$colorHeads=$_COOKIE["color"];
$pdf->SetFillColor($colorHeads[0],$colorHeads[1],$colorHeads[2]);
$pdf->SetTextColor(255);
$pdf->SetDrawColor(128, 0, 0);
$pdf->SetLineWidth(0.3);
// maxheight
$heightTitles=$pdf->getmaxH($titles,$w);

for ($i=0; $i <$num_headers ; $i++) 
{ 
    # code...
    $pdf->MultiCell($w[$i],$heightTitles,$titles[$i], 1, 'C', true,0);
}   
$pdf->Ln();
// Color and font restoration
$pdf->SetFillColor(224, 235, 255);
$pdf->SetTextColor(0);
$pdf->SetDrawColor(0);
$pdf->SetFont('');



//data paint
$dimensions = $pdf->getPageDimensions();
$hasborder = false; //flag for fringe case
foreach($data as $row) {
    $rowcount = 0;
    //256 max Y
    //work out the number of lines required
    $rowcount = $pdf->getmaxH($row,$w);
    $num_cols = count($row);
 
    $startY = $pdf->GetY();
 
    if (($startY + $rowcount) + $dimensions['bm'] +$heightTitles> ($dimensions['hk'])) {
        //this row will cause a page break, draw the bottom border on previous row and give this a top border
        //we could force a page break and rewrite grid headings here
        if ($hasborder) {
            $hasborder = false;
        } else {
            $pdf->Cell(195,0,'','T'); //draw bottom border on previous row
            $pdf->Addpage();
            $startY=0;
        }
        $borders = 'LRTB';
    } elseif ((ceil($startY) + $rowcount) + $dimensions['bm'] +$heightTitles== floor($dimensions['hk'])) {
        //fringe case where this cell will just reach the page break
        //draw the cell with a bottom border as we cannot draw it otherwise
        $borders = 'LRB';   
        $hasborder = true; //stops the attempt to draw the bottom border on the next row
    } else {
        //normal cell
        $borders = 'LRB';
    }
    
    //now draw it
      for ($i=0; $i <$num_cols ; $i++) 
    { 
        $altira=($startY + $rowcount) + $dimensions['bm'];
        // if ($i==6) 
        // {
                
        //     $pdf->MultiCell($w[$i],$rowcount,$altira,$borders,'L',0,0);
        // }
        // else
        // {
            $pdf->MultiCell($w[$i],$rowcount,$row[$i],$borders,'L',0,0);
        // }
    }
    $pdf->Ln();
} 


$pdf->Output('informe.pdf', 'I');
?>  