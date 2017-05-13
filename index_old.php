<?php
require 'app/start.php';


class index {
    private $resultChecker;
    
    private $required_filed;
    
    public function __construct() {
        $this->resultChecker = new Start();
    }
    
    public function findResult($param){
        return $this->resultChecker->get($param)->get();
    }
}

$exam_info = array(
                'exam' => 'Waec',
                'exam_year' => 2007,
                'exam_type' => 'MAY/JUN',//for waec ==> MAY/JUN or NOV/DEC
                'exam_number' => '4280208182',
                'card_pin'  => '338898342726',
                'card_sn'   => 'w309338916'
            );

$me = new index();
//$me->findResult($exam_info);
//$just =  $me->findResult($exam_info);
//echo $just->getHtml();
var_dump($me->findResult($exam_info));
die();
