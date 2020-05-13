<?php
class CCommon 
{
	public function __construct()
    {
    }
	
	public function NumberToWord($number,$Currency)
	{
		$hyphen      = '-';
		$conjunction = ' and ';
		$separator   = ', ';
		$negative    = 'negative ';
		$decimal     = ' taka ';
		$paisa     = ' paisa ';
		if($Currency=="USD" || $Currency=="AUD" || $Currency=="EUR")
		{
			$decimal     = ' '.$Currency.' ';
			$paisa     = ' cent ';
		}
		$dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'forty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
		100000              => 'lac',
        10000000            => 'crore'
   		 );
		 if (!is_numeric($number))
		 {
       		return false;
   		 }
   
   		if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX)
		 {
        	trigger_error('convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, cE_USER_WARNING);
       		return false;
   		 }

    	if ($number < 0)
		{
       		return $negative . $this->NumberToWord($number*-1,$Currency);
    	}
   
   	 	$string = $fraction = null;
   
    	if (strpos($number, '.') !== false)
		{
        	list($number, $fraction) = explode('.', $number);
   		}
   
    	switch (true) 
		{
        	case $number < 21:
            	$string = $dictionary[$number];
            	break;
        	case $number < 100:
           		$tens   = ((int) ($number / 10)) * 10;
            	$units  = $number % 10;
            	$string = $dictionary[$tens];
            	if ($units)
				{
                	$string .= $hyphen . $dictionary[$units];
            	}
            	break;
        	case $number < 1000:
            	$hundreds  = $number / 100;
            	$remainder = $number % 100;
            	$string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            	if ($remainder)
				{
                	$string .= ' ' .$this->NumberToWord($remainder,$Currency);
            	}
           		break;
			case $number < 100000:
				$thousand  = $number / 1000;
            	$remainder = $number % 1000;
            	$string =$this->NumberToWord((int)$thousand,$Currency). ' ' . $dictionary[1000];
            	if ($remainder)
				{
                	$string .= ' '.$this->NumberToWord($remainder,$Currency);
            	}
           		break;
			case $number < 10000000:
				$lac  = $number / 100000;
            	$remainder = $number % 100000;
            	$string = $this->NumberToWord((int)$lac,$Currency). ' ' . $dictionary[100000];
            	if ($remainder)
				{
                	$string .= ' ' .$this->NumberToWord($remainder,$Currency);
            	}
           		break;
			case $number > 10000000:
				$crore  = $number / 10000000;
            	$remainder = $number % 10000000;
            	$string = $this->NumberToWord((int)$crore,$Currency). ' ' . $dictionary[10000000];
            	if ($remainder)
				{
                	$string .= ' ' .$this->NumberToWord($remainder,$Currency);
            	}
           		break;
        	default:
            	$baseUnit = pow(10000000, floor(log($number, 10000000)));
            	$numBaseUnits = (int) ($number / $baseUnit);
           		$remainder = $number % $baseUnit;
            	$string = $this->NumberToWord($numBaseUnits,$Currency) . ' ' . $dictionary[$baseUnit];
            	if ($remainder) 
				{
                	$string .= $remainder < 100 ? $conjunction : $separator;
                	$string .= $this->NumberToWord($remainder,$Currency);
           		}
           	 	break;
    	}
   			
		if (is_numeric($fraction)) 
		{
			$string .= $decimal;

			$words =$this->NumberToWord((int)$fraction,$Currency);

			$string .= $conjunction . $words . $paisa;
		}
   		return $string;
	}
	
	public function ReadAllSelectedOption($Sql,$Value,$Display,$Selected,$Split)
	{
		$disp = explode("^",$Display);
		$oBasic=new CBasic();
		$oResult=$oBasic->SqlQuery($Sql);
		if($oResult->IsSuccess)
		{			
			for($i=0;$i<$oResult->num_rows;$i++)
			{
				if($oResult->rows[$i][$Value]==$Selected)
				{
					echo "<option value='".$oResult->rows[$i][$Value]."' selected='selected' title='".$oResult->rows[$i][$Value]."'>";
					for($j=0;$j<count($disp);$j++)
					{
						if($j) echo $Split;
						echo $oResult->rows[$i][$disp[$j]];
					}
					echo"</option>";
				}
				else 
				{
					echo "<option value='".$oResult->rows[$i][$Value]."' title='".$oResult->rows[$i][$Value]."'>";
					for($j=0;$j<count($disp);$j++)
					{
						if($j) echo $Split;
						echo $oResult->rows[$i][$disp[$j]];
					}
					echo"</option>";
				}
			}
		}
	}
	
	public function AddPlayTime($times) {
		$minutes = 0;
		foreach ($times as $time) {
			list($hour, $minute) = explode(':', $time);
			$minutes += $hour * 60;
			$minutes += $minute;
		}

		$hours = floor($minutes / 60);
		$minutes -= $hours * 60;

		return sprintf('%02d:%02d', $hours, $minutes);
	}
	
	public function getReg()
	{
		$oBasic=new CBasic();
		$oResult=new CResult();
		$dt=date('Y');
		$dt1=substr(date('Y'),2);
		$sql="SELECT MAX(reg) AS FormNo FROM student ";
		$oResult=$oBasic->SqlQuery($sql);
		if($oResult->IsSuccess)
		{ 
			if($oResult->num_rows>0)
			{
				$FormNo=$oResult->row["FormNo"];
				if($FormNo)
				{
					$FormNo=substr($FormNo, strlen($dt))+1;
					if(strlen($FormNo)==3)
						return $dt.'0'.$FormNo;
					elseif(strlen($FormNo)==4)
						return $dt.$FormNo;
				}
				else
				{
					return $dt.'1001';	
				}
			}
			
		}
		else
		{
			echo ("<script>window.alert(\"Error-".$oResult->message." ".$oResult->error."\");</script>");
		}
	}
	
	public function getFacNo()
	{
		$oBasic=new CBasic();
		$oResult=new CResult();
		//$dt=date('Y');
		//$dt1=substr(date('Y'),2);
		$sql="SELECT MAX(fac_id) AS TechNo FROM faculty";
		$oResult=$oBasic->SqlQuery($sql);
		if($oResult->IsSuccess)
		{ 
			if($oResult->num_rows>0)
			{
				$TechNo=$oResult->row["TechNo"];
				if($TechNo)
				{
					$TechNo=$TechNo+1;
					return $TechNo;
				}
				else
				{
					return '10001';	
				}
			}
		}
		else
		{
			echo ("<script>window.alert(\"Error-".$oResult->message." ".$oResult->error."\");</script>");
		}
	}
	
	public function getUgRegNo()
	{
		$oBasic=new CBasic();
		$oResult=new CResult();
		//$dt=date('Y');
		//$dt1=substr(date('Y'),2);
		$sql="SELECT MAX(reg) AS TechNo FROM student";
		$oResult=$oBasic->SqlQuery($sql);
		if($oResult->IsSuccess)
		{ 
			if($oResult->num_rows>0)
			{
				$TechNo=$oResult->row["TechNo"];
				if($TechNo)
				{
					$TechNo=$TechNo+1;
					return $TechNo;
				}
				else
				{
					return '20140001';	
				}
			}
		}
		else
		{
			echo ("<script>window.alert(\"Error-".$oResult->message." ".$oResult->error."\");</script>");
		}
	}
	
	public function getGrRegNo()
	{
		$oBasic=new CBasic();
		$oResult=new CResult();
		//$dt=date('Y');
		//$dt1=substr(date('Y'),2);
		$sql="SELECT MAX(reg) AS TechNo FROM studentg";
		$oResult=$oBasic->SqlQuery($sql);
		if($oResult->IsSuccess)
		{ 
			if($oResult->num_rows>0)
			{
				$TechNo=SUBSTR($oResult->row["TechNo"],6);
				if($TechNo)
				{
					$TechNo=$TechNo+1;
					return '2020G0'.$TechNo;
				}
				else
				{
					return '20200001';	
				}
			}
		}
		else
		{
			echo ("<script>window.alert(\"Error-".$oResult->message." ".$oResult->error."\");</script>");
		}
	}
	
	public function getAdjFacNo()
	{
		$oBasic=new CBasic();
		$oResult=new CResult();
		//$dt=date('Y');
		//$dt1=substr(date('Y'),2);
		$sql="SELECT MAX(fac_id) AS TechNo FROM adj_faculty";
		$oResult=$oBasic->SqlQuery($sql);
		if($oResult->IsSuccess)
		{ 
			if($oResult->num_rows>0)
			{
				$TechNo=$oResult->row["TechNo"];
				if($TechNo)
				{
					$TechNo=$TechNo+1;
					return $TechNo;
				}
				else
				{
					return '40001';	
				}
			}
		}
		else
		{
			echo ("<script>window.alert(\"Error-".$oResult->message." ".$oResult->error."\");</script>");
		}
	}
	
	
	public function getManNo()
	{
		$oBasic=new CBasic();
		$oResult=new CResult();
		//$dt=date('Y');
		//$dt1=substr(date('Y'),2);
		$sql="SELECT MAX(man_id) AS ManNo FROM management";
		$oResult=$oBasic->SqlQuery($sql);
		if($oResult->IsSuccess)
		{ 
			if($oResult->num_rows>0)
			{
				$ManNo=$oResult->row["ManNo"];
				if($ManNo)
				{
					$ManNo=$ManNo+1;
					return $ManNo;
				}
				else
				{
					return '20001';	
				}
			}
		}
		else
		{
			echo ("<script>window.alert(\"Error-".$oResult->message." ".$oResult->error."\");</script>");
		}
	}
	
	public function getStfNo()
	{
		$oBasic=new CBasic();
		$oResult=new CResult();
		//$dt=date('Y');
		//$dt1=substr(date('Y'),2);
		$sql="SELECT MAX(staff_id) AS StfNo FROM generate_id";
		$oResult=$oBasic->SqlQuery($sql);
		if($oResult->IsSuccess)
		{ 
			if($oResult->num_rows>0)
			{
				$StfNo=$oResult->row["StfNo"];
				if($StfNo)
				{
					$StfNo=$StfNo+1;
					return $StfNo;
				}
				else
				{
					return '20001';	
				}
			}
		}
		else
		{
			echo ("<script>window.alert(\"Error-".$oResult->message." ".$oResult->error."\");</script>");
		}
	}
	
	public function getManagementNo()
	{
		$oBasic=new CBasic();
		$oResult=new CResult();
		//$dt=date('Y');
		//$dt1=substr(date('Y'),2);
		$sql="SELECT MAX(staff_id) AS StfNo FROM man_generate_id";
		$oResult=$oBasic->SqlQuery($sql);
		if($oResult->IsSuccess)
		{ 
			if($oResult->num_rows>0)
			{
				$StfNo=$oResult->row["StfNo"];
				if($StfNo)
				{
					$StfNo=$StfNo+1;
					return $StfNo;
				}
				else
				{
					return '10001';	
				}
			}
		}
		else
		{
			echo ("<script>window.alert(\"Error-".$oResult->message." ".$oResult->error."\");</script>");
		}
	}
	
	public function getStaffNo()
	{
		$oBasic=new CBasic();
		$oResult=new CResult();
		//$dt=date('Y');
		//$dt1=substr(date('Y'),2);
		$sql="SELECT MAX(man_id) AS StfNo FROM staff";
		$oResult=$oBasic->SqlQuery($sql);
		if($oResult->IsSuccess)
		{ 
			if($oResult->num_rows>0)
			{
				$StfNo=$oResult->row["StfNo"];
				if($StfNo)
				{
					$StfNo=$StfNo+1;
					return $StfNo;
				}
				else
				{
					return '50001';	
				}
			}
		}
		else
		{
			echo ("<script>window.alert(\"Error-".$oResult->message." ".$oResult->error."\");</script>");
		}
	}
	
	public function getPatientNo()
	{
		$oBasic=new CBasic();
		$oResult=new CResult();
		//$dt=date('Y');
		//$dt1=substr(date('Y'),2);
		$sql="SELECT MAX(patient_id) StfNo FROM patient";
		$dd=date('d');
		$mm=date('m');
		$yy=date('y');
		$today=$dd.$mm.$yy;
		$oResult=$oBasic->SqlQuery($sql);
		if($oResult->IsSuccess)
		{ 
			if($oResult->num_rows>0)
			{
				$StfNo=$oResult->row["StfNo"];
				
				if($StfNo)
				{
					if($today==SUBSTR($StfNo,0,6))
					{
						$StfNo=$StfNo+1;
						return $StfNo;
					}
					
					else
					{
						return $today.'1001';
					}
					
				}
				else
				{
					return $today.'1001';	
				}
			}
		}
		else
		{
			echo ("<script>window.alert(\"Error-".$oResult->message." ".$oResult->error."\");</script>");
		}
	}
	
	public function getBillNo()
	{
		$oBasic=new CBasic();
		$oResult=new CResult();
		//$dt=date('Y');
		//$dt1=substr(date('Y'),2);
		$sql="SELECT MAX(bill_id) StfNo FROM patient_bill";
		$dd=date('d');
		$mm=date('m');
		$yy=date('y');
		$today=$dd.$mm.$yy;
		$oResult=$oBasic->SqlQuery($sql);
		if($oResult->IsSuccess)
		{ 
			if($oResult->num_rows>0)
			{
				$StfNo=$oResult->row["StfNo"];
				
				if($StfNo)
				{
					if($today==SUBSTR($StfNo,3,8))
					{
						$StfNo=SUBSTR($StfNo,3,8)+1;
						return 'OB'.$StfNo;
					}
					
					else
					{
						return 'OB'.$today.'101';
					}
					
				}
				else
				{
					return 'OB'.$today.'101';	
				}
			}
		}
		else
		{
			echo ("<script>window.alert(\"Error-".$oResult->message." ".$oResult->error."\");</script>");
		}
	}
	
	public function getPatientApp1No()
	{
		$oBasic=new CBasic();
		$oResult=new CResult();
		//$dt=date('Y');
		//$dt1=substr(date('Y'),2);
		$sql="SELECT MAX(token_no) StfNo FROM patient_appointment WHERE token_no LIKE 'GS%'";
		$dd=date('d');
		$mm=date('m');
		$yy=date('y');
		$today=$dd.$mm.$yy;
		$oResult=$oBasic->SqlQuery($sql);
		if($oResult->IsSuccess)
		{ 
			if($oResult->num_rows>0)
			{
				$StfNo=$oResult->row["StfNo"];
				
				if($StfNo)
				{
					if($today==SUBSTR($StfNo,3,8))
					{
						$StfNo=SUBSTR($StfNo,3,8)+1;
						return 'GS'.$StfNo;
					}
					
					else
					{
						return 'GS'.$today.'101';
					}
					
				}
				else
				{
					return 'GS'.$today.'101';	
				}
			}
		}
		else
		{
			echo ("<script>window.alert(\"Error-".$oResult->message." ".$oResult->error."\");</script>");
		}
	}
	
	public function getPatientApp2No()
	{
		$oBasic=new CBasic();
		$oResult=new CResult();
		//$dt=date('Y');
		//$dt1=substr(date('Y'),2);
		$sql="SELECT MAX(token_no) StfNo FROM patient_appointment WHERE token_no LIKE 'ES%'";
		$dd=date('d');
		$mm=date('m');
		$yy=date('y');
		$today=$dd.$mm.$yy;
		$oResult=$oBasic->SqlQuery($sql);
		if($oResult->IsSuccess)
		{ 
			if($oResult->num_rows>0)
			{
				$StfNo=$oResult->row["StfNo"];
				
				if($StfNo)
				{
					if($today==SUBSTR($StfNo,3,8))
					{
						$StfNo=SUBSTR($StfNo,3,8)+1;
						return 'ES'.$StfNo;
					}
					
					else
					{
						return 'ES'.$today.'101';
					}
					
				}
				else
				{
					return 'ES'.$today.'101';	
				}
			}
		}
		else
		{
			echo ("<script>window.alert(\"Error-".$oResult->message." ".$oResult->error."\");</script>");
		}
	}
	
	public function getPatientApp3No()
	{
		$oBasic=new CBasic();
		$oResult=new CResult();
		//$dt=date('Y');
		//$dt1=substr(date('Y'),2);
		$sql="SELECT MAX(token_no) StfNo FROM patient_appointment WHERE token_no LIKE 'SS%'";
		$dd=date('d');
		$mm=date('m');
		$yy=date('y');
		$today=$dd.$mm.$yy;
		$oResult=$oBasic->SqlQuery($sql);
		if($oResult->IsSuccess)
		{ 
			if($oResult->num_rows>0)
			{
				$StfNo=$oResult->row["StfNo"];
				
				if($StfNo)
				{
					if($today==SUBSTR($StfNo,3,8))
					{
						$StfNo=SUBSTR($StfNo,3,8)+1;
						return 'SS'.$StfNo;
					}
					
					else
					{
						return 'SS'.$today.'101';
					}
					
				}
				else
				{
					return 'SS'.$today.'101';	
				}
			}
		}
		else
		{
			echo ("<script>window.alert(\"Error-".$oResult->message." ".$oResult->error."\");</script>");
		}
	}
	
	public function getPatientApp4No()
	{
		$oBasic=new CBasic();
		$oResult=new CResult();
		//$dt=date('Y');
		//$dt1=substr(date('Y'),2);
		$sql="SELECT MAX(token_no) StfNo FROM patient_appointment WHERE token_no LIKE 'SC%'";
		$dd=date('d');
		$mm=date('m');
		$yy=date('y');
		$today=$dd.$mm.$yy;
		$oResult=$oBasic->SqlQuery($sql);
		if($oResult->IsSuccess)
		{ 
			if($oResult->num_rows>0)
			{
				$StfNo=$oResult->row["StfNo"];
				
				if($StfNo)
				{
					if($today==SUBSTR($StfNo,3,8))
					{
						$StfNo=SUBSTR($StfNo,3,8)+1;
						return 'SC'.$StfNo;
					}
					
					else
					{
						return 'SC'.$today.'101';
					}
					
				}
				else
				{
					return 'SC'.$today.'101';	
				}
			}
		}
		else
		{
			echo ("<script>window.alert(\"Error-".$oResult->message." ".$oResult->error."\");</script>");
		}
	}
	
	public function getDoctorNo()
	{
		$oBasic=new CBasic();
		$oResult=new CResult();
		//$dt=date('Y');
		//$dt1=substr(date('Y'),2);
		$sql="SELECT MAX(doc_id) AS StfNo FROM doctor";
		$oResult=$oBasic->SqlQuery($sql);
		if($oResult->IsSuccess)
		{ 
			if($oResult->num_rows>0)
			{
				$StfNo=$oResult->row["StfNo"];
				if($StfNo)
				{
					$StfNo=$StfNo+1;
					return $StfNo;
				}
				else
				{
					return '30001';	
				}
			}
		}
		else
		{
			echo ("<script>window.alert(\"Error-".$oResult->message." ".$oResult->error."\");</script>");
		}
	}
	

	public function ReadAllModule($Value,$Display,$Selected)
	{
		$oBasic=new CBasic();
		$sql="SELECT DISTINCT ModuleName FROM sec_menuitem ORDER BY ID";
		$oResult=$oBasic->SqlQuery($sql);
		if($oResult->IsSuccess)
		{
			for($i=0;$i<$oResult->num_rows;$i++)
			{
				if($oResult->rows[$i][$Value]==$Selected)
				echo "<option value=\"".$oResult->rows[$i][$Value]."\" selected=\"selected\">".$oResult->rows[$i][$Display]."</option>";
				else echo "<option value=\"".$oResult->rows[$i][$Value]."\">".$oResult->rows[$i][$Display]."</option>";
			}
		}
	}
							
	public function ReadAllRole($Value,$Display,$Selected)
	{
		$oBasic=new CBasic();
		$sql="SELECT * FROM sec_role ORDER BY Name";
		$oResult=$oBasic->SqlQuery($sql);
		if($oResult->IsSuccess)
		{
			for($i=0;$i<$oResult->num_rows;$i++)
			{
				if($oResult->rows[$i][$Value]==$Selected)
				echo "<option value=\"".$oResult->rows[$i][$Value]."\" selected=\"selected\">".$oResult->rows[$i][$Display]."</option>";
				else echo "<option value=\"".$oResult->rows[$i][$Value]."\">".$oResult->rows[$i][$Display]."</option>";
			}
		}
	}
};
?>
