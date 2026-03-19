<?php
require_once '../../config.php';
include VIEW_DIR.'/includes/header.php';
?>
<div class="content-wrapper">
    <h1 class="pageMainTitle">Feedback Options</h1>
    <section class="content-header clfix">
        <a href="<?php echo APP_URL; ?>/feedback-options/add" class="btn btn-cs btn-add" id="addNewRecord"><i class="mdi mdi-plus"></i> Add New</a>
    </section> 
    <div class="table-flex mt20" id="datatable" data-page="1" data-limit="10">
        <div class="thead">
            <div class="tr">
                <div class="th">Feedback Options</div>
                <div class="th">Status</div>
                <div class="th">Action</div>
            </div>
        </div>
        <div class="tbody" id="dataTableResult"></div>
    </div>
    <div id="dataPagination"></div>
</div>

<?php 
    $moduleScripts[] = VIEW_PATH.'/feedback/js/feedback-options.js';
    include VIEW_DIR.'/includes/footer.php';
?>