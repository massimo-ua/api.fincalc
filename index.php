<?php
require_once('fincalc.php');

//$request_body = file_get_contents('php://input');
//$data = json_decode($request_body);

$product1 = new stdClass();
$product1->InPSForcastedSales = 23000;
$product1->InPSForcasedProductionUnits = 140000;

$product2 = new stdClass();
$product2->InPSForcastedSales = 32000;
$product2->InPSForcasedProductionUnits = 87000;

$product3 = new stdClass();
$product3->InPSForcastedSales = 23000;
$product3->InPSForcasedProductionUnits = 17000;

$product4 = new stdClass();
$product4->InPSForcastedSales = 5000;
$product4->InPSForcasedProductionUnits = 30000;

$products = array($product1, $product2, $product3, $product4);

//print_r($products);
$start = microtime(true);
$calculator = new FinancialCalculator(
	146761,
	0.0103,
	3425,
	4345,
	13102,
	1764,
	7332,
	8764,
	22367,
	23916,
	4375,
	300,
	100,
	320,
	333,
	0,
	23423,
	0,
	0,
	-3456,
	0,
	-23968,
	-2000,
	0.263,
	-324,
	-18461.1385944,
  -23076.423243,
	-100000,
	329.45,
	0,
	0.02,
	5000,
	-189,
	1,
	28519,
	1650,
	16597,
	6757,
	925,
	40,
	931.662,
	-13118,
	$products,
	5
	);
echo $calculator->OutISInterestExpense(). '<br>'; exit(0);


echo $calculator->OutRCInterestIncome() . '<br>';
$time_elapsed_secs = microtime(true) - $start;
echo $time_elapsed_secs . ' c';

//$result = ($data->c6 + $data->c7 + $data->c10 + $data->d11 + $data->d14 + $data->c16 + $data->c23 + $data->c35);

//$today = date("Y-m-d H:i:s");
//file_put_contents('log.txt', $today . '~' . $_SERVER['REMOTE_ADDR'] .'~' . $request_body . '~' . $result . PHP_EOL, FILE_APPEND | LOCK_EX);

//echo json_encode(array('calculation' => $result)); exit(0);
