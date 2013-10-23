<div class="wrap">
    <?php include 'header.php' ; ?>
    
    <?php if ($sorted_sliders): ?>
    <table class="table table-sortable">
        <thead>
            <tr>
                <th>#</th>
                <th>Type</th>
                <th>Heading</th>
                <th>Subheading</th>
                <th>Group(s)</th>
                <th></th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach ($sorted_sliders as $sorted_slider): ?>
            <?php
                if ($sliders[$sorted_slider]->slider_type == 'text') {
                    $label = '';
                } else {
                    if ($sliders[$sorted_slider]->slider_type == 'image') {
                        $label = ' label-important';
                    } else {
                        $label = ' label-info';
                    }
                }
            ?>
            <tr data-slider-id="<?php echo $sliders[$sorted_slider]->slider_id; ?>">
                <td><?php echo $sliders[$sorted_slider]->slider_id; ?></td>
                <td><span class="label<?php echo $label; ?>"><?php echo $sliders[$sorted_slider]->slider_type; ?></span></td>
                <td><a href="admin.php?page=rwm_slider&action=edit&id=<?php echo $sliders[$sorted_slider]->slider_id; ?>"><?php echo stripslashes($sliders[$sorted_slider]->slider_heading); ?></a></td>
                <td><?php echo stripslashes($sliders[$sorted_slider]->slider_subheading); ?></td>
                <td>
                <?php $relationships = $this->slider->fetch_relationships($sliders[$sorted_slider]->slider_id); ?>
                <?php foreach ($relationships as $relationship): ?>
                <span class="label"><?php echo $relationship->slider_group_name; ?></span>
                <?php endforeach; ?>
                
                <?php
//                $sliders[$sorted_slider]->slider_group_id;
//                $group = $this->slider->get_group($sliders[$sorted_slider]->slider_group_id);
//                echo $group->slider_group_name;
                ?></td>
                <td>
                    <div class="btn-group">
                        <a href="admin.php?page=rwm_slider&action=edit&id=<?php echo $sliders[$sorted_slider]->slider_id; ?>" class="btn">Edit <i class="icon icon-edit"></i></a>
                        <a href="admin.php?page=rwm_slider&action=delete&id=<?php echo $sliders[$sorted_slider]->slider_id; ?>" class="btn btn-danger">Delete <i class="icon icon-remove icon-white"></i></a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <p><strong>There are no sliders yet</strong>. Click here to create: <a href="admin.php?page=rwms_add_new" class="btn">Create</a></p>
    </div>
    <?php endif; ?>
    
    <?php // for debug purposes ?>
    <input type="hidden" id="sortable_sliders" value="<?php echo get_option(RWMs_PREFIX . 'sliders'); ?>" />
</div>