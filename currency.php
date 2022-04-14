<?php
// Source code
// http://www.ecb.int/stats/eurofxref/eurofxref-daily.xml

// accessing xml file
$x = simplexml_load_file("http://www.ecb.int/stats/eurofxref/eurofxref-daily.xml");
$x ->registerXPathNamespace("ecb", "http://www.ecb.int/vocabulary/2002-08-01/eurofxref");

//setting dolar's rate and current date
$array_usd = $x->xpath("//ecb:Cube[@currency='USD']/@rate");
$array_time = $x->xpath("//ecb:Cube/@time");
$rate_usd = (string) $array_usd[0]['rate'];
$date = (string) $array_time[0]['time'];

//function to get actual rates of each currency
function getUsdRate($symbol, $xml, $usd) {
  if ($symbol == 'EUR') {
    $rate = 1 / $usd;
    return $rate;
  }
  else {
    $array = $xml->xpath("//ecb:Cube[@currency='".$symbol."']/@rate");
    $rate_in_eur = (string) $array[0]['rate'];
    $rate = $rate_in_eur / $usd;
    return $rate;
  }
} 


//CSV FILE
//creating a arrary to carry current data
$list = array (
  array('Currency Code', 'Rate'),
  array('EUR', getUsdRate('EUR', $x, $rate_usd)),
  array('JPY', getUsdRate('JPY', $x, $rate_usd)),
  array('BGN', getUsdRate('BGN', $x, $rate_usd)),
  array('CZK', getUsdRate('CZK', $x, $rate_usd)),
  array('DKK', getUsdRate('DKK', $x, $rate_usd)),
  array('GBP', getUsdRate('GBP', $x, $rate_usd)),
  array('HUF', getUsdRate('HUF', $x, $rate_usd)),
  array('PLN', getUsdRate('PLN', $x, $rate_usd)),
  array('RON', getUsdRate('RON', $x, $rate_usd)),
  array('SEK', getUsdRate('SEK', $x, $rate_usd)),
  array('CHF', getUsdRate('CHF', $x, $rate_usd)),
  array('ISK', getUsdRate('ISK', $x, $rate_usd)),
  array('NOK', getUsdRate('NOK', $x, $rate_usd)),
  array('HRK', getUsdRate('HRK', $x, $rate_usd)),
  array('RUB', getUsdRate('RUB', $x, $rate_usd)),
  array('TRY', getUsdRate('TRY', $x, $rate_usd)),
  array('AUD', getUsdRate('AUD', $x, $rate_usd)),
  array('BRL', getUsdRate('BRL', $x, $rate_usd)),
  array('CAD', getUsdRate('CAD', $x, $rate_usd)),
  array('CNY', getUsdRate('CNY', $x, $rate_usd)),
  array('HKD', getUsdRate('HKD', $x, $rate_usd)),
  array('IDR', getUsdRate('IDR', $x, $rate_usd)),
  array('ILS', getUsdRate('ILS', $x, $rate_usd)),
  array('INR', getUsdRate('INR', $x, $rate_usd)),
  array('KRW', getUsdRate('KRW', $x, $rate_usd)),
  array('MXN', getUsdRate('MXN', $x, $rate_usd)),
  array('MYR', getUsdRate('MYR', $x, $rate_usd)),
  array('NZD', getUsdRate('NZD', $x, $rate_usd)),
  array('PHP', getUsdRate('PHP', $x, $rate_usd)),
  array('SGD', getUsdRate('SGD', $x, $rate_usd)),
  array('THB', getUsdRate('THB', $x, $rate_usd)),
  array('ZAR', getUsdRate('ZAR', $x, $rate_usd))
);

//making csv file
$csv_name = "usd_currency_rates_".$date.".csv";
$fp = fopen($csv_name, 'w');

//writing data on a csv
foreach ($list as $line) {
  fputcsv($fp, $line,";");
}
//closing csv
fclose($fp);

?>
