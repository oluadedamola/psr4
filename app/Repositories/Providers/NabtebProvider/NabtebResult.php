<?php
namespace Repositories\Providers\NabtebProvider;
use Repositories\ResultChecker\ResultInterface;
/**
 * Description of NabtebResult
 *
 * @author Suleodu
 */
class NabtebResult implements ResultInterface{
    private $exam;
    private $exam_year;
    private $exam_type;
    private $exam_number;
    private $candidate_name;
    private $exam_html;
    private $exam_center;
    private $result = [];
    private $status;
    private $response;

    
    function get_exam() {
        return $this->exam;
    }

    function get_exam_year() {
        return $this->exam_year;
    }

    function get_exam_type() {
        return $this->exam_type;
    }

    function get_exam_number() {
        return $this->exam_number;
    }

    function get_candidate_name() {
        return $this->candidate_name;
    }

    function get_exam_center() {
        return $this->exam_center;
    }

    function get_result() {
        return $this->result;
    }

    function get_result_html() {
        return $this->exam_html;
    }
    
    function get_status() {
        return $this->status;
    }

    function get_response() {
        return $this->response;
    }

    function set_exam($exam) {
        $this->exam = $exam;
    }

    function set_exam_year($exam_year) {
        $this->exam_year = $exam_year;
    }

    function set_exam_type($exam_type) {
        $this->exam_type = $exam_type;
    }

    function set_exam_number($exam_number) {
        $this->exam_number = $exam_number;
    }

    function set_candidate_name($candidate_name) {
        $this->candidate_name = $candidate_name;
    }

    function set_result_html($html) {
        $this->exam_html = $html;
    }

    function set_exam_center($exam_center) {
        $this->exam_center = $exam_center;
    }

    function set_result($result) {
        $this->result = $result;
    }

    function set_status($status) {
        $this->status = $status;
    }

    function set_response($response) {
        $this->response = $response;
    }

    

//put your code here
}
