<div class="wrap">
    <?php include 'header.php' ; ?>
    
    <?php if ($slider_groups): ?>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th></th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach ($slider_groups as $data): ?>
            <tr data-slider-group-id="<?php echo $slider_group->slider_group_id; ?>">
                <td><?php echo $data->slider_group_id; ?></td>
                <td><?php echo $data->slider_group_name; ?></td>
                <td><?php echo $data->slider_group_description; ?></td>
                <td>
                    <div class="btn-group">
                        <a href="admin.php?page=rwms_groups&action=edit&id=<?php echo $data->slider_group_id; ?>" class="btn">Edit <i class="icon icon-edit"></i></a>
                        <a href="admin.php?page=rwms_groups&action=delete&id=<?php echo $data->slider_group_id; ?>" class="btn btn-danger">Delete <i class="icon icon-remove icon-white"></i></a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <p><strong>There are no slider groups yet</strong>. Use the form below to create one.</p>
    </div>
    <?php endif; ?>
    
    <?php if (empty($_GET['action']) || $_GET['action'] == 'delete'): ?>
    <form method="post" class="form-horizontal" action="admin.php?page=<?php echo RWMs_PREFIX; ?>groups">
        <?php wp_nonce_field(RWMs_PREFIX . 'groups', RWMs_PREFIX . 'nonce'); ?>
        <fieldset>
            <legend>Create a slider group</legend>
            
            <div class="control-group">
                <label class="control-label" for="name">Name</label>
                <div class="controls">
                    <input type="text" name="<?php echo RWMs_PREFIX . 'fields[name]'; ?>" id="name" class="input-xxlarge" style="height: 30px;" placeholder="Name">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="text">Description</label>
                <div class="controls">
                    <textarea rows="10" name="<?php echo RWMs_PREFIX . 'fields[description]'; ?>" id="description" class="input-xxlarge" placeholder="Description"></textarea>
                </div>
            </div>
            
            <?php if (count($alert) && $alert['message']): ?>
            <div class="alert alert-<?php echo $alert['type']; ?>"<?php echo (isset($slider_group_id) && ! empty($slider_group_id)) ? ' data-slider-group-id="'.$slider_group_id.'"' : ''; ?>>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $alert['message']; ?>
            </div>
            <?php endif; ?>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-large">Create Slider Group <i class="icon icon-plus-sign icon-white"></i></button>
            </div>
        </fieldset>
    </form>
    
    <?php else: ?>
    
    <form method="post" class="form-horizontal" action="admin.php?page=<?php echo RWMs_PREFIX; ?>groups">
        <?php wp_nonce_field(RWMs_PREFIX . 'groups', RWMs_PREFIX . 'nonce'); ?>
        <fieldset>
            <legend>Edit a slider group</legend>
            
            <div class="control-group">
                <label class="control-label" for="name">Name</label>
                <div class="controls">
                    <input type="text" name="<?php echo RWMs_PREFIX . 'fields[name]'; ?>" value="<?php echo $slider_group->slider_group_name; ?>" id="name" class="input-xxlarge" style="height: 30px;" placeholder="Name">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="text">Description</label>
                <div class="controls">
                    <textarea rows="10" name="<?php echo RWMs_PREFIX . 'fields[description]'; ?>" id="description" class="input-xxlarge" placeholder="Description"><?php echo $slider_group->slider_group_description; ?></textarea>
                </div>
            </div>
            
            <?php if (count($alert) && $alert['message']): ?>
            <div class="alert alert-<?php echo $alert['type']; ?>"<?php echo (isset($slider_group->slider_group_id) && ! empty($slider_group->slider_group_id)) ? ' data-slider-group-id="'.$slider_group->slider_group_id.'"' : ''; ?>>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo $alert['message']; ?>
            </div>
            <?php endif; ?>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-large">Update Slider Group <i class="icon icon-ok-sign icon-white"></i></button>
            </div>
            
            <input type="hidden" name="<?php echo RWMs_PREFIX . 'fields[action]'; ?>" value="edit" />
            <input type="hidden" name="<?php echo RWMs_PREFIX . 'fields[id]'; ?>" value="<?php echo $_GET['id']; ?>" />
        </fieldset>
    </form>
    <?php endif; ?>
</div>