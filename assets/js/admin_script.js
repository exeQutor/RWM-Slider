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
            $('.source_image .controls').append('<br><br><img src="'+attachment.url+'" class="thumbnail">');
            $('.source_image input[type=hidden]').val(attachment.url);
        });
        
        file_frame.open();
        
    });
    
    $('.form-horizontal #type').change(function(){
        var this_value = $(this).val();

        //console.log($('.form-horizontal #source').val(''));
        
        //$('.form-horizontal #source').val('');
        
        if (this_value == 'image') {
            //$('label[for=source]').text('Image');
            //$('.form-horizontal .source_controls').show();
            $('.form-horizontal .source_image').show();
            $('.form-horizontal .source_video').hide();
        } else if (this_value == 'video') {
            //$('label[for=source]').text('Video URL');
            //$('.form-horizontal .source_controls').show();
            $('.form-horizontal .source_video').show();
            //$('.form-horizontal .source_image').hide();
            $('.form-horizontal .source_image').show();
        } else if (this_value == 'text') {
            //$('.form-horizontal .source_controls').hide();
            $('.form-horizontal .source_image').hide();
            $('.form-horizontal .source_video').hide();
        }
    });
    
    $('.form-horizontal #source').keyup(function(){
        /*
            VIDEO EMBED
         */
        var url = $(this).val();
        
        var platforms = new Array();
        platforms[0] = 'youtube';
        platforms[1] = 'vimeo';
        platforms[2] = 'facebook';
        
        var platform = 'unknown';
        var regex = '';
        var embed = '<img src="//placehold.it/460x300&text=Invalid">';
        
        for (var i = 0; i<platforms.length; i++) {
            if (url.indexOf(platforms[i]) != -1)
                platform = platforms[i];
        }
        
        switch (platform) {
            case 'youtube':
                    console.log('youtube embed');
                    regex = /(\?v=|\&v=|\/\d\/|\/embed\/|\/v\/|\.be\/)([a-zA-Z0-9\-\_]+)/;
                    embed = '<iframe width="460" height="300" src="//www.youtube.com/embed/%VIDEO_ID%" frameborder="0" allowfullscreen></iframe>';
                break;
                
            case 'vimeo':
                    console.log('vimeo embed');
                    regex = /http:\/\/(www\.)?vimeo.com\/(\d+)($|\/)/;
                    embed = '<iframe src="//player.vimeo.com/video/%VIDEO_ID%?title=0&amp;byline=0&amp;portrait=0" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
                break;
                
            case 'facebook':
                    console.log('facebook embed');
                    regex = /((http:\/\/(www\.facebook\.com\/photo\.php.*|www\.facebook\.com\/video\/video\.php.*|www\.facebook\.com\/.*\/posts\/.*|fb\.me\/.*))|(https:\/\/(www\.facebook\.com\/photo\.php.*|www\.facebook\.com\/video\/video\.php.*|www\.facebook\.com\/.*\/posts\/.*|fb\.me\/.*)))/i;
                    embed = '<iframe src="http://www.facebook.com/video/embed?video_id=%VIDEO_ID%" width="770" height="578" frameborder="0"></iframe>';
                break;
                
            default:
                console.log('unknown embed');
        }
        
        var result = url.match(regex);
        
        if (result) {
            embed = embed.replace('%VIDEO_ID%', result[2]);
        }
        
        $('#video_preview').remove();
        $(this).after('<div id="video_preview" style="margin-top: 20px">'+embed+'</div>');
    });
    
    $('form.edit_slider').submit(function(){
        var form_action = $(this).prop('action');
        var submit_button = $(this).find('.form-actions button');
        var post_data = new Object();
        var selected_children = Array();
        var sc = 0;
        
        submit_button.addClass('disabled');
        submit_button.after(' <img src="./images/loading.gif" />');
        
        $(this).find(':input').each(function(index, element){
            if (element.name) {
                if (element.multiple) {
                    for (var i=0; i<element.children.length; i++) {
                        if (element.children[i].selected) {
                            selected_children[sc] = element.children[i].value;
                            sc++;
                        }
                    }
                    
                    post_data[element.name] = selected_children;
                } else {
                    post_data[element.name] = element.value;
                }
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
    
    $('table.table-sortable tbody').sortable({
        stop: function(e, ui) {
            var sliders = new Array();
            var i = 0;
            
            $('table.table tbody tr').each(function() {
                sliders[i] = $(this).data('slider-id');
                i++;
            });
            
            $.post(ajaxurl, {
                action: 'rwms_sortable_change',
                sliders: sliders
        	}, function(response) {
                console.log(response);
        	});
        }
    });
    
    $('table.table-sortable tbody').sortable().disableSelection();
    
    $('.btn-group .btn-danger').click(function(){
        return confirm('Are you sure?');
    });
});