jQuery(document).ready(function($){
    $('.form-horizontal').submit(function(){
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
            
            if (alert_div.className.indexOf('success') != -1) {
                setTimeout(function(){
                    window.location.href = 'admin.php?page=rwms_groups';
                }, 0);
            }
            
            submit_button.removeClass('disabled');
            submit_button.next('img').remove();
        });
        
        return false;
    });
});