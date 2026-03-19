<?php

require_once '../../config.php';
require_once CLASS_DIR . '/dbclass.php';
require_once CLASS_DIR . '/scan_category_restriction.php';
require_once CLASS_DIR . '/api.php';

$api = new api();
$scanCategoryRestriction = new scan_category_restriction();

if (isset($_GET['controller']) && $_GET['controller'] == 'scan_category_restriction_list') {

    $post = $api->jsonBody();
    $result = $scanCategoryRestriction->getList($post);

    if ($result) {
        $return = array('success' => 1, 'data' => $result);
    } else {
        $return = array('success' => 0, 'data' => array());
    }

    $api->setResponse($return, 200);
}

if (isset($_GET['controller']) && $_GET['controller'] == 'delete') {

    $post = $api->jsonBody();
    $id = $post['id'];

    $result = $scanCategoryRestriction->delete($id);

    if ($result['error'] == false) {
        $return = array('success' => 1, 'message' => 'Success');
    } else {
        $return = array('success' => 0, 'message' => $result['error']);
    }

    $api->setResponse($return, 200);
}

if (isset($_GET['controller']) && $_GET['controller'] == 'add') {

    $post = $api->jsonBody();

    $result = $scanCategoryRestriction->add($post['data']);

    if ($result['error'] == false) {
        $return = array('success' => 1, 'message' => 'Success');
    } else {
        $return = array('success' => 0, 'message' => $result['error']);
    }

    $api->setResponse($return, 200);
}
