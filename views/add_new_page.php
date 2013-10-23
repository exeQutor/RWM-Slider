<style>
.source_video {
    display: none;
}
</style>
<div class="wrap">
    <?php include 'header.php' ; ?>
    
    <form method="post" class="form-horizontal" action="admin.php?page=<?php echo RWMs_PREFIX; ?>add_new">
        <?php wp_nonce_field(RWMs_PREFIX . 'add_new', RWMs_PREFIX . 'nonce'); ?>
        <fieldset>
            <legend>Create your slider message</legend>
            
            <div class="control-group">
                <label class="control-label" for="group">Group</label>
                <div class="controls">
                    <?php if (count($group_array)): ?>
                    <?php $disabled = ''; ?>
                    <select name="<?php echo RWMs_PREFIX . 'fields[group]'; ?>" id="group" multiple="multiple">
                    <?php foreach ($group_array as $row): ?>
                        <option value="<?php echo $row->slider_group_id; ?>"><?php echo $row->slider_group_name; ?></option>
                    <?php endforeach; ?>
                    </select>
                    <?php else: ?>
                    <?php $disabled = ' disabled="true"'; ?>
                    <div class="alert alert-info">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <p><strong>There are no slider groups yet</strong>. Click here to create: <a href="admin.php?page=rwms_groups" class="btn">Create</a></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="heading">Heading</label>
                <div class="controls">
                    <input type="text" name="<?php echo RWMs_PREFIX . 'fields[heading]'; ?>" id="heading" class="input-xxlarge" style="height: 30px;" placeholder="Heading / Title">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="subheading">Subheading</label>
                <div class="controls">
                    <input type="text" name="<?php echo RWMs_PREFIX . 'fields[subheading]'; ?>" id="subheading" class="input-xxlarge" style="height: 30px;" placeholder="Subheading / Tagline">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="text">Main Text</label>
                <div class="controls">
                    <textarea rows="10" name="<?php echo RWMs_PREFIX . 'fields[text]'; ?>" id="text" class="input-xxlarge" placeholder="Main Text / Content"></textarea>
                </div>
            </div>
            
            <legend>Add your media</legend>
            
            <div class="control-group">
                <label class="control-label" for="type">Type</label>
                <div class="controls">
                    <select name="<?php echo RWMs_PREFIX . 'fields[type]'; ?>" id="type">
                    <?php foreach ($type_array as $key => $value): ?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="control-group source_controls">
                <label class="control-label" for="source">Image</label>
                <div class="controls">
                    <div class="source_image">
                        <input type="hidden" name="<?php echo RWMs_PREFIX . 'fields[source_image]'; ?>">
                        <button type="button" id="wp_media_uploader" class="btn" data-frame-title="<?php echo RWMs_SINGULAR; ?> Uploader" data-frame-button-text="Set as slider image">Choose File</button>
                    </div>
                    
                    <div class="source_video">
                        <input type="text" name="<?php echo RWMs_PREFIX . 'fields[source_video]'; ?>" id="source" class="input-xxlarge" style="height: 30px;" placeholder="Video URL">
                    </div>
                </div>
            </div>
            
            <legend>Choose your style</legend>
            
            <div class="control-group">
                <label class="control-label" for="text_pos">Text Position</label>
                <div class="controls">
                    <select name="<?php echo RWMs_PREFIX . 'fields[text_pos]'; ?>" id="text_pos">
                        <?php foreach ($text_pos_array as $key => $value): ?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="textbox_bg">Textbox Background</label>
                <div class="controls">
                    <select name="<?php echo RWMs_PREFIX . 'fields[textbox_bg]'; ?>" id="textbox_bg">
                        <?php foreach ($textbox_bg_array as $key => $value): ?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="btn_type">Button Type</label>
                <div class="controls">
                    <select name="<?php echo RWMs_PREFIX . 'fields[btn_type]'; ?>" id="btn_type">
                        <?php foreach ($btn_type_array as $key => $value): ?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="btn_text">Button Text</label>
                <div class="controls">
                    <input type="text" name="<?php echo RWMs_PREFIX . 'fields[btn_text]'; ?>" id="btn_text" class="input-xlarge" style="height: 30px;" placeholder="Button Text / Label">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="btn_url">Button URL</label>
                <div class="controls">
                    <input type="text" name="<?php echo RWMs_PREFIX . 'fields[btn_url]'; ?>" id="btn_url" class="input-xxlarge" style="height: 30px;" placeholder="Button URL / Link">
                </div>
            </div>
            
            <?php if (count($alert) && $alert['message']): ?>
            <div class="alert alert-<?php echo $alert['type']; ?>"<?php echo (isset($slider_id) && ! empty($slider_id)) ? ' data-slider-id="'.$slider_id.'"' : ''; ?>>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $alert['message']; ?>
            </div>
            <?php endif; ?>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-large"<?php echo $disabled; ?>>Create Slider <i class="icon icon-plus-sign icon-white"></i></button>
            </div>
        </fieldset>
    </form>
</div>