<?php

class Company {
  private $name;
  public $stock_date_price = array();

  function __construct($name) {
    $this->name = $name;
  }
  function get_name() {
    return $this->name;
  }

  
  function get_stock_list(){
	return $this->stock_date_price;
  }
}

$apple = new Company("Apple");
array_push($apple->stock_date_price, array(0,1),array(0,2));
//echo sizeof($apple->stock_date_price);

$list = array();
$list_name = array();

if(isset($_POST['btn_submit']))
{
	$fh = fopen($_FILES['file']['tmp_name'], 'r+');

	$lines = array();
	while( ($row = fgetcsv($fh, 8192)) !== FALSE ) {
		$lines[] = $row;
	}
	$start_date = substr($lines[1][1],6,4) . "-". substr($lines[1][1],3,2) . "-". substr($lines[1][1],0,2);
	$end_date = substr($lines[sizeof($lines)-1][1],6,4) . "-". substr($lines[sizeof($lines)-1][1],3,2) . "-". substr($lines[sizeof($lines)-1][1],0,2);
	var_dump($start_date);
	for($i = 1; $i < sizeof($lines) ; $i++){
		$size = sizeof($list);
		$initialised = FALSE;
		for($j = 0; $j<sizeof($list); $j++){
			if($lines[$i][2] == $list[$j]->get_name()){
				$initialised = true;
				array_push($list[$j]->stock_date_price, array($lines[$i][1], $lines[$i][3]));
				break;
			}
		}
		if(!$initialised){
			array_push($list, new Company($lines[$i][2]));
			array_push($list_name, $lines[$i][2]);
			array_push($list[$size]->stock_date_price, array($lines[$i][1], $lines[$i][3]));
			
		}
	}
	
;

	for($j = 0; $j<sizeof($list); $j++){
		//echo calculate_profit($list[$j], $start , $end);
		//echo "\n";
	}

	
	
}

function convert_format($date){
		$temp = substr($date,8,2) . "-" .substr($date,5,2) . "-" . substr($date,0,4);
		return $temp;
}
	
function calculate_profit($comp, $start, $end){
	$stock_list = $comp->stock_date_price;
	$buying_price = 0;
	$selling_price = 0;
	for($i = 0; $i < sizeof($stock_list); $i++){
		if($stock_list[$i][0] == $start){
			$buying_price = $stock_list[$i][1];
		}
		if($stock_list[$i][0] == $end){
			$selling_price = $stock_list[$i][1];
		}
	}

	return ($buying_price - $selling_price);
}
function average($comp){
	$stock_list = $comp->stock_date_price;
	$temp = array();

	for($x = 0; $x < sizeof($stock_list); $x++){
		array_push($temp, $stock_list[$x][1]);
	}
	$temp = array_filter($temp);
	return array_sum($temp)/count($temp);
}

function getcompanyfromname($name,$list){
	for($x = 0; $x<sizeof($list); $x++){
		if($list[$x]->get_name() == $name){
			return $list[$x];
		}
	}
	return FALSE;
}
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
<input type="file" name="file" id = "myfile" accept=".csv">
<input type="submit" name="btn_submit" value="Upload File"  />


<form method="post" accept-charset="utf-8" enctype="multipart/form-data">
<label for="cars">Comapany:</label>
<select name="company" id="company">
  
</select>
<input type="date" id="start" name="start" min="<?php echo $start_date;?>" max="<?php echo $end_date;?>">
<input type="date" id="end" name="end" min="<?php echo $start_date;?>" max="<?php echo $end_date;?>">
<input type="submit" name="submit2" value="Submit" id = "submit123" />
<div id='response'></div>
<br>
<table style="width:100%">
  <tr>
    <th>Company</th>
    <th>Mean Price</th>
    <th>sell-buy (Dates)</th>
  </tr>
  <tr>
    <td>Jill</td>
    <td>Smith</td>
    <td>50</td>
  </tr>
  <tr>
    <td>Eve</td>
    <td>Jackson</td>
    <td>94</td>
  </tr>
</table>


<script>
	 var i;
	 var length = "<?php echo count($list_name);?>";
	 var val = <?php echo json_encode($list_name);?>;
		for(i=0;i<length;i++){
			
			document.getElementById("10:00").innerHTML += "<td value = \"2\"  class=\"cs335 blue lab\" data-tooltip=\"Software Engineering &amp; Software Process\">Free to Book</td>";
		}
</script>