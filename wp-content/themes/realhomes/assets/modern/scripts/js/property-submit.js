(function($) {
    "use strict";

    $(document).ready(function() {

        if ( typeof propertySubmit !== "undefined" ) {

            var removeQueryStringParameters = function ( url ) {
                if ( url.indexOf ('?') >= 0 ) {
                    var urlParts = url.split('?');
                    return urlParts[0];
                }
                return url;
            };

            var ajaxURL = removeQueryStringParameters( propertySubmit.ajaxURL );
            var uploadNonce = propertySubmit.uploadNonce;
            var fileTypeTitle = propertySubmit.fileTypeTitle;

            /* Apply jquery ui sortable on gallery items */
            $( "#gallery-thumbs-container" ).sortable({
                revert: 100,
                placeholder: "sortable-placeholder",
                cursor: "move"
            });

            /* initialize uploader */
            var uploaderArguments = {
                browse_button: 'select-images',          // this can be an id of a DOM element or the DOM element itself
                file_data_name: 'inspiry_upload_file',
                drop_element: 'drag-and-drop',
                url: ajaxURL + "?action=ajax_img_upload&nonce=" + uploadNonce,
                filters: {
                    mime_types : [
                        { title : fileTypeTitle, extensions : "jpg,jpeg,gif,png" }
                    ],
                    max_file_size: '10000kb',
                    // prevent_duplicates: true
                },
            };

            // require gallery images field to upload at least one image
            $( '.submit-field-wrapper input[type=submit]' ).on( 'click', function(){
                if ( ! $( '#gallery-thumbs-container' ).has( "div" ).length ) {
                    $( '#drag-and-drop' ).css( 'border-color', 'red' );
                }
            });

            var uploader = new plupload.Uploader( uploaderArguments );

            uploader.init();

            $('#select-images').on('click', function(event){
                event.preventDefault();
                event.stopPropagation();
                $( '#drag-and-drop' ).css( 'border-color', '#dfdfdf' );
            });

            /* Run after adding file */
            uploader.bind('FilesAdded', function(up, files) {
                var getMaxfiles = $('.rh_drag_and_drop_wrapper').data('max-images'),
                    totalFiles  = $('.gallery-thumb').length;

                if( totalFiles >= getMaxfiles ){
                    $('.rh_max_files_limit_message').addClass('show');
                    up.splice();
                    return false;
                }else{
                    var uploads = files.slice( 0, ( getMaxfiles - totalFiles ));
                    var galleryThumbContainer = document.getElementById('gallery-thumbs-container');
                    plupload.each( uploads, function( file ) {
                        galleryThumbContainer.innerHTML += '<div id="holder-' + file.id + '" class="gallery-thumb">' + '' + '</div>';
                    });

                    up.refresh();
                    uploader.start();
                }

                $('.limit_left .uploaded').text($('.gallery-thumb').length);
            });

            /* Run during upload */
            uploader.bind('UploadProgress', function(up, file) {
                var holder = document.getElementById("holder-" + file.id);
                if ( holder ) {
                    holder.innerHTML = '<span>' + file.percent + "%</span>";
                }
            });

            /* In case of error */
            uploader.bind('Error', function( up, err ) {
                document.getElementById('errors-log').innerHTML += "Error #" + err.code + ": " + err.message + "<br/>";
            });

            /* If files are uploaded successfully */
            uploader.bind('FileUploaded', function ( up, file, ajax_response ) {
                var holder = document.getElementById("holder-" + file.id);
                var response = $.parseJSON( ajax_response.response );
                if ( response.success ) {
                    document.getElementById('errors-log').innerHTML = "";
                    if( holder ) {
                        holder.innerHTML = '<img src="' + response.url + '" alt="" />' +
                            '<a class="remove-image" data-property-id="' + 0 + '"  data-attachment-id="' + response.attachment_id + '" href="#remove-image" ><i class="far fa-trash-alt"></i></a>' +
                            '<a class="mark-featured" data-property-id="' + 0 + '"  data-attachment-id="' + response.attachment_id + '" href="#mark-featured" ><i class="far fa-star"></i></a>' +
                            '<input type="hidden" class="gallery-image-id" name="gallery_image_ids[]" value="' + response.attachment_id + '"/>' +
                            '<span class="loader"><i class="fas fa-spinner fa-spin"></i></span>';
                        bindThumbnailEvents();  // bind click event with newly added gallery thumb
                    }
                } else {
                    if( holder ) {
                        holder.remove();
                    }
                    document.getElementById('errors-log').innerHTML = response.reason;
                }
            });

            /* Bind thumbnails events with newly added gallery thumbs */
            var bindThumbnailEvents = function () {

                // unbind previous events
                $('a.remove-image').unbind('click');
                $('a.mark-featured').unbind('click');

                // Mark as featured
                $('a.mark-featured').on('click', function(event){

                    event.preventDefault();

                    var $this = $( this );
                    var starIcon = $this.find( 'i');

                    if ( starIcon.hasClass( 'far' ) ) {   // if not already featured

                        $('.gallery-thumb .featured-img-id').remove();      // remove featured image id field from all the gallery thumbs
                        $('.gallery-thumb .mark-featured i').removeClass( 'fas').addClass( 'far' );   // replace any full star with empty star

                        var $this = $( this );
                        var input = $this.siblings( '.gallery-image-id' );      //  get the gallery image id field in current gallery thumb
                        var featured_input = input.clone().removeClass( 'gallery-image-id' ).addClass( 'featured-img-id' ).attr( 'name', 'featured_image_id' );
                        // duplicate, remove class, add class and rename to full fill featured image id needs

                        $this.closest( '.gallery-thumb' ).append( featured_input );     // append the cloned ( featured image id ) input to current gallery thumb
                        starIcon.removeClass( 'far' ).addClass( 'fas' );      // replace empty star with full star
                    }

                }); // end of mark as featured click event

                // Remove gallery images
                $('a.remove-image').on('click', function(event){

                    event.preventDefault();
                    var $this = $(this);
                    var gallery_thumb = $this.closest('.gallery-thumb');
                    var loader = $this.siblings('.loader');

                    loader.show();

                    var removal_request = $.ajax({
                        url: ajaxURL,
                        type: "POST",
                        data: {
                            property_id : $this.data('property-id'),
                            attachment_id : $this.data('attachment-id'),
                            action : "remove_gallery_image",
                            nonce : uploadNonce
                        },
                        dataType: "html"
                    });

                    removal_request.done( function( response ) {
                        var result = $.parseJSON( response );
                        if( result.attachment_removed ) {
                            uploader.removeFile( gallery_thumb );
                            gallery_thumb.remove();

                            var numItems = $('.gallery-thumb').length;
                            $('.limit_left .uploaded').text(numItems);
                            $('.rh_max_files_limit_message').removeClass('show');
                        } else {
                            document.getElementById( 'errors-log' ).innerHTML += "Error : Failed to remove attachment" + "<br/>";
                        }
                    } );

                    removal_request.fail(function( jqXHR, textStatus ) {
                        alert( "Request failed: " + textStatus );
                    });

                    uploader.splice();

                });  // end of remove gallery thumb click event

            };  // end of bind thumbnail events

            bindThumbnailEvents(); // run it first time - required for property edit page

            /**
             * Attachments Related Script
             */
            var get_icon_for_extension = function($ext) {
                switch ($ext) {
                    /* PDF */
                    case 'pdf':
                        return '<i class="far fa-file-pdf"></i>';

                    /* Images */
                    case 'image':
                    case 'jpg':
                    case 'jpeg':
                    case 'png':
                    case 'gif':
                        return '<i class="far fa-file-image"></i>';

                    /* Text */
                    case 'plain':
                    case 'txt':
                    case 'log':
                    case 'tex':
                        return '<i class="far fa-file-alt"></i>';

                    /* Documents */
                    case 'doc':
                    case 'odt':
                    case 'msg':
                    case 'docx':
                    case 'rtf':
                    case 'wps':
                    case 'wpd':
                    case 'pages':
                        return '<i class="far fa-file-word"></i>';

                    /* Spread Sheets */
                    case 'csv':
                    case 'xlsx':
                    case 'xls':
                    case 'xml':
                    case 'xlr':
                        return '<i class="far fa-file-excel"></i>';

                    /* Zip */
                    case 'zip':
                    case 'rar':
                    case '7z':
                    case 'zipx':
                    case 'tar.gz':
                    case 'gz':
                    case 'pkg':
                        return '<i class="far fa-file-archive"></i>';

                    /* Others */
                    default:
                        return '<i class="far fa-file"></i>';
                }
            };

            var updateCounter = function() {
                var $items = $("#attachments-thumb-container").find('.attachment-thumb').length;

                $('#attachments-drag-and-drop .attachments-uploaded').text($items);

                return $items;
            };

            var cleanAttachmentsLog = function() {
                $('#attachments-max-upload').addClass('hide');
                $('#attachments-error-log').empty();
            };

            var inspiryAttachmentsUploader = function () {

              var updateCounter = function () {
                var $items = $("#attachments-thumb-container").find('.attachment-thumb').length;

                $('#attachments-drag-drop .attachments-uploaded').text($items);

                return $items;
              };

              var cleanAttachmentsLog = function () {
                $('#attachments-max-upload').addClass('hide');
                $('#attachments-error-log').empty();
              };

              var attachmentsUploader = new plupload.Uploader({
                browse_button: 'select-attachments',   // this can be an id of a DOM element or the DOM element itself
                file_data_name: 'inspiry_upload_file',
                drop_element: 'attachments-drag-drop',
                url: ajaxURL + "?action=ajax_attachment_upload&nonce=" + uploadNonce,
                filters: {
                  mime_types: [{
                    title: fileTypeTitle,
                    extensions: "jpg,jpeg,png,gif,pdf,zip,txt"
                  }],
                  max_file_size: '10000kb',
                  //prevent_duplicates: true
                },
              });

              attachmentsUploader.init();

              attachmentsUploader.bind('FilesAdded', function (up, files) {

                cleanAttachmentsLog();

                var uploadsLimit = $('#attachments-drag-drop').data('max-attachments'),
                    uploadedFiles = updateCounter();

                if (uploadedFiles >= uploadsLimit) {
                  $('#attachments-max-upload').removeClass('hide');
                  up.splice();
                  return false;
                } else {
                  if (files.length) {
                    var uploads = files.slice(0, (uploadsLimit - uploadedFiles));
                    var thumbContainer = $('#attachments-thumb-container');

                    plupload.each(uploads, function (file) {
                      thumbContainer.append('<div id="holder-' + file.id + '" class="attachment-thumb"></div>');
                    });

                    up.refresh();
                    up.start();
                  }
                }
              });

              attachmentsUploader.bind('UploadProgress', function (up, file) {
                var holder = document.getElementById("holder-" + file.id);
                if (holder) {
                  holder.innerHTML = '<span class="loader-lg"><i class="fas fa-spinner fa-spin"></i></span>';
                }
              });

              attachmentsUploader.bind('Error', function (up, error) {
                document.getElementById('attachments-error-log').innerHTML += "Error #" + error.code + ": " + error.message + "<br/>";
              });

              attachmentsUploader.bind('FileUploaded', function (up, file, ajax_response) {
                var holder = document.getElementById("holder-" + file.id);
                var response = $.parseJSON(ajax_response.response);
                if (response.success) {
                  var fileType = response.type.split("/");
                  document.getElementById('attachments-error-log').innerHTML = "";
                  if (holder) {
                    holder.innerHTML =
                        '<span class="attachment-icon ' + fileType[1] + '">' + get_icon_for_extension(fileType[1]) + '</span>' +
                        '<span class="attachment-title">' + response.post_title + '</span>' +
                        '<a class="remove-attachment" data-property-id="' + 0 + '"  data-attachment-id="' + response.attachment_id + '" href="#remove-attachment" ><i class="far fa-trash-alt"></i></a>' +
                        '<span class="loader"><i class="fas fa-spinner fa-spin"></i></span>' +
                        '<input type="hidden" class="attachment-id" name="property_attachment_ids[]" value="' + response.attachment_id + '"/>';

                    updateCounter();
                  }
                } else {
                  if (holder) {
                    holder.remove();
                  }
                  document.getElementById('attachments-error-log').innerHTML = response.reason;
                }
              });

              attachmentsUploader.bind('UploadComplete', function () {
                updateCounter();
              });

              /* Browse Attachment */
              $('#select-attachments').on('click', function (event) {
                event.preventDefault();
                event.stopPropagation();
              });

              /* Remove Attachment */
              $(document).on('click', 'a.remove-attachment', function (event) {
                event.preventDefault();
                var $this = $(this);
                var attachment_thumb = $this.closest('.attachment-thumb');
                var attachmentsErrorLog = document.getElementById('attachments-error-log');
                var loader = $this.siblings('.loader');

                loader.show();

                var removal_request = $.ajax({
                  url: ajaxURL,
                  type: "POST",
                  data: {
                    property_id: $this.data('property-id'),
                    attachment_id: $this.data('attachment-id'),
                    meta_key: "REAL_HOMES_attachments",
                    action: "remove_gallery_image",
                    nonce: uploadNonce
                  },
                  dataType: "html"
                });

                removal_request.done(function (response) {
                  var result = $.parseJSON(response);
                  if (result.attachment_removed) {
                    attachmentsUploader.removeFile(attachment_thumb);
                    attachment_thumb.remove();
                    cleanAttachmentsLog();
                    updateCounter();
                  } else {
                    attachmentsErrorLog.innerHTML += "Error : Failed to remove attachment" + "<br/>";
                  }
                });

                removal_request.fail(function (jqXHR, textStatus) {
                  attachmentsErrorLog.innerHTML = 'Request failed: ' + textStatus;
                });

                attachmentsUploader.splice();
              });

              /* Sort Attachment */
              $("#attachments-thumb-container").sortable({
                revert: 100,
                placeholder: "sortable-placeholder",
                cursor: "move",
                axis: "x"
              });
            };

            inspiryAttachmentsUploader();

            /**
             * Floor Plans Related Script
             */
            var floorPlanClone = wp.template('floor-plan-clone');
            var floorPlanImageUploader = function ($button) {
                var $button = $button || 'inspiry-file-select';
                var $this = $("#" + $button);
                var $parent = $this.parents(".inspiry-group-clone");
                var $errorsLog = $parent.find(".errors-log");
                var floorPlanUploader = new plupload.Uploader({
                    browse_button:  $button, // this can be an id of a DOM element or the DOM element itself
                    file_data_name: 'inspiry_upload_file',
                    multi_selection: false,
                    url: ajaxURL + "?action=ajax_img_upload&size=full&nonce=" + uploadNonce,
                    filters: {
                        mime_types: [
                            {title: fileTypeTitle, extensions: "jpg,jpeg,gif,png"}
                        ],
                        max_file_size: '10000kb',
                        prevent_duplicates: true
                    }
                });

                floorPlanUploader.init();

                floorPlanUploader.bind('FilesAdded', function(up, files) {
                    up.refresh();
                    floorPlanUploader.start();
                });

                floorPlanUploader.bind('UploadProgress', function(up, file) {
                    $parent.find(".inspiry-btn-group").addClass('uploading-in-progress');
                });

                floorPlanUploader.bind('Error', function( up, err ) {
                    $errorsLog.html("Error #" + err.code + ": " + err.message);
                });

                floorPlanUploader.bind('FileUploaded', function ( up, file, ajax_response ) {
                    var response = $.parseJSON( ajax_response.response );
                    if ( response.success ) {
                        $errorsLog.html("");
                        $parent.find(".inspiry-file-input").attr('value', response.url );
                        $parent.find(".inspiry-btn-group").addClass('show-remove-btn').removeClass('uploading-in-progress');
                        $parent.find(".inspiry-file-remove").removeClass('hidden');
                    } else {
                        $parent.find(".inspiry-btn-group").removeClass('uploading-in-progress');
                        $errorsLog.html(response.reason);
                    }
                });
            };

            var bindFloorPlanEvents = function () {
                var $inspiryCloneGroups = $(".inspiry-group-clone");

                $.each($inspiryCloneGroups, function( index, value ) {
                    var browseButton = $(value).find('.inspiry-file-select').attr("id");
                    floorPlanImageUploader(browseButton);
                });
            };

            bindFloorPlanEvents();

            $(document).on("click", ".inspiry-file-remove", function ( event ) {
                event.preventDefault();
                var $this = $( this );
                var $parent = $this.parents(".inspiry-group-clone");
                $parent.find(".inspiry-file-input").attr('value', '');
                $parent.find(".inspiry-file-remove").addClass('hidden');
                $parent.find(".inspiry-btn-group").removeClass('show-remove-btn');
                $parent.find(".errors-log").html("");
            });

            $(document).on("click", "#inspiry-add-clone", function (event) {
                event.preventDefault();
                var inspiryCloneGroup = $(".inspiry-group-clone");
                var inspiryLastCloneGroup = inspiryCloneGroup.last().data('floor-plan');

                if (!inspiryLastCloneGroup) {
                    inspiryLastCloneGroup = 0
                }

                $('#inspiry-floor-plans-container').append(floorPlanClone(inspiryLastCloneGroup + 1));
                bindFloorPlanEvents();
            });

            $(document).on("click", ".inspiry-remove-clone", function ( event ) {
                event.preventDefault();
                var $this = $( this );
                $this.closest( '.inspiry-group-clone' ).remove();
            });
        }   // validate localized data

        /* Validate Submit Property Form */
        if( jQuery().validate ){
            $('#submit-property-form').validate({
                rules: {
                    bedrooms: {
                        number: true
                    },
                    bathrooms: {
                        number: true
                    },
                    garages: {
                        number: true
                    },
                    price: {
                        number: true
                    },
                    size: {
                        number: true
                    }
                }
            });
        }

        /* Apply jquery ui sortable on additional details */
        $( "#inspiry-additional-details-container" ).sortable({
            revert: 100,
            placeholder: "detail-placeholder",
            handle: ".sort-detail",
            cursor: "move"
        });

        $( '.add-detail' ).on('click', function( event ){
            event.preventDefault();
            var newInspiryDetail = '<div class="inspiry-detail inputs clearfix">' +
                '<div class="inspiry-detail-control rh_form--align_start"><i class="sort-detail fas fa-bars"></i></div>' +
                '<div class="inspiry-detail-title"><input type="text" name="detail-titles[]" /></div>' +
                '<div class="inspiry-detail-value"><input type="text" name="detail-values[]" /></div>' +
                '<div class="inspiry-detail-control rh_form--align_end"><a class="remove-detail" href="#"><i class="fas fa-trash-alt"></i></a></div>' +
                '</div>';

            $( '#inspiry-additional-details-container').append( newInspiryDetail );
            bindAdditionalDetailsEvents();
        });

        function bindAdditionalDetailsEvents(){

            /* Bind click event to remove detail icon button */
            $( '.remove-detail').on('click', function( event ){
                event.preventDefault();
                var $this = $( this );
                $this.closest( '.inspiry-detail' ).remove();
            });

        }
        bindAdditionalDetailsEvents();

        /* Check if IE9 - As image upload not works in ie9 */
        var ie = (function(){

            var undef,
                v = 3,
                div = document.createElement('div'),
                all = div.getElementsByTagName('i');

            while (
                div.innerHTML = '<!--[if gt IE ' + (++v) + ']><i></i><![endif]-->',
                    all[0]
                );

            return v > 4 ? v : undef;

        }());

        if ( ie <= 9 ) {
            $('#submit-property-form').before( '<div class="ie9-message"><i class="fas fa-info-circle"></i>&nbsp; <strong>Current browser is not fully supported:</strong> Please update your browser or use a different one to enjoy all features on this page. </div>' );
        }

        var terms_input = $( '#terms' );
        var terms_label = terms_input.parent();
        var terms_error = $( '#terms-error' );
        var form_submit = jQuery( 'input.rh_btn[type="submit"]' );

        if ( terms_input.hasClass( 'required' ) ) {
            form_submit.click( function( e ) {
                if ( ! terms_input.is(':checked') && terms_input.hasClass( 'required' ) ) {
                    e.preventDefault();
                    terms_error.removeClass( 'hide' );
                }
            } );

            terms_label.click( function () {
                if ( terms_input.is(':checked') && terms_input.hasClass( 'required' ) ) {
                    terms_error.addClass( 'hide' );
                } else {
                    terms_error.removeClass( 'hide' );
                }
            } );
        }
    });
})(jQuery);