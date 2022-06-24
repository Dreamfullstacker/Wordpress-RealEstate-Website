(function ($) {
    "use strict";

    $(document).ready(function () {

        /*-----------------------------------------------------------------------------------*/
        /*	Managing admin menu
        /*-----------------------------------------------------------------------------------*/
        $(function () {
            //$('.showstore').hide();
            //$('.showbrand').hide();
            if ($('input:checked').val() == "cpt") {
                $("#recrm_settings select").attr('disabled', false);
            } else if ($('input:checked').val() == "user") {
                $("#recrm_settings select").attr('disabled', true);

            }

            $("#recrm_settings input:radio").on('click', function () {
                if ($('input:checked').val() == "cpt") {
                    $("#recrm_settings select").attr('disabled', false);
                } else if ($('input:checked').val() == "user") {
                    $("#recrm_settings select").attr('disabled', true);

                }
            });
        });

        $(function () {
            if ($('#toplevel_page_recrm').find('li').hasClass('current')) {
                $('#toplevel_page_recrm').addClass('wp-has-current-submenu');
            }

        });


        /*-----------------------------------------------------------------------------------*/
        /*	Removed empty container for sortable
        /*-----------------------------------------------------------------------------------*/
        $(function () {
            $('.post-type-contact #normal-sortables:empty').remove();
            $('.post-type-enquiry #normal-sortables:empty').remove();
        });

        /*-----------------------------------------------------------------------------------*/
        /*	File Upload functionality
        /*-----------------------------------------------------------------------------------*/
        $(function () {
            $('body').on('click', '.recrm_file_button', function(e){
                e.preventDefault();

                var button = $(this),
                    custom_uploader = wp.media({
                        title: RECRM_admin_handle.titleUpload,
                        library : {
                            // uncomment the next line if you want to attach image to the current post
                            // uploadedTo : wp.media.view.settings.post.id,
                            //type : 'image'
                        },
                        button: {
                            text: RECRM_admin_handle.useFile // button label text
                        },
                        multiple: false // for multiple image selection set to true
                    }).on('select', function() { // it also has "open" and "close" events
                            var attachment = custom_uploader.state().get('selection').first().toJSON();

                        $(button).parent('.recrm_wrapper_files').find('#recrm_attachment').attr('name','recrm_attachment[]');
                        $(button).parent('.recrm_wrapper_files').find('#recrm_attachment').val(attachment.id);
                        //$('.recrm_files_list').append('<div class="temp_added"><a download href="' + attachment.url + '"><img onerror="this.style.display=\'none\'" class="true_pre_image" src="' + attachment.url + '" /></a></div>');
                            $('.file_display_wrapper_temp').css('display','inline-block');
                            $('.file_display_wrapper_temp').find('img').css('opacity','1');
                        $('.file_display_wrapper_temp').find('img').attr('src',attachment.url);
                        $('.file_display_wrapper_temp').find('a').attr('href',attachment.url);
                        $('.file_display_wrapper_temp').find('img').attr('onerror',"this.style.opacity='0'");

                        })
                        .open();
            });


            $('.recrm_delete_file').on('click',function(){
               $(this).parent('.file_display_wrapper').find('input').val('');
                $(this).parent('.file_display_wrapper').addClass('file_hide');
            });


        });

        $(function () {
            $(".recrm_delete_list_temp").on('click',function(){

                $('.file_display_wrapper_temp').css('display','none');

            });
        });

        $(function () {

           $('#recrm_tabs li a').on('click',function(e){
               var thisTab = $(this);
              var getTabId =  thisTab.attr('href');
               if(! $(getTabId).hasClass('active')){

                   $('#recrm_tabs li a').removeClass('current');
                   thisTab.addClass('current');

                   $('.recrm_tab_contents').removeClass('active');
                   $(getTabId).addClass('active');
               }
               e.preventDefault();
           }) ;

        });

        $(function(){

            $('.recrm_toggle_show').on('click',function(){
                $(this).toggleClass('invert_arrow');
                $(this).siblings('.recrm_enquiry_toggle').slideToggle( "fast" );
            })

        });






    });

})(jQuery);