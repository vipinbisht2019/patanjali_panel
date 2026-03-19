<?php

class Feedback extends dbclass {

    public function feedbackOption() {
        $query = "
            SELECT id, name
            FROM feedback_suggestions 
            WHERE is_active=1 ORDER BY id ASC";
        return $this->fetchResult($query);
    }
    
    public function getOptionDetail($id) {
        $query = "SELECT id, name, is_active FROM feedback_suggestions WHERE id={$id}";
        return $this->fetchResult($query);
    }
    
    public function feedbackOptionList() {
        $query = "
            SELECT id, name, is_active
            FROM feedback_suggestions ORDER BY id ASC";
        return $this->fetchResult($query);
    }
    
    public function addOption($data){
            return $this->_insert('feedback_suggestions', $data);
    }

    public function updateOption($id, $data){
            return $this->_update('feedback_suggestions', $data, array('id'=>$id));
    }

}
