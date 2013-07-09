<div class="wrap">
    <?php include 'header.php' ; ?>
    
    <h2>Export</h2>
    <p><a href="admin.php?page=<?php echo $page; ?>&action=export" class="btn btn-info">Export All as JSON file</a></p>
    <hr />
    
    <h2>Import</h2>
    
    <form enctype="multipart/form-data" action="admin.php?page=<?php echo $page; ?>&action=import" method="POST">
        <div class="fileupload fileupload-new" data-provides="fileupload">
            <div class="input-append">
                <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><input type="file" name="uploadedfile" /></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
            </div>
        </div>
        
        <?php if (isset($form_message) && ! empty($form_message)): ?>
        <div class="alert alert-<?php echo $form_alert; ?>">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <?php echo $form_message; ?>
        </div>
        <?php endif; ?>
        
        <button type="submit" class="btn btn-success">Upload &amp; Import a JSON file</button>
    </form>
</div>