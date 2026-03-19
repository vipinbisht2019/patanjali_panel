<?php
require_once '../../config.php';
include VIEW_DIR . '/includes/header.php';
?>
<div class="content-wrapper">
    <h1 class="pageMainTitle">Add Feedback Options</h1>
    <div class="card studentRegWrap mt20">
        <div class="card-body">
            <div class="box-body">

                <div class="cs_row">
                    <div class="col_4 form-group item-row">
                        <label for="">Option Name</label>
                        <input class="form-control" id="optionName" value="" data-validate="" data-msg="Please enter Option name." type="text" placeholder="Option Name">
                    </div>
                    <div class="col_4 form-group item-row">
                        <label for="">Status</label>
                        <select class="form-control"  id="optionStatus" >
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>          

            </div>
            <div class="actions clearfix">
                <button class="btn btn-save" id="saveOption">Submit</button>
            </div>
        </div>
    </div>
</div>
<?php
$moduleScripts[] = VIEW_PATH . '/feedback/js/feedback-options.js';
include VIEW_DIR . '/includes/footer.php';
?>