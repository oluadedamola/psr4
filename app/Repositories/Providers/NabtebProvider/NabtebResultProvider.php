<?php
namespace Repositories\Providers\NabtebProvider;

use Repositories\ResultChecker\ResultProviderInterface;

use Exception;

/**
 * Description of newPHPClass
 *
 * @author Suleodu
 */
class NabtebResultProvider implements ResultProviderInterface {
    
    private $card_pin;
    private $card_sn;
    private $exam_number;
    private $exam_type;
    private $exam_year;
    private $http;
    private $nabteb_url;
    private $nabtebResult;
    
    private $exam_result;
    
    public function __construct($http) {
        $this->http = $http;
        $this->nabteb_url = "https://eworld.nabtebnigeria.org/index.htm";
        //$this->nabteb_url = "http://localhost/psr4/app/repositories/providers/NabtebProvider/test.php";
        
    }
    
    
    public function fetch_result() {
        $this->nabtebResult = new NabtebResult;
        try {
            $formDom = $this->http->request('GET', $this->nabteb_url);
            $form = $formDom->selectButton('Submit')->form();
            $form['examtype'] = $this->get_exam_type();
            $form['examyear'] = $this->get_exam_year();
            $form['emailcheck']->untick();
            $form['serial'] = $this->get_card_sn();
            $form['pin'] = $this->get_card_pin();
            $form['candid'] = $this->get_exam_number();
            
            $crawler = $this->http->submit($form);
          
            $url = $crawler->getUri();
            
           //$crawler = $this->http->request('GET', $this->nabteb_url);
            
            
            if($url == 'https://eworld.nabtebnigeria.org/displayresults.asp'){
                
               
                //if result page 
                $exam_number = $crawler->filterXPath('html/body/table/tr/td/div/table')
                        ->children()
                        ->eq(3)
                        ->children()
                        ->eq(1)
                        ->text();
                $candidate_name = $crawler->filterXPath('html/body/table/tr/td/div/table')
                        ->children()
                        ->eq(4)
                        ->children()
                        ->eq(1)
                        ->text();

                $exam_type = $crawler->filterXPath('html/body/table/tr/td/div/table')
                        ->children()
                        ->eq(5)
                        ->children()
                        ->eq(1)
                        ->text();

                $exam_year = @end(explode(' ', $this->sanitize($exam_type)));

                $trade_name = $crawler->filterXPath('html/body/table/tr/td/div/table')
                        ->children()
                        ->eq(6)
                        ->children()
                        ->eq(1)
                        ->text();
                $exam_center = $crawler->filterXPath('html/body/table/tr/td/div/table')
                        ->children()
                        ->eq(7)
                        ->children()
                        ->eq(1)
                        ->text();

                $r = [
                    'subject' => $this->sanitize(
                            $crawler->filterXPath('html/body/table/tr/td/div/table')
                                    ->children()
                                    ->eq(12)
                                    ->children()
                                    ->eq(0)
                                    ->text()
                    ),
                    'score' => $this->sanitize(
                            $crawler->filterXPath('html/body/table/tr/td/div/table')
                                    ->children()
                                    ->eq(12)
                                    ->children()
                                    ->eq(1)
                                    ->text()
                    )
                ];
                $this->exam_result[] = $r;

                $r = [
                    'subject' => $this->sanitize($crawler->filterXPath('html/body/table/tr/td/div/table')
                                    ->children()
                                    ->eq(13)
                                    ->children()
                                    ->eq(0)
                                    ->text()
                    ),
                    'score' => $this->sanitize(
                            $crawler->filterXPath('html/body/table/tr/td/div/table')
                                    ->children()
                                    ->eq(13)
                                    ->children()
                                    ->eq(1)
                                    ->text()
                    )
                ];
                $this->exam_result[] = $r;

                $r = [
                    'subject' => $this->sanitize(
                            $crawler->filterXPath('html/body/table/tr/td/div/table')
                                    ->children()
                                    ->eq(14)->children()->eq(0)
                                    ->text()
                    ),
                    'score' => $this->sanitize(
                            $crawler->filterXPath('html/body/table/tr/td/div/table')
                                    ->children()
                                    ->eq(14)->children()->eq(1)
                                    ->text()
                    )
                ];
                $this->exam_result[] = $r;

                $r = [
                    'subject' => $this->sanitize(
                            $crawler->filterXPath('html/body/table/tr/td/div/table')
                                    ->children()
                                    ->eq(16)->children()->eq(0)
                                    ->text()
                    ),
                    'score' => $this->sanitize(
                            $crawler->filterXPath('html/body/table/tr/td/div/table')
                                    ->children()
                                    ->eq(16)->children()->eq(1)
                                    ->text()
                    )
                ];
                $this->exam_result[] = $r;

                $r = [
                    'subject' => $this->sanitize(
                            $crawler->filterXPath('html/body/table/tr/td/div/table')
                                    ->children()
                                    ->eq(18)->children()->eq(0)
                                    ->text()
                    ),
                    'score' => $this->sanitize(
                            $crawler->filterXPath('html/body/table/tr/td/div/table')
                                    ->children()
                                    ->eq(18)->children()->eq(1)
                                    ->text()
                    )
                ];
                $this->exam_result[] = $r;


                $r = [
                    'subject' => $this->sanitize(
                            $crawler->filterXPath('html/body/table/tr/td/div/table')
                                    ->children()
                                    ->eq(19)->children()->eq(0)
                                    ->text()
                    ),
                    'score' => $this->sanitize(
                            $crawler->filterXPath('html/body/table/tr/td/div/table')
                                    ->children()
                                    ->eq(19)->children()->eq(1)
                                    ->text()
                    )
                ];
                $this->exam_result[] = $r;

                $r = [
                    'subject' => $this->sanitize(
                            $crawler->filterXPath('html/body/table/tr/td/div/table')
                                    ->children()
                                    ->eq(20)->children()->eq(0)
                                    ->text()
                    ),
                    'score' => $this->sanitize(
                            $crawler->filterXPath('html/body/table/tr/td/div/table')
                                    ->children()
                                    ->eq(20)->children()->eq(1)
                                    ->text()
                    )
                ];
                $this->exam_result[] = $r;

                $r = [
                    'subject' => $this->sanitize(
                            $crawler->filterXPath('html/body/table/tr/td/div/table')
                                    ->children()
                                    ->eq(21)->children()->eq(0)
                                    ->text()
                    ),
                    'score' => $this->sanitize(
                            $crawler->filterXPath('html/body/table/tr/td/div/table')
                                    ->children()
                                    ->eq(21)->children()->eq(1)
                                    ->text()
                    )
                ];
                $this->exam_result[] = $r;

                $r = [
                    'subject' => $this->sanitize(
                            $crawler->filterXPath('html/body/table/tr/td/div/table')
                                    ->children()
                                    ->eq(22)->children()->eq(0)
                                    ->text()
                    ),
                    'score' => $this->sanitize(
                            $crawler->filterXPath('html/body/table/tr/td/div/table')
                                    ->children()
                                    ->eq(22)->children()->eq(1)
                                    ->text()
                    )
                ];
                $this->exam_result[] = $r;

                $this->nabtebResult->set_response("NABTEB RESULT FOUND");
                $this->nabtebResult->set_status(TRUE);
                $this->nabtebResult->set_exam('NABTEB');
                $this->nabtebResult->set_result_html($crawler->html());
                $this->nabtebResult->set_exam_number($this->sanitize($exam_number));
                $this->nabtebResult->set_candidate_name($this->sanitize($candidate_name));
                $this->nabtebResult->set_exam_type($this->sanitize($exam_type));
                $this->nabtebResult->set_exam_center($this->sanitize($exam_center));
                $this->nabtebResult->set_exam_year($this->sanitize($exam_year));
                $this->nabtebResult->set_result($this->exam_result);
                
            }else {
                
                 //if Error Page
                $resp = $crawler->filterXPath('html/body/table/tr/td/div/table')
                        ->children()
                        ->eq(1)->children()->children()->children()->children()
                        ->text();
                 
                
                $this->nabtebResult->set_status(FALSE);
                $this->nabtebResult->set_exam('NABTEB');
                $this->nabtebResult->set_result_html($crawler->html());
                $this->nabtebResult->set_response($this->sanitize($resp));

                
            }
            
        } catch (Exception $exc) {
            //echo $exc->getTraceAsString();
            var_dump($exc->getMessage());
        }

        return $this->nabtebResult;
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

    
    /**
     * Set Exam number
     * 
     * @param type $ex_num
     */
    public function set_exam_number($ex_num) {
        $this->exam_number = $ex_num;
    }

    
    /**
     * Set Exam Type
     * 
     * @param type $ex_type
     */
    public function set_exam_type($ex_type) {
        $this->exam_type = $ex_type;
    }

    
    /**
     * Set exam year 
     * 
     * @param type $ex_year
     */
    public function set_exam_year($ex_year) {
        $this->exam_year = $ex_year;
    }

    
    /**
     * Get all exam type for NABTEB
     * 
     * @return type array
     */
    public function get_all_exam_types() {
        return 
            array(
                '01' => 'MAY/JUNE',
                '02' => 'NOV/DEC',
                '03' => 'Modular (March)',
                '04' => 'Modular (December)',
                '05' => 'Modular (July)'
                );
            
        
    }

    private function sanitize($string) {
        return trim(preg_replace('/\s\s+/', ' ', $string));
    }

}
