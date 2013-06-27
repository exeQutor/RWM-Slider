jQuery(document).ready(function($){
    var file_frame;
    
    // WP MEDIA UPLOADER
    $('#wp_media_uploader').live('click', function(event) {
        var this_button = $(this);
        
        event.preventDefault();
        
        if (file_frame) {
            file_frame.open();
            return;
        }
        
        file_frame = wp.media.frames.file_frame = wp.media({
            title: $(this).data('frame-title'),
            button: {
                text: $(this).data('frame-button-text'),
            },
            multiple: false
        });
        
        file_frame.on('select', function() {
            attachment = file_frame.state().get('selection').first().toJSON();
            
            $('.source_image').find('img,br').remove();
            $('.source_image').append('<br><br><img src="'+attachment.url+'">');
            $('.source_image input[type=hidden]').val(attachment.url);
        });
        
        file_frame.open();
        
    });
    
    $('.form-horizontal #type').change(function(){
        var this_value = $(this).val();
        
        if (this_value == 'image') {
            $('label[for=source]').text('Image');
            $('.form-horizontal .source_controls').show();
            $('.form-horizontal .source_image').show();
            $('.form-horizontal .source_video').hide();
        } else if (this_value == 'video') {
            $('label[for=source]').text('Video ID');
            $('.form-horizontal .source_controls').show();
            $('.form-horizontal .source_video').show();
            $('.form-horizontal .source_image').hide();
        } else if (this_value == 'text') {
            $('.form-horizontal .source_controls').hide();
        }
    });
    
    $('.form-horizontal #source').keyup(function(){
        $(this).next('iframe').remove();
        $(this).after('<iframe width="460" height="300" style="margin-top: 20px;" src="//www.youtube.com/embed/'+$(this).val()+'" frameborder="0" allowfullscreen></iframe>');
    });
    
    $('form.edit_slider').submit(function(){
        var form_action = $(this).prop('action');
        var submit_button = $(this).find('.form-actions button');
        var post_data = new Object();
        
        submit_button.addClass('disabled');
        submit_button.after(' <img src="./images/loading.gif" />');
        
        $(this).find(':input').each(function(index, element){
            if (element.name) {
                post_data[element.name] = element.value;
            }
        });
        
        $.post(form_action, post_data, function(response){
            var alert_div = $(response).find('.alert').get(0);
            
            $('.form-actions').before(alert_div);
            $('.alert').delay(2000).fadeOut();
            
            submit_button.removeClass('disabled');
            submit_button.next('img').remove();
        });
        
        return false;
    });
    
    $('table.table tbody').sortable({
        stop: function(e, ui) {
            var sliders = new Array();
            var i = 0;
            
            $('table.table tbody tr').each(function() {
                sliders[i] = $(this).data('slider-id');
                i++;
            });
            
            //$('#sortable_sliders').val(sliders);
            
            $.post(ajaxurl, {
        		action: 'rwms_sortable_change',
                sliders: sliders
        	}, function(response) {
               console.log(response);
        	});
        }
    });
    
    $('table.table tbody').sortable().disableSelection();
    
    $('.btn-group .btn-danger').click(function(){
        return confirm('Are you sure?');
    });
});