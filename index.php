<?php
require_once __DIR__.'/vendor/autoload.php';

use Repositories\ResultChecker\ResultChecker;

 $rc = new ResultChecker;

/**
 * @var ResultProviderInterface Description
 */
$rpi = $rc->getProvider('nabteb');
$rpi->set_exam_year(2010);
$rpi->set_exam_type('01');
$rpi->set_exam_number('14018003');
$rpi->set_card_pin('135621612973');
$rpi->set_card_sn('NBRC14081457');
 
//$rpi = $rc->getProvider('waec');
//$rpi->set_exam_year(2010);
//$rpi->set_exam_type('WAEC');
//$rpi->set_exam_number('4251905038');
//$rpi->set_card_pin('101256512466');
//$rpi->set_card_sn('Wrc120129202');

$result = $rpi->fetch_result();

//echo  $result->get_result_html();
var_dump($result);
