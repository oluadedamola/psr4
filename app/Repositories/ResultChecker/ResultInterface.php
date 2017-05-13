<?php
namespace Repositories\ResultChecker;

/**
 *
 * @author Suleodu
 */
interface ResultInterface {
    
    public function get_exam();
    
    public function get_exam_year();
    
    public function get_exam_type();
    
    public function get_exam_number();
    
    public function get_candidate_name();
    
    public function get_exam_center();
    
    public function get_response();
    
    public function get_result();
    
    public function get_result_html();
    
            
}
