<?php
require_once '../../config.php';
include VIEW_DIR . '/includes/header.php';
require_once CLASS_DIR . '/Feedback.php';

$feedback = new Feedback();
$id = $_GET['id'];
$option_info = $feedback->getOptionDetail($id);
?>
<div class="content-wrapper">
    <h1 class="pageMainTitle">Edit Feedback Options</h1>
    <div class="card studentRegWrap mt20">
        <div class="card-body">
                <div class="box-body">
                    <div class="cs_row">
                        <div class="col_4 form-group item-row">
                            <label for="">Option Name</label>
                            <input type="hidden" name="optionId" id="optionId" value="<?php echo $option_info[0]['id']; ?>">
                            <input class="form-control" id="optionName" value="<?php echo $option_info[0]['name']; ?>" data-validate="" data-msg="Please enter Option name." type="text" placeholder="Option Name">
                        </div>
                        <div class="col_4 form-group item-row">
                            <label for="">Status</label>
                            <select class="form-control"  id="optionStatus" >
                                <option value="1" <?php echo $option_info[0]['id']==1?'selected':''?> >Active</option>
                                <option value="0" <?php echo $option_info[0]['id']==1?'selected':''?> >Inactive</option>
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