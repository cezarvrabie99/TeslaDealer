<?php
require('fpdf.php');
define('EURO', chr(128) );
const EURO_VAL = 4.93;

class PDF_Invoice extends FPDF
{
    var int $angle=0;

    function RoundedRect($x, $y, $w, $h, $r, $style = '')
    {
        $k = $this->k;
        $hp = $this->h;
        if($style=='F')
            $op='f';
        elseif($style=='FD' || $style=='DF')
            $op='B';
        else
            $op='S';
        $MyArc = 4/3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2F %.2F m',($x+$r)*$k,($hp-$y)*$k ));
        $xc = $x+$w-$r ;
        $yc = $y+$r;
        $this->_out(sprintf('%.2F %.2F l', $xc*$k,($hp-$y)*$k ));

        $this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);
        $xc = $x+$w-$r ;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-$yc)*$k));
        $this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);
        $xc = $x+$r ;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2F %.2F l',$xc*$k,($hp-($y+$h))*$k));
        $this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);
        $xc = $x+$r ;
        $yc = $y+$r;
        $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$yc)*$k ));
        $this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1*$this->k, ($h-$y1)*$this->k,
            $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
    }

    function Rotate($angle, $x=-1, $y=-1)
    {
        if($x==-1)
            $x=$this->x;
        if($y==-1)
            $y=$this->y;
        if($this->angle!=0)
            $this->_out('Q');
        $this->angle=$angle;
        if($angle!=0)
        {
            $angle*=M_PI/180;
            $c=cos($angle);
            $s=sin($angle);
            $cx=$x*$this->k;
            $cy=($this->h-$y)*$this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
        }
    }

    function _endpage()
    {
        if($this->angle!=0)
        {
            $this->angle=0;
            $this->_out('Q');
        }
        parent::_endpage();
    }



    function addCompany($name, $address)
    {
        $x1 = 10;
        $y1 = 8;
        $this->SetXY($x1, $y1);
        $this->SetFont('Arial','B',12);
        $length = $this->GetStringWidth($name);
        $this->setTextColor(232, 33, 39);
        $this->Cell( $length, 2, $name);
        $this->setTextColor(0, 0, 0);
        $this->SetXY($x1, $y1 + 4);
        $this->SetFont('Arial','',10);
        $length = $this->GetStringWidth($address);
        $this->MultiCell($length, 4, $address);
    }

    function fact($name, $code)
    {
        $r1  = $this->w - 80;
        $r2  = $r1 + 68;
        $y1  = 6;
        $y2  = $y1 + 2;

        $texte  = $name . "in " . EURO . " NR " . $code;
        $szfont = 12;
        $loop   = 0;

        while ( $loop == 0 )
        {
            $this->SetFont( "Arial", "B", $szfont );
            $sz = $this->GetStringWidth( $texte );
            if ( ($r1+$sz) > $r2 )
                $szfont --;
            else
                $loop ++;
        }

        $this->SetLineWidth(0.1);
        $this->SetFillColor(192);
        $this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 2.5, 'DF');
        $this->SetXY( $r1+1, $y1+2);
        $this->Cell($r2-$r1 -1,5, $texte, 0, 0, "C" );
    }

    function addDate( $date )
    {
        $r1  = $this->w - 61;
        $r2  = $r1 + 30;
        $y1  = 17;
        $y2  = $y1 ;
        $mid = $y1 + ($y2 / 2);
        $this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
        $this->Line( $r1, $mid, $r2, $mid);
        $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+3 );
        $this->SetFont( "Arial", "B", 10);
        $this->Cell(10,5, "DATA", 0, 0, "C");
        $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+9 );
        $this->SetFont( "Arial", "", 10);
        $this->Cell(10,5,$date, 0,0, "C");
    }

    function addClient( $ref )
    {
        $r1  = $this->w - 31;
        $r2  = $r1 + 19;
        $y1  = 17;
        $y2  = $y1;
        $mid = $y1 + ($y2 / 2);
        $this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
        $this->Line( $r1, $mid, $r2, $mid);
        $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+3 );
        $this->SetFont( "Arial", "B", 10);
        $this->Cell(10,5, "CLIENT", 0, 0, "C");
        $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1 + 9 );
        $this->SetFont( "Arial", "", 10);
        $this->Cell(10,5,$ref, 0,0, "C");
    }

    function addPageNumber( $page )
    {
        $r1  = $this->w - 80;
        $r2  = $r1 + 19;
        $y1  = 17;
        $y2  = $y1;
        $mid = $y1 + ($y2 / 2);
        $this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
        $this->Line( $r1, $mid, $r2, $mid);
        $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+3 );
        $this->SetFont( "Arial", "B", 10);
        $this->Cell(10,5, "PAG", 0, 0, "C");
        $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1 + 9 );
        $this->SetFont( "Arial", "", 10);
        $this->Cell(10,5,$page, 0,0, "C");
    }

    function addClientAddress($address)
    {
        $r1 = $this->w - 80;
        $y1 = 40;
        $this->SetXY( $r1, $y1);
        $this->MultiCell( 60, 4, $address);
    }

    function addPaymentType($mode)
    {
        $r1  = 10;
        $r2  = $r1 + 60;
        $y1  = 80;
        $y2  = $y1+10;
        $mid = $y1 + (($y2-$y1) / 2);
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
        $this->Line( $r1, $mid, $r2, $mid);
        $this->SetXY( $r1 + ($r2-$r1)/2 -5 , $y1+1 );
        $this->SetFont( "Arial", "B", 10);
        $this->Cell(10,4, "MOD DE PLATA", 0, 0, "C");
        $this->SetXY( $r1 + ($r2-$r1)/2 -5 , $y1 + 5 );
        $this->SetFont( "Arial", "", 10);
        $this->Cell(10,5,$mode, 0,0, "C");
    }

    function addInvoiceDate($date)
    {
        $r1  = 80;
        $r2  = $r1 + 40;
        $y1  = 80;
        $y2  = $y1+10;
        $mid = $y1 + (($y2-$y1) / 2);
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
        $this->Line( $r1, $mid, $r2, $mid);
        $this->SetXY( $r1 + ($r2 - $r1)/2 - 5 , $y1+1 );
        $this->SetFont( "Arial", "B", 10);
        $this->Cell(10,4, "DATA PLATII", 0, 0, "C");
        $this->SetXY( $r1 + ($r2-$r1)/2 - 5 , $y1 + 5 );
        $this->SetFont( "Arial", "", 10);
        $this->Cell(10,5,$date, 0,0, "C");
    }

    function addNumTVA($tva)
    {
        $this->SetFont( "Arial", "B", 10);
        $r1  = $this->w - 80;
        $r2  = $r1 + 70;
        $y1  = 80;
        $y2  = $y1+10;
        $mid = $y1 + (($y2-$y1) / 2);
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
        $this->Line( $r1, $mid, $r2, $mid);
        $this->SetXY( $r1 + 16 , $y1+1 );
        $this->Cell(40, 4, "TVA INTRACOMUNICAR", '', '', "C");
        $this->SetFont( "Arial", "", 10);
        $this->SetXY( $r1 + 16 , $y1+5 );
        $this->Cell(40, 5, $tva, '', '', "C");
    }

    function addCols( $tab )
    {
        global $colonnes;

        $r1  = 10;
        $r2  = $this->w - ($r1 * 2) ;
        $y1  = 100;
        $y2  = $this->h - 50 - $y1;
        $this->SetXY( $r1, $y1 );
        $this->Rect( $r1, $y1, $r2, $y2, "D");
        $this->Line( $r1, $y1+6, $r1+$r2, $y1+6);
        $colX = $r1;
        $colonnes = $tab;

        foreach ($tab as  $lib=>$pos)
        {
            $this->SetXY( $colX, $y1+2 );
            $this->Cell( $pos, 1, $lib, 0, 0, "C");
            $colX += $pos;
            $this->Line( $colX, $y1, $colX, $y1+$y2);
        }
    }

    function addLineFormat( $tab )
    {
        global $format, $colonnes;

        /*while ( list( $lib, $pos ) = each ($colonnes) )*/
        foreach ($colonnes as $lib=>$pos)
        {
            if ( isset( $tab["$lib"] ) )
                $format[ $lib ] = $tab["$lib"];
        }
    }



    function addLine( $ligne, $tab )
    {
        global $colonnes, $format;

        $ordonnee = 10;
        $maxSize = $ligne;

        reset( $colonnes );

        foreach ($colonnes as $lib=>$pos)
        {
            $longCell  = $pos -2;
            $texte     = $tab[ $lib ];
            $formText  = $format[ $lib ];
            $this->SetXY( $ordonnee, $ligne-1);
            $this->MultiCell( $longCell, 4 , $texte, 0, $formText);
            if ( $maxSize < ($this->GetY()  ) )
                $maxSize = $this->GetY() ;
            $ordonnee += $pos;
        }
        return ($maxSize - $ligne);
    }

    function addTotalTable()
    {
        $r1  = $this->w - 70;
        $r2  = $r1 + 60;
        $y1  = $this->h - 40;
        $y2  = $y1+20;
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
        $this->Line( $r1+20,  $y1, $r1+20, $y2); // avant EUROS
        $this->Line( $r1+20, $y1+4, $r2, $y1+4); // Sous Euros & Francs
        $this->Line( $r1+38,  $y1, $r1+38, $y2); // Entre Euros & Francs
        $this->SetFont( "Arial", "B", 8);
        $this->SetXY( $r1+22, $y1 );
        $this->Cell(15,4, "EURO", 0, 0, "C");
        $this->SetFont( "Arial", "", 8);
        $this->SetXY( $r1+42, $y1 );
        $this->Cell(15,4, "RON", 0, 0, "C");
        $this->SetFont( "Arial", "B", 6);
        $this->SetXY( $r1, $y1+5 );
        $this->Cell(20,4, "Total(fara TVA)", 0, 0, "C");
        $this->SetXY( $r1, $y1+10 );
        $this->Cell(20,4, "TVA", 0, 0, "C");
        $this->SetXY( $r1, $y1+15 );
        $this->Cell(20,4, "Total(cu TVA)", 0, 0, "C");
    }

    function addTotal($price)
    {
        $vat = round((19/100) * $price, 2);
        $fprice = round($vat + $price, 2);
        $pricer = round($price * EURO_VAL, 2);
        $vatr = round($vat * EURO_VAL, 2);
        $fpricer = round($fprice * EURO_VAL, 2);
        $this->SetFont('Arial','',8);

        $re  = $this->w - 50;
        $rf  = $this->w - 29;
        $y1  = $this->h - 40;
        $this->SetFont( "Arial", "", 8);
        $this->SetXY( $re, $y1+5 );
        $this->Cell( 17,4, $price, '', '', 'R');
        $this->SetXY( $re, $y1+10 );
        $this->Cell( 17,4, $vat, '', '', 'R');
        $this->SetXY( $re, $y1+14.8 );
        $this->Cell( 17,4, $fprice, '', '', 'R');
        $this->SetXY( $rf, $y1+5 );
        $this->Cell( 17,4,$pricer, '', '', 'R');
        $this->SetXY( $rf, $y1+10 );
        $this->Cell( 17,4,$vatr, '', '', 'R');
        $this->SetXY( $rf, $y1+14.8 );
        $this->Cell( 17,4,$fpricer, '', '', 'R');
    }

    function waterMark($texte)
    {
        $this->SetFont('Arial','B',50);
        $this->SetTextColor(203,203,203);
        $this->Rotate(45,55,190);
        $this->Text(95,190,$texte);
        $this->Rotate(0);
        $this->SetTextColor(0,0,0);
    }
}