<?php
namespace Repositories\Providers\NecoProvider;
use Repositories\ResultChecker\ResultProviderInterface;
//use Repositories\ResultChecker\ResultInterface;
use Exception;


/**
 * Description of WaecResultProvider
 *
 * @author Suleodu
 */
class NecoResultProvider implements ResultProviderInterface{
    private $card_pin;
    private $card_sn;
    private $exam_number;
    private $exam_type;
    private $exam_year;
    private $http;
    private $neco_url;
    private $necoResult;
    
    private $exam_result;
    
    public function __construct($http) {
        $this->http = $http;
        //  $this->neco_url = "http://www.mynecoexams.com/results/default.aspx";
        $this->neco_url = "http://localhost/psr4/app/repositories/providers/NecoProvider/NECO RESULT.html";
        
    }

    public function fetch_result() {
        $this->necoResult = new NecoResult;
        try{
            $formDom = $this->http->request('GET', $this->neco_url);
            $form = $formDom->selectButton('Check My Result')->form();
            $form['dlExamType'] = $this->necoResult->get_exam_type();
            $form['dlyear'] = $this->necoResult->get_exam_year();
            $form['txtPinNumber'] = $this->necoResult->get_card_pin();
            $form['txtExamNo'] = $this->necoResult->get_exam_number();
            
            $crawler = $this->http->submit($form);
            
            //$crawler = $this->http->request('GET', $this->neco_url);
            $status = $crawler->filter('.title')->text();
            
            
            if (strcasecmp(trim($status), "SITE INFORMATION:") == 0) {
                
                $this->waecResult->set_status(FALSE);
                $this->waecResult->set_exam('NECO');
                $this->waecResult->set_result_html($crawler->html());
                $this->waecResult->set_response("To get the error");
                
            } else {
                
                $lname = $crawler->filter('.detailpanel .short')->eq(0)->filter('tbody')->children()->eq(0)->children()->eq(1)->children()->attr('value');
                $oname = $crawler->filter('.detailpanel .short')->eq(0)->filter('tbody')->children()->eq(1)->children()->eq(1)->children()->attr('value');
                $center_num = $crawler->filter('.detailpanel .short')->eq(0)->filter('tbody')->children()->eq(2)->children()->eq(1)->children()->attr('value');
                $exam_number = $crawler->filter('.detailpanel .short')->eq(1)->filter('tbody')->children()->eq(0)->children()->eq(1)->children()->attr('value');
                $candidate_name = $lname . ' ' . $oname;
                $exam_center = $crawler->filter('.detailpanel .long')->eq(0)->filter('tbody')->children()->eq(0)->children()->eq(1)->children()->attr('value');
                $exam_type = $crawler->filter('.detailpanel .short')->eq(1)->filter('tbody')->children()->eq(2)->children()->eq(1)->children()->attr('value');
                $exam_year = $crawler->filter('.detailpanel .short')->eq(1)->filter('tbody')->children()->eq(1)->children()->eq(1)->children()->attr('value');


                //Extract the result into and associative array
                $crawler->filter('.scores .resultpanel > tbody')
                        ->children()->each(function($canResult) {
                    $r = [
                        'subject' => $this->sanitize($canResult->children()->eq(1)->text()),
                        'score' => $this->sanitize($canResult->children()->eq(2)->text())
                    ];
                    $this->exam_result[] = $r;
                });
                unset($this->exam_result[0]);
                $this->necoResult->set_status(TRUE);
                $this->necoResult->set_exam('NECO');
                $this->necoResult->set_response("NECO RESULT FOUND");
                $this->necoResult->set_exam_number($this->sanitize($exam_number));
                $this->necoResult->set_candidate_name($this->sanitize($candidate_name));
                $this->necoResult->set_exam_type($this->sanitize($exam_type));
                $this->necoResult->set_exam_center($this->sanitize($exam_center));
                $this->necoResult->set_exam_year($this->sanitize($exam_year));
                $this->necoResult->set_result($this->exam_result);
                $this->necoResult->set_result_html($crawler->html());
            }
        } catch (Exception $exc) {
            //echo $exc->getTraceAsString();
            var_dump($exc->getMessage());
        }

        return $this->necoResult;
        
    }

    public function get_card_pin() {
        return $this->card_pin;
    }

    public function get_card_sn() {
        return $this->card_sn;
    }

    public function get_exam_number() {
        return $this->exam_number;
    }

    public function get_exam_type() {
        return $this->exam_type;
    }

    public function get_exam_year() {
        return $this->exam_year;
    }

    public function set_card_pin($pin) {
        $this->card_pin = $pin;
    }

    public function set_card_sn($sn) {
        $this->card_sn = $sn;
    }

    public function set_exam_number($ex_num) {
        $this->exam_number = $ex_num;
    }

    public function set_exam_type($ex_type) {
        $this->exam_type = $ex_type;
    }

    public function set_exam_year($ex_year) {
        $this->exam_year = $ex_year;
    }

    
    public function get_all_exam_types(){
       return array(
                    array('label'=> 'WAEC', 'value' => 'MAY/JUNE'),
                    array('label'=> 'WAEC-PRIVATE', 'value' => 'NOV/DEC'),
                );
    }
    
    private function sanitize($string) {
        return trim(preg_replace('/\s\s+/', ' ', $string));
    }

}
