<?php
class FadhliZakiy_FPDF extends FPDF
{
	// Paper width based on Layout
	public $widthPortrait  = 190;		// Length of A4 Portrait
	public $widthLandscape = 277.2;		// Length of A4 Landscape
	
	public $simpleArrayLabel = "Values"; // Simple Array Values
	
	public $jsonType	   = 0;			// 0: simple array, 1: array of object, 2:object , 3: geoJSON
	public $height         = 9;			// Normal height
	public $singleChar     = 2;			// Single character width
	public $singleSpace    = 0.9;		// Single character non-character
	public $minNoWidth     = 9;			// Min Width for Number.
	public $charSavePad    = 2;			// Padding cell
	
	public $noWidth        = 0;			// AUTO populated Width for Number based on data length
	public $keyLength      = 0;			// AUTO populated Number of Keys
	public $dataLength     = 0;			// AUTO populated Number of Data
	
	public $keys		   = Array();	// AUTO populated key string
	public $strLength      = Array();	// AUTO populated Number of character in string
	public $extLength      = Array();	// AUTO populated Number of non-character / whitespace
	public $colLength      = Array();	// AUTO populated Width of each column
	
	// Page footer
	// Add page number
	function Footer()
	{
		// Position at 1.5 cm from bottom
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial','I',8);
		// Page number
		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'R');
	}
	
	// 1. tableDataTayloring
	// Desc : Tayloring Table based on incoming data
	public function tableDataTayloring($data="")
	{
		if($data)
		{
			// set data length
			$this->dataLength = count($data);
			$this->countNoWidth($data);
			
			if(is_object($data))
			{
				if(isset($data->type) && isset($data->features))
				{
					$this->jsonType	   			= 3;
				}
				else
				{
					$this->jsonType	   			= 2;
				}
			}
			else if(is_object($data[0]))
			{
				$this->jsonType	   			= 1;			
			}
			else
			{
				$this->jsonType	   			= 0;
			}
			
			
			$this->countKeyLength($data);
			$this->countColLength($data);
			$this->colNormalize();	
		}
	}
	
	// 2. countNoWidth
	// Desc : Count the Width of Number column
	public function countNoWidth($data)
	{
		$a = strlen((string) $this->dataLength) * $this->singleChar;
		
		if($a < $this->minNoWidth)
		{
			$a = $this->minNoWidth;
		}
		$a += $this->charSavePad;
		
		$this->noWidth = $a;
	}
	
	// 3. countKeyLength
	// Desc : populate the width of column for initial
	public function countKeyLength($data)
	{
		if($this->jsonType == 0)
		{
			$this->keys[0]   = $this->simpleArrayLabel;
			$this->keyLength = 1;
		}
		else if($this->jsonType == 1)
		{
			$this->keys = array_keys(get_object_vars($data[0]));
			$this->keyLength = count($this->keys);
		}
		else if($this->jsonType == 2)
		{
			$this->keys[0]   = "Keys";
			$this->keys[1]   = $this->simpleArrayLabel;
			$this->keyLength = count($this->keys);
		}
		else if($this->jsonType == 3)
		{
			$this->keys[0]   = $this->simpleArrayLabel;
			$this->keyLength = count($this->keys);
		}
		
		for($i=0;$i<$this->keyLength;$i++)
		{
			$this->strLength[$i] = 0;
			$this->extLength[$i] = 0;
			$this->colLength[$i] = (strlen($this->keys[$i])*$this->singleChar) + $this->charSavePad;
			
			if($this->colLength[$i] < $this->minNoWidth)
			{
				$this->colLength[$i] = $this->minNoWidth;
			}
		}
	}
	
	// 4. countColLength
	// Desc : populate the width of column based from data
	public function countColLength($data)
	{
		$trv = $data;
			if($this->jsonType == 3)
			{
				$trv = $data->features;
			}
			
			foreach($trv as $k => $obj)
			{
				for($i=0;$i<$this->keyLength;$i++)
				{
					if($this->jsonType == 0)
					{
						$string       = (string) $obj;
					}
					else if($this->jsonType == 1)
					{
						$string = "";
						$key = $this->keys[$i];
					
						if(isset($obj->{$key}))
						{
							$string       = (string) $obj->{$key};
						}
					}
					else if($this->jsonType == 2)
					{
						if($i == 0)
						{
							$string       = (string) $k;
						}
						else
						{
							$string       = (string) $obj;
						}
					}
					else if($this->jsonType == 3)
					{
						$string = "(".$obj->geometry->type.") ";
						$string .= json_encode($obj->geometry->coordinates)." \n";
						foreach($obj->properties as $k => $v)
						{
							if(is_array($v) || is_object($v))
							{
								$string .= $k." : ARRAY, ";
							}
							else
							{
								$string .= $k." : ".$v.", ";
							}
						}
					}
					
					$strlen       = strlen($string);
					$stringLength = $strlen * $this->singleChar;
					
					$strSpace     = substr_count($string, " ");
					$strStripe    = substr_count($string, "-");
					$strSlash     = substr_count($string, "/");
					
					
					//$extra 		 = $strSpace;
					$extra 		 = $strSpace + $strStripe + $strSlash;
					$extraLength = $extra * $this->singleSpace;
					
					$length = ($stringLength - $extraLength) + $this->charSavePad;
					
					if($strlen > $this->strLength[$i])
					{
						$this->strLength[$i] = $strlen;
					}
					
					if($length > $this->colLength[$i])
					{
						$this->colLength[$i] = $length;
					}
					
					if($extra > $this->extLength[$i])
					{
						$this->extLength[$i] = $extra;
					}
				}
			}
	}
	
	// 5. colNormalize
	// Desc : Normalize additional based on the fitting algorithm
	public function colNormalize()
	{
		$length = array_sum($this->colLength) + $this->noWidth;
		
		$maxLength = $this->widthPortrait;
		if($this->DefOrientation == 'L')
		{
			$maxLength = $this->widthLandscape;
		}
		
		if($length > $maxLength)
		{
			$reduceColPerExtra = ($length - $maxLength)/array_sum($this->extLength);
			for($i=0;$i<$this->keyLength;$i++)
			{
				$reduction = $reduceColPerExtra*$this->extLength[$i];
				$charLoss  = ceil($reduction/$this->singleChar);
				
				if($reduction > 0)
				{
					$this->colLength[$i] = $this->colLength[$i] - ($reduceColPerExtra*$this->extLength[$i]);
					$this->strLength[$i] = $this->strLength[$i] - $charLoss - 2;
				}	
			}
		}
		
	}
	
	// 6. fzPrintCell
	// Desc : Print Cell with auto wrap
	public function fzPrintCell($w,$t,$m = 99999)
	{		
		$x = $this->GetX();
		
		$maxM = 99; // Portrait
		if($this->DefOrientation == 'L')
		{
			$maxM = 165;
		}
			
		if($m > $maxM)
		{
			$m = $maxM;
		}
		
		if(strlen($t) > $m)
		{
			$height 	= $this->height/3;
			$totalLine  = ceil($t/$m);
			$txt 		= str_split($t,$m);
			
			for($i=0;$i<count($txt);$i++)
			{
				$h = ($height*(2.5*$i+1))+3;
				$this->SetX($x);
				$this->Cell($w,$h,$txt[$i],'','','');
			}
			
			$h = ($height*(2.5*$i+1))/2;
			
			return $h;
		}
		else
		{
			$this->SetX($x);
			$this->Cell($w,$this->height,$t,'','','');
			
			return $this->height;
		}
	}
	
	// 7. fzPrintCell
	// Desc : Print Cell with auto wrap
	public function fzPrintBorder($x, $w, $h)
	{
		$this->SetX($x);
		$this->Cell($w,$h,'','LTRB',0,'L',0);
	}
}

function get_client_ip() 
{
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
?>
