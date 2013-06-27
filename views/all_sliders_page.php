<div class="wrap">
    <?php include 'header.php' ; ?>
    
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Type</th>
                <th>Heading</th>
                <th>Subheading</th>
                <th>Button URL</th>
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
                <td><a href="admin.php?page=rwm_slider&action=edit&id=<?php echo $sliders[$sorted_slider]->slider_id; ?>"><?php echo $sliders[$sorted_slider]->slider_heading; ?></a></td>
                <td><?php echo $sliders[$sorted_slider]->slider_subheading; ?></td>
                <td><?php echo $sliders[$sorted_slider]->slider_btn_url; ?></td>
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
    <!--input type="text" id="sortable_sliders" value="<?php echo get_option(RWMs_PREFIX . 'sliders'); ?>" /-->
</div>