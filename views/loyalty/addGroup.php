<?php
require_once '../../config.php';
include VIEW_DIR.'/includes/header.php';
?>
<div class="content-wrapper">
<h1 class="pageMainTitle">Add Main Group</h1>
    <div class="card studentRegWrap mt20">
        <div class="card-body">
            <div class="box-body">
                <form id="saveGroupForm" action="#" method="post">
                    <div class="row form-group">
                        <div class="col-sm-3">
                            <label>Main Group Name</label>
                            <input type="text" class="form-control validate" id="group_name" data-validate="" data-msg="Enter main group name"/>
                        </div>
                        <div class="col-sm-3">
                            <label>ERP ID</label>
                            <input type="text" class="form-control " id="erp_id"/>
                        </div>
                        <div class="col-sm-1 btnCol">
                            <button class="cs-btn-search cs-btn-lg cs-btn-block" type="submit">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php 
    $moduleScripts[] = VIEW_PATH.'/loyalty/js/groups.js';
	include VIEW_DIR.'/includes/footer.php';
?>