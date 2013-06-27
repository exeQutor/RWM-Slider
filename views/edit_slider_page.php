<style>
<?php if ($slider->slider_type == 'image'): ?>
.source_video {
    display: none;
}
.source_image {
    display: block;
}
<?php endif; ?>
<?php if ($slider->slider_type == 'video'): ?>
.source_video {
    display: block;
}
.source_image {
    display: none;
}
<?php endif; ?>
<?php if ($slider->slider_type == 'text'): ?>
.source_controls {
    display: none;
}
<?php endif; ?>
</style>
<div class="wrap">
    <?php include 'header.php' ; ?>
    
    <form method="post" class="form-horizontal edit_slider" action="admin.php?page=<?php echo RWMs_SLUG; ?>&action=edit&id=<?php echo $slider->slider_id; ?>">
        <?php wp_nonce_field(RWMs_PREFIX . 'edit_slider', RWMs_PREFIX . 'nonce'); ?>
        <fieldset>
            <legend>Update your slider message</legend>
            
            <div class="control-group">
                <label class="control-label" for="heading">Heading</label>
                <div class="controls">
                    <input type="text" name="<?php echo RWMs_PREFIX . 'fields[heading]'; ?>" id="heading" value="<?php echo $slider->slider_heading; ?>" class="input-xxlarge" style="height: 30px;" placeholder="Heading / Title">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="subheading">Subheading</label>
                <div class="controls">
                    <input type="text" name="<?php echo RWMs_PREFIX . 'fields[subheading]'; ?>" id="subheading" value="<?php echo $slider->slider_subheading; ?>" class="input-xxlarge" style="height: 30px;" placeholder="Subheading / Tagline">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="text">Main Text</label>
                <div class="controls">
                    <textarea rows="10" name="<?php echo RWMs_PREFIX . 'fields[text]'; ?>" id="text" class="input-xxlarge" placeholder="Main Text / Content"><?php echo $slider->slider_text; ?></textarea>
                </div>
            </div>
            
            <legend>Edit your media</legend>
            
            <div class="control-group">
                <label class="control-label" for="type">Type</label>
                <div class="controls">
                    <select name="<?php echo RWMs_PREFIX . 'fields[type]'; ?>" id="type">
                        <?php foreach ($type_array as $key => $value): ?>
                        <?php $selected = ($slider->slider_type == $key) ? ' selected' : ''; ?>
                        <option value="<?php echo $key; ?>"<?php echo $selected; ?>><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <?php $source_label = ($slider->slider_type != 'text') ? ($slider->slider_type == 'image') ? 'Image' : 'Video ID' : ''; ?>
            
            <div class="control-group source_controls">
                <label class="control-label" for="source"><?php echo $source_label; ?></label>
                <div class="controls">
                    <div class="source_image">
                        <input type="hidden" name="<?php echo RWMs_PREFIX . 'fields[source_image]'; ?>" value="<?php echo $slider->slider_src; ?>">
                        <button type="button" id="wp_media_uploader" class="btn" data-frame-title="<?php echo RWMs_SINGULAR; ?> Uploader" data-frame-button-text="Set as slider image">Choose File</button>
                        <?php if ($slider->slider_type == 'image'): ?>
                        <br><br><img src="<?php echo $slider->slider_src; ?>" />
                        <?php endif; ?>
                    </div>
                    
                    <div class="source_video">
                        <input type="text" name="<?php echo RWMs_PREFIX . 'fields[source_video]'; ?>" id="source" value="<?php echo $slider->slider_src; ?>"class="input-xxlarge" style="height: 30px;" placeholder="Video ID">
                        <?php if ($slider->slider_type == 'video'): ?>
                        <iframe width="460" height="300" style="margin-top: 20px;" src="//www.youtube.com/embed/<?php echo $slider->slider_src; ?>" frameborder="0" allowfullscreen></iframe>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <legend>Change your style</legend>
            
            <div class="control-group">
                <label class="control-label" for="text_pos">Text Position</label>
                <div class="controls">
                    <select name="<?php echo RWMs_PREFIX . 'fields[text_pos]'; ?>" id="text_pos">
                        <?php foreach ($text_pos_array as $key => $value): ?>
                        <?php $selected = ($slider->slider_text_pos == $key) ? ' selected' : ''; ?>
                        <option value="<?php echo $key; ?>"<?php echo $selected; ?>><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="btn_type">Button Type</label>
                <div class="controls">
                    <select name="<?php echo RWMs_PREFIX . 'fields[btn_type]'; ?>" id="btn_type">
                        <?php foreach ($btn_type_array as $key => $value): ?>
                        <?php $selected = ($slider->slider_btn_type == $key) ? ' selected' : ''; ?>
                        <option value="<?php echo $key; ?>"<?php echo $selected; ?>><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="btn_text">Button Text</label>
                <div class="controls">
                    <input type="text" name="<?php echo RWMs_PREFIX . 'fields[btn_text]'; ?>" id="btn_text" value="<?php echo $slider->slider_btn_text; ?>" class="input-xlarge" style="height: 30px;" placeholder="Button Text / Label">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="btn_url">Button URL</label>
                <div class="controls">
                    <input type="text" name="<?php echo RWMs_PREFIX . 'fields[btn_url]'; ?>" id="btn_url" value="<?php echo $slider->slider_btn_url; ?>" class="input-xxlarge" style="height: 30px;" placeholder="Button URL / Link">
                </div>
            </div>
            
            <?php if (count($alert) && $alert['message']): ?>
            <div class="alert alert-<?php echo $alert['type']; ?>">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $alert['message']; ?>
            </div>
            <?php endif; ?>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-large">Update Slider <i class="icon icon-ok-sign icon-white"></i></button>
            </div>
        </fieldset>
    </form>
</div>