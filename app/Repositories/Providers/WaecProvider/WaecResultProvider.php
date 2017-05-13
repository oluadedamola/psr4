<?php
namespace Repositories\Providers\WaecProvider;
use Repositories\ResultChecker\ResultProviderInterface;
//use Repositories\ResultChecker\ResultInterface;
use Exception;


/**
 * Description of WaecResultProvider
 *
 * @author Suleodu
 */
class WaecResultProvider implements ResultProviderInterface{
    private $card_pin;
    private $card_sn;
    private $exam_number;
    private $exam_type;
    private $exam_year;
    private $http;
    private $waec_url;
    private $waecResult;
    
    private $exam_result;
    
    public function __construct($http) {
        $this->http = $http;
    }

    public function fetch_result() {
        $this->waecResult = new WaecResult;
        
        $waec_url_query_string = sprintf("?ExamNumber=%s"
                                        . "&ExamYear=%s"
                                        . "&serial=%s"
                                        . "&pin=%s"
                                        . "&ExamType=%s",
                                        $this->get_exam_number(),
                                        $this->get_exam_year(), 
                                        $this->get_card_sn(), 
                                        $this->get_card_pin(), 
                                        $this->get_exam_type());
        $this->waec_url = "https://www.waecdirect.org/DisplayResult.aspx".$waec_url_query_string;
        //$this->waec_url = "http://localhost/psr4/app/repositories/providers/WaecProvider/WAEC RESULT NEW VERSION.htm";
        try {
            $crawler = $this->http->request('GET', $this->waec_url);
            
            $status = $crawler->filter('title')->text();
            if(strcasecmp(trim($status), "Error Page") == 0){
                $this->waecResult->set_status(FALSE);
                $this->waecResult->set_exam('WAEC');
                $this->waecResult->set_result_html($crawler->html());
                $this->waecResult->set_response($crawler->filter('#lblErrorMsg')->text());
            }
            else{
                
                $exam_number = $crawler->filter('table #tbCandidInfo')->children()->children()->eq(0)->children()->eq(1)->text();
                $candidate_name = $crawler->filter('table #tbCandidInfo')->children()->children()->eq(1)->children()->eq(1)->text();
                $exam_type = $crawler->filter('table #tbCandidInfo')->children()->children()->eq(2)->children()->eq(1)->text();
                $exam_year = @end(explode(' ', $this->sanitize($exam_type)));
                $exam_center = $crawler->filter('table #tbCandidInfo')->children()->children()->eq(3)->children()->eq(1)->text();

                //Extract the result into and associative array
                $crawler->filter('table #tbSubjectGrades > tbody')
                        ->children()->each(function($candInfo) {
                    $r = [
                        'subject' => $this->sanitize($candInfo->children()->eq(0)->text()),
                        'score' => $this->sanitize($candInfo->children()->eq(1)->text())
                    ];
                    $this->exam_result[] = $r;
                });
                $this->waecResult->set_status(TRUE);
                $this->waecResult->set_exam('WAEC');
                $this->waecResult->set_response("WAEC RESULT FOUND");
                $this->waecResult->set_exam_number($this->sanitize($exam_number));
                $this->waecResult->set_candidate_name($this->sanitize($candidate_name));
                $this->waecResult->set_exam_type($this->sanitize($exam_type));
                $this->waecResult->set_exam_center($this->sanitize($exam_center));
                $this->waecResult->set_exam_year($this->sanitize($exam_year));
                $this->waecResult->set_result($this->exam_result);
                $this->waecResult->set_result_html($crawler->html());
            }
            
        } catch (Exception $exc) {
            //echo $exc->getTraceAsString();
            var_dump($exc->getMessage());
        }

        return $this->waecResult;
        
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
                'WAEC' => 'MAY/JUNE', 
                'WAEC-PRIVATE' => 'NOV/DEC'
                );
                   
                
    }
    
    private function sanitize($string) {
        return trim(preg_replace('/\s\s+/', ' ', $string));
    }

}
