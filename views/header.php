    <?php
        $page = $_GET['page'];
        $action = $_GET['action'];
        
    	$pages = array(
            RWMs_SLUG => 'All Sliders',
            RWMs_PREFIX . 'add_new' => 'Add New Slider',
            RWMs_PREFIX . 'groups' => 'Slider Groups',
            RWMs_PREFIX . 'import_export' => 'Import / Export'
        );
    ?>
    
    <div class="page-header">
        <h2>RWM Slider <small><?php echo RWMs_VERSION; ?></small></h2>
    </div>
    
    <ul class="nav nav-tabs">
        <?php foreach ($pages as $key => $value): ?>
        <?php $active = ($key == $page) ? (isset($action)) ? '' : ' class="active"' : ''; ?>
        <li<?php echo $active; ?>>
            <a href="admin.php?page=<?php echo $key; ?>"><?php echo $value; ?></a>
        </li>
        <?php endforeach; ?>
        <?php if (isset($action) && $action == 'edit' && $page == 'rwm_slider'): ?>
        <li class="active">
            <a href="#">Edit Slider</a>
        </li>
        <?php endif; ?>
        <?php if (isset($action) && $action == 'edit' && $page == 'rwms_groups'): ?>
        <li class="active">
            <a href="#">Edit Slider Group</a>
        </li>
        <?php endif; ?>
    </ul>