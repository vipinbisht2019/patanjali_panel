<?php
require_once '../../config.php';
require_once CLASS_DIR.'/dbclass.php';
require_once CLASS_DIR.'/api.php';
require_once CLASS_DIR.'/Feedback.php';

$api = new api();
$feedback = new Feedback();
$post = $api->jsonBody();

if (isset($_GET['controller']) && $_GET['controller'] == 'feedbackOptionList') {
    $data = $feedback->feedbackOptionList();
    if ($data) {
        $success = 1;
        $message = "Success";
    } else {
        $success = 0;
        $message = "No Result";
        $data = array();
    }
    $return = array('success' => $success, 'data' => $data, 'message' => $message);
    $api->setResponse($return, 200);
}

if (isset($_GET['controller']) && $_GET['controller'] == 'saveOption') {
    $data = [];
    $success = 0;
    if(!empty($post['name'])){
        $postdata = [];
        $postdata['name'] = $post['name'];
        $postdata['is_active'] = !empty($post['is_active'])?$post['is_active']:0;
        if(!empty($post['option_id'])){
            $feedback->updateOption($post['option_id'],$postdata);
            $success = 1;        
        }else{
            $feedback->addOption($postdata);
            $success = 1;
        }
    }else{
        $success = 0;
        $message = "Something went wrong";
    }
    $return = array('success' => $success, 'data' => $data, 'message' => $message);
    $api->setResponse($return, 200);
}