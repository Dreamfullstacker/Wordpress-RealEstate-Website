(function ($) {
    "use strict";

    $(document).ready(function () {


    /*-----------------------------------------------------------------------------------*/
    /*	Ajax to Add Note
    /*-----------------------------------------------------------------------------------*/

        $(function () {
            $('body').on('click','#submit-note', function (e) {
                e.preventDefault();


                var thisElement = $(this);

                var thisParent = thisElement.parent('.recrm_note_fields');

                var contentField = thisParent.find('#comment_meta_box');
                var contentFieldValue = contentField.val();
                var contentFieldValueTrim = contentField.val().trim();

                var postIdFieldValue = thisParent.find('#recrm_current_post_id').val();
                var timeFieldValue = thisParent.find('#recrm_current_time').val();
                var userFieldValue = thisParent.find('#recrm_current_user').val();
                var userGravatar = thisParent.find('#recrm_current_user_avatar').val();



                if (contentFieldValueTrim.length === 0 ){
                    contentField.addClass('empty-error');


                } else {
                    thisParent.find('.recrm_ajax_loader').removeClass('recrm_hide');
                    thisParent.find('.recrm_cancel_note').addClass('recrm_disable');

                    thisElement.addClass('recrm_disable');

                    $.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: {
                            action: 'recrm_save_communication',
                            security: RECRM_ajax_handle.security,
                            comment_note: contentFieldValue,
                            post_Id: postIdFieldValue,
                        },
                        success: function (comment_id) {


                            var valueInLineBreak = contentFieldValue.replace(/\n/g,'<br/>');
                            //console.log(comment_id);
                            $('.recrm_note_list_wrapper').prepend(
                                '<div class="recrm_wrapper_note_stream note_temp_ajax">' +
                                '<div class="recrm_note_head">' +
                                '<div class="note_thumb">' +
                                '<span class="note_gravatar">' +
                                '<img src="' + userGravatar + '">' +
                                '</span>' +
                                '<h4> ' + userFieldValue + '</h4>' +
                                '</div>' +
                                '<div class="note_time">' +
                                '<span class="recrm_note_date">' + RECRM_ajax_handle.added_by + '</span>' +
                                '</div>' +
                                '</div>' +
                                '<div class="recrm_note_content">' +
                                '<p>' + valueInLineBreak + '</p>' +
                                '</div>' +
                                '<input type="hidden" name="recrm_note_id" id="recrm_note_id" value="' + comment_id + ' ">' +
                                '<span class="recrm_delete_note">' + RECRM_ajax_handle.delete + '</span>' +
                                '</div>'
                            );

                            $('#comment_meta_box').val('');
                            $('#comment_meta_box').focus();

                        },
                        complete: function(){
                            thisElement.removeClass('recrm_disable');
                            thisParent.find('.recrm_cancel_note').removeClass('recrm_disable');
                            thisParent.find('.recrm_ajax_loader').addClass('recrm_hide');
                        },
                        error: function(response) {
                            alert('An Error Occurred' +' '+response.status);
                        }

                    });
                }

                contentField.on('keyup',function(){
                    contentField.removeClass('empty-error')
                });

            });
        });


        /*-----------------------------------------------------------------------------------*/
        /*	Ajax to Remove Note
         /*-----------------------------------------------------------------------------------*/
        $(function(){
            $('.recrm_note_list_wrapper').on('click','.recrm_delete_note',function(){
                var thisElement = $(this);
                var thisParent = $(this).parents('.recrm_wrapper_note_stream');
                var thisNote = thisParent.find('input');
                var thisNoteValue =  thisNote.val();

                thisParent.find('.recrm_ajax_loader').removeClass('recrm_hide');
                thisElement.addClass('recrm_disable');
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {
                        action: 'recrm_remove_note',
                        post_Id: thisNoteValue,
                        security_delete: RECRM_ajax_handle.security_delete,
                    },
                    success: function () {
                        thisParent.slideUp();
                    },
                    error: function(response) {
                        alert('An Error Occurred' +' '+response.status);
                    },
                    complete: function(){
                        thisElement.removeClass('recrm_disable');
                        thisParent.find('.recrm_ajax_loader').addClass('recrm_hide');
                    },
                });

            });
        });

    });

})(jQuery);