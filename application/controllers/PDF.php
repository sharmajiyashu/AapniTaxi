<?php 
require('/home1/molni2j8/www.aapnitaxi.com/source/fpdf/fpdf.php');

class PDF extends FPDF
{
	// Page header
	function Header()
	{
	    
	    //echo APPPATH; die;
	  //$image = 'https://www.aapnitaxi.com/pubilc/invoice/62e785fa56d2a.jpeg';
	  //$path = APPPATH.'../pubilc/invoice/62e785fa56d2a.jpeg';
	  $path = APPPATH.'../public/invoice/62e785fa56d2a.jpeg';
	  $data = $this->parsejpg($path);
	  
	 
	  
	  if(!file_exists($path)){
	      echo 'if'; 
	  }else{
	      echo 'else';
	  }
	  
	  //print_r($path);die;
	  $this->Image($path,10,5,150,0);	
	}
	
	function parsejpg($file)
{
  // Extract info from a JPEG file
  $a = getimagesize($file);
  if(!$a)
    $this->Error('Missing or incorrect image file: '.$file);
  if($a[2]==3) { return $this->_parsepng($file); }
  if($a[2]!=2)
    $this->Error('Not a JPEG file: '.' '.$a[2].' '.$file);
  if(!isset($a['channels']) || $a['channels']==3)
    $colspace = 'DeviceRGB';
  elseif($a['channels']==4)
    $colspace = 'DeviceCMYK';
  else
    $colspace = 'DeviceGray';
  $bpc = isset($a['bits']) ? $a['bits'] : 8;
  $data = file_get_contents($file);
  return array('w'=>$a[0], 'h'=>$a[1], 'cs'=>$colspace, 'bpc'=>$bpc, 'f'=>'DCTDecode', 'data'=>$data);
}
	
}
	// Instanciation of inherited class
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','',2);
	$pdf->Output();
	
// 	$filename = 'invoice';
// 	file_put_contents(base_url().'pubilc/'.$filename.'/'.$filename.".pdf", $pdf->Output());