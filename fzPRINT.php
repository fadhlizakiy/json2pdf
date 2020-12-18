<?php
// set array for X
$arrX = Array();

// initialize PDF class
$pdf = new FadhliZakiy_FPDF($layout,'mm','A4');
$pdf->tableDataTayloring($data);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',20);

$pdf->MultiCell(0,18,$title,0,1);
$pdf->SetFont('Times','',10);


// PRINT HEADER - START
	// PRINT HEADER TEXT - START
	$arrX[count($arrX)] = $pdf->getX();
	$pdf->fzPrintCell($pdf->noWidth,"No. ");
	for($i=0;$i<$pdf->keyLength;$i++)
	{
		$arrX[count($arrX)] = $pdf->getX();
		$pdf->fzPrintCell($pdf->colLength[$i],$pdf->keys[$i]);
	}
	// PRINT HEADER TEXT - END

	// PRINT HEADER COLUMN - START
	$pdf->fzPrintBorder($arrX[0],$pdf->noWidth, $pdf->height);
	for($i=1;$i<count($arrX);$i++)
	{
		$pdf->fzPrintBorder($arrX[$i],$pdf->colLength[$i-1],$pdf->height);
	}
	$pdf->ln();
	// PRINT HEADER COLUMN - END
// PRINT HEADER - END

// PRINT BODY - START
	// INITIALIZE DATA - START
	$count = 1;
	$trv = $data;
	if($pdf->jsonType == 3)
	{
		$trv = $data->features;
	}
	// INITIALIZE DATA - END
	
foreach($trv as $k => $obj)
{
	// PRINT BODY TEXT - START
	$h = 0;
	$h = $pdf->fzPrintCell($pdf->noWidth,$count);
	
	for($i=0;$i<$pdf->keyLength;$i++)
	{
		if($pdf->jsonType == 0)
		{
			$string = $obj;
			$hTemp = $pdf->fzPrintCell($pdf->colLength[$i],$string,$pdf->strLength[$i]);
				
			if($hTemp > $h)
			{
				$h = $hTemp;
			}
		}
		else if($pdf->jsonType == 1)
		{
			if(isset($obj->{$pdf->keys[$i]}))
			{				
				$string = (string) $obj->{$pdf->keys[$i]};
				$hTemp = $pdf->fzPrintCell($pdf->colLength[$i],$string,$pdf->strLength[$i]);
				
				if($hTemp > $h)
				{
					$h = $hTemp;
				}
			}
		}
		else if($pdf->jsonType == 2)
		{
			if($i == 0)
			{
				$string = (string) $k;
			}
			else
			{
				$string = (string) $obj;
			}
			
			$hTemp = $pdf->fzPrintCell($pdf->colLength[$i],$string,$pdf->strLength[$i]);
				
			if($hTemp > $h)
			{
				$h = $hTemp;
			}
		}
		else if($pdf->jsonType == 3)
		{
			$string = "(".$obj->geometry->type.") ";
			$string .= json_encode($obj->geometry->coordinates)." \n";
			foreach($obj->properties as $k2 => $v)
			{
				if(is_array($v) || is_object($v))
				{
					$string .= $k2." : ARRAY, ";
				}
				else
				{
					$string .= $k2." : ".$v.", ";
				}
			}
			
			$hTemp = $pdf->fzPrintCell($pdf->colLength[$i],$string,$pdf->strLength[$i]);
				
			if($hTemp > $h)
			{
				$h = $hTemp;
			}
		}
	}
	// PRINT BODY TEXT - END
	
	// PRINT BODY COLUMN - START
	$pdf->fzPrintBorder($arrX[0],$pdf->noWidth, $h);
	for($i=1;$i<count($arrX);$i++)
	{
		$pdf->fzPrintBorder($arrX[$i],$pdf->colLength[$i-1],$h);
	}
	// PRINT BODY COLUMN - END
	
	$pdf->ln();
		
	$count++;
}
// PRINT BODY - END

$pdf->Output();
?>