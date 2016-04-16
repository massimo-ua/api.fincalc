<?php
require_once('fincalc.php');

//$request_body = file_get_contents('php://input');
//$data = json_decode($request_body);

$product1 = new stdClass();
$product1->InPSForcastedSales = 15000;
$product1->InPSForcasedProductionUnits = 3000;

$product2 = new stdClass();
$product2->InPSForcastedSales = 9000;
$product2->InPSForcasedProductionUnits = 2000;

$products = array($product1, $product2);

//print_r($products);

$calculator = new FinancialCalculator(
	100,
	100,
	100,
	100,
	100,
	100,
	100,
	100,
	100,
	100,
	100,
	100,
	100,
	100,
	100,
	100,
	100,
	100,
	100,
	100,
	100,
	100,
	100,
	100,
	100,
	100,
	100,
	100,
	100,
	100,
	100,
	100,
	-139,
	2,
	100,
	100,
	100,
	100,
	$products,
	5
	);

echo $calculator->OutRCInterestIncome();

//$result = ($data->c6 + $data->c7 + $data->c10 + $data->d11 + $data->d14 + $data->c16 + $data->c23 + $data->c35);

//$today = date("Y-m-d H:i:s");
//file_put_contents('log.txt', $today . '~' . $_SERVER['REMOTE_ADDR'] .'~' . $request_body . '~' . $result . PHP_EOL, FILE_APPEND | LOCK_EX);

//echo json_encode(array('calculation' => $result)); exit(0);
