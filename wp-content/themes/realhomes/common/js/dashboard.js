/**
 * Initializes the dashboard functionality.
 *
 * @since 3.12
 */
(function ($) {
    "use strict";

    /**
     * Determines whether the given page is the current dashboard page.
     *
     * @since 3.12
     */
    var isDashboardPage = function (id) {
        if ($('#' + id).length) {
            return true;
        }
        return false;
    };

    /**
     * Stripe payment button request action.
     */
    if (isDashboardPage('dashboard-properties')) {
        var checkoutButton = document.querySelectorAll('.stripe-checkout-btn');
        if (checkoutButton && 'undefined' !== typeof (Stripe)) {
            checkoutButton.forEach(btn => {
                btn.addEventListener('click', event => {
                    const stripe_key = btn.dataset.key;
                    const property_id = btn.dataset.property_id;
                    const isp_nonce = btn.dataset.nonce;
                    var stripe = Stripe(stripe_key);
                    btn.classList.add('active');
                    var stripe_payment_request = $.ajax({
                        url: ajaxURL,
                        type: "POST",
                        data: {
                            action: "inspiry_stripe_payment",
                            property_id,
                            isp_nonce
                        },
                        dataType: "json"
                    });
                    stripe_payment_request.done(function (response) {
                        stripe.redirectToCheckout({sessionId: response.id});
                    });
                })
            });
        } else {
            checkoutButton.forEach(btn => {
                btn.addEventListener('click', event => {
                    alert('Required Stripe library is not loaded!');
                });
            });
        }
    }

    var $document = $(document),
        $window = $(window),
        $body = $(document.body);

    var isIe_9 = function () {
        // Check if IE9 - As image upload not works in ie9
        var ie = (function () {
            var undef,
                v = 3,
                div = document.createElement('div'),
                all = div.getElementsByTagName('i');

            while (
                div.innerHTML = '<!--[if gt IE ' + (++v) + ']><i></i><![endif]-->',
                    all[0]
                ) ;

            return v > 4 ? v : undef;
        }());
        if (ie <= 9) {
            $submitPropertyForm.before('<div class="ie9-message"><i class="fas fa-info-circle"></i>&nbsp; <strong>Current browser is not fully supported:</strong> Please update your browser or use a different one to enjoy all features on this page. </div>');
        }
    };

    var get_icon_for_extension = function ($ext) {
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

    var inspiryGalleryUploader = function () {

        // Apply jquery ui sortable on gallery items
        $("#gallery-thumbs-container").sortable({
            revert: 100,
            placeholder: 'sortable-placeholder',
            cursor: 'move'
        });

        // Require gallery images field to upload at least one image
        $('.dashboard-form-actions input[type=submit]').on('click', function () {
            if (!$('#gallery-thumbs-container').has("div").length) {
                $('#drag-drop-container').css('border-color', 'red');
            }
        });

        $('#select-images').on('click', function (event) {
            event.preventDefault();
            event.stopPropagation();
            $('#drag-drop-container').css('border-color', '#dfdfdf');
        });

        var galleryImagesUploader = new plupload.Uploader({
            browse_button: 'select-images',          // this can be an id of a DOM element or the DOM element itself
            file_data_name: 'inspiry_upload_file',
            drop_element: 'drag-drop-container',
            url: ajaxURL + "?action=ajax_img_upload&nonce=" + uploadNonce,
            filters: {
                mime_types: [
                    {title: fileTypeTitle, extensions: "jpg,jpeg,gif,png"}
                ],
                max_file_size: '20000kb',
                // prevent_duplicates: true
            },
        });

        galleryImagesUploader.init();

        // Run after adding file
        galleryImagesUploader.bind('FilesAdded', function (up, files) {
            var getMaxfiles = $('#drag-drop-container').data('max-images'),
                totalFiles = $('.gallery-thumb').length;

            if (totalFiles >= getMaxfiles) {
                $('.max-files-limit-message').show();
                up.splice();
                return false;
            } else {
                var uploads = files.slice(0, (getMaxfiles - totalFiles));
                var galleryThumbContainer = document.getElementById('gallery-thumbs-container');
                plupload.each(uploads, function (file) {
                    galleryThumbContainer.innerHTML += '<div id="holder-' + file.id + '" class="gallery-thumb"></div>';
                });

                up.refresh();
                galleryImagesUploader.start();
            }

            $('.limit-left .uploaded').text($('.gallery-thumb').length);
        });

        /* Run during upload */
        galleryImagesUploader.bind('UploadProgress', function (up, file) {
            var holder = document.getElementById("holder-" + file.id),
                galleryThumb = $('.gallery-thumb'),
                height = 120;
            if (holder) {
                if (galleryThumb.length) {
                    height = galleryThumb.first().height();
                }
                holder.innerHTML = '<div class="gallery-thumb-inner upload-progress" style="height:' + height + 'px;"><span class="progress-bar"></span><span class="progress" style="width:' + file.percent + '%;"></span><span class="progress-text">' + file.percent + '%</span></div>';
            }
        });

        /* In case of error */
        galleryImagesUploader.bind('Error', function (up, err) {
            document.getElementById('errors-log').innerHTML += "Error #" + err.code + ": " + err.message + "<br/>";
        });

        /* If files are uploaded successfully */
        galleryImagesUploader.bind('FileUploaded', function (up, file, ajax_response) {
            var holder = document.getElementById("holder-" + file.id);
            var response = $.parseJSON(ajax_response.response);

            if (response.success) {
                document.getElementById('errors-log').innerHTML = "";
                if (holder) {
                    holder.innerHTML = '<div class="gallery-thumb-inner"><img src="' + response.url + '" alt="" />' +
                        '<a class="remove-image" data-property-id="' + 0 + '"  data-attachment-id="' + response.attachment_id + '" href="#remove-image" ><i class="far fa-trash-alt"></i></a>' +
                        '<a class="mark-featured" data-property-id="' + 0 + '"  data-attachment-id="' + response.attachment_id + '" href="#mark-featured" ><i class="far fa-star"></i></a>' +
                        '<input type="hidden" class="gallery-image-id" name="gallery_image_ids[]" value="' + response.attachment_id + '"/>' +
                        '<span class="loader"><i class="fas fa-spinner fa-spin"></i></span></div>';
                }
            } else {
                if (holder) {
                    holder.remove();
                }
                document.getElementById('errors-log').innerHTML = response.reason;
            }
        });

        // Mark as featured
        $(document).on('click', 'a.mark-featured', function (event) {
            var $this = $(this);
            var starIcon = $this.find('i');

            if (starIcon.hasClass('far')) { // if not already featured

                $('.gallery-thumb .featured-img-id').remove(); // remove featured image id field from all the gallery thumbs
                $('.gallery-thumb .mark-featured i').removeClass('fas').addClass('far'); // replace any full star with empty star

                var input = $this.siblings('.gallery-image-id'); // get the gallery image id field in current gallery thumb
                var featured_input = input.clone().removeClass('gallery-image-id').addClass('featured-img-id').attr('name', 'featured_image_id');
                // duplicate, remove class, add class and rename to full fill featured image id needs

                $this.closest('.gallery-thumb').append(featured_input); // append the cloned ( featured image id ) input to current gallery thumb
                starIcon.removeClass('far').addClass('fas'); // replace empty star with full star
            }

            event.preventDefault();
        }); // end of mark as featured click event

        // Remove gallery images
        $(document).on('click', 'a.remove-image', function (event) {
            var $this = $(this);
            var gallery_thumb = $this.closest('.gallery-thumb');
            var loader = $this.siblings('.loader');

            loader.show();

            var removal_request = $.ajax({
                url: ajaxURL,
                type: "POST",
                data: {
                    property_id: $this.data('property-id'),
                    attachment_id: $this.data('attachment-id'),
                    action: "remove_gallery_image",
                    nonce: uploadNonce
                },
                dataType: "html"
            });

            removal_request.done(function (response) {
                var result = $.parseJSON(response);
                if (result.attachment_removed) {
                    galleryImagesUploader.removeFile(gallery_thumb);
                    gallery_thumb.remove();

                    var numItems = $('.gallery-thumb').length;
                    $('.limit-left .uploaded').text(numItems);
                    $('.max-files-limit-message').hide();
                } else {
                    document.getElementById('errors-log').innerHTML += "Error : Failed to remove attachment" + "<br/>";
                }
            });

            removal_request.fail(function (jqXHR, textStatus) {
                alert("Request failed: " + textStatus);
            });

            galleryImagesUploader.splice();

            event.preventDefault();
        });  // end of remove gallery thumb click event
    };

    var inspirySliderUploader = function () {

        var $propertySliderImage = $('.property-slider-image');
        var sliderImageDragDrop = $propertySliderImage.find('#slider-image-drag-drop');
        var $errorLog = $propertySliderImage.find('.errors-log');
        var sliderImageUploader = new plupload.Uploader({
            browse_button: 'select-slider-image',
            file_data_name: 'inspiry_upload_file',
            drop_element: 'slider-image-drag-drop',
            url: ajaxURL + '?action=ajax_img_upload&nonce=' + uploadNonce,
            max_file_count: 1,
            multi_selection: false,
            filters: {
                mime_types: [
                    {title: fileTypeTitle, extensions: 'jpg,jpeg,gif,png'},
                ],
                max_file_size: '20000kb',
                prevent_duplicates: true,
            },
        });

        var resetUploader = function () {
            if ($propertySliderImage.find('.slider-thumb').length) {
                sliderImageDragDrop.hide();
            } else {
                sliderImageDragDrop.show();
            }
        };

        resetUploader();

        sliderImageUploader.init();

        sliderImageUploader.bind('FilesAdded', function (up, files) {
            if ($('.slider-thumb').length >= 1) {
                // $errorLog.html( 'Error: ');
                up.splice();
                return false;
            } else {
                plupload.each(files, function (file) {
                    document.getElementById('slider-thumb-container').innerHTML += '<div id="holder-' + file.id + '" class="slider-thumb"></div>';
                });
                up.refresh();
                sliderImageUploader.start();
            }
        });

        sliderImageUploader.bind('UploadProgress', function (up, file) {
            var holder = document.getElementById("holder-" + file.id);
            if (holder) {
                holder.innerHTML = '<div class="slider-thumb-inner upload-progress" style="height: 150px;"><span class="progress-bar"></span><span class="progress" style="width:' + file.percent + '%;"></span><span class="progress-text">' + file.percent + '%</span></div>';
            }
        });

        sliderImageUploader.bind('Error', function (up, err) {
            $errorLog.html("Error #" + err.code + ": " + err.message);
        });

        sliderImageUploader.bind('FileUploaded', function (up, file, ajax_response) {
            var holder = document.getElementById("holder-" + file.id);
            var response = $.parseJSON(ajax_response.response);

            if (response.success) {
                $errorLog.html('');
                if (holder) {
                    holder.innerHTML = '<div class="slider-thumb-inner">' +
                        '<img src="' + response.url + '" alt="" />' +
                        '<a class="remove-slider-image" data-property-id="' + 0 + '"  data-attachment-id="' + response.attachment_id + '" href="#remove-image" ><i class="far fa-trash-alt"></i></a>' +
                        '<span class="loader"><i class="fas fa-spinner fa-spin"></i></span>' +
                        '<input type="hidden" class="slider-image-id" name="slider_image_id" value="' + response.attachment_id + '"/>' +
                        '</div>';

                    resetUploader();
                }
            } else {
                if (holder) {
                    holder.remove();
                }
                $errorLog.html(response.reason);
            }
        });

        $(document).on('click', 'a.remove-slider-image', function (event) {
            event.preventDefault();
            var $this = $(this);
            var sliderThumb = $this.closest('.slider-thumb');
            var loader = $this.siblings('.loader');

            loader.show();

            var removal_request = $.ajax({
                url: ajaxURL,
                type: "POST",
                data: {
                    property_id: $this.data('property-id'),
                    attachment_id: $this.data('attachment-id'),
                    action: "remove_gallery_image",
                    nonce: uploadNonce
                },
                dataType: "html"
            });

            removal_request.done(function (response) {
                var result = $.parseJSON(response);
                if (result.attachment_removed) {
                    sliderImageUploader.removeFile(sliderThumb);
                    sliderThumb.remove();
                    resetUploader();
                } else {
                    $errorLog.html("Error : Failed to remove image");
                }
            });

            removal_request.fail(function (jqXHR, textStatus) {
                $errorLog.html("Request failed: " + textStatus);
            });

            sliderImageUploader.splice();
        });

        $('#select-slider-image').on('click', function (event) {
            event.preventDefault();
            event.stopPropagation();
        });
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
                max_file_size: '20000kb',
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

    var inspiryRepeaterGroup = function (id) {
        const container = $('#inspiry-repeater-container-' + id);

        // Skip if container not exits.
        if (!container.length) {
            return false;
        }

        const template = wp.template(id);
        const addRepeaterField = container.parent('.inspiry-repeater-wrapper').find('.inspiry-repeater-add-field-btn');

        // Made the items sortable.
        container.sortable({
            handle: '.inspiry-repeater-sort-handle',
            cursor: "move",
            revert: 100,
        });

        // Add new filed on click event.
        addRepeaterField.on('click', function (event) {
            let counter = container.find('.inspiry-repeater').last().data('inspiry-repeater-counter');

            if (!counter) {
                counter = 0
            }

            container.append(template(counter + 1));
            event.preventDefault();
        });

        // Remove field.
        $document.on('click', '.inspiry-repeater-remove-field-btn', function (event) {
            $(this).closest('.inspiry-repeater').remove();
            event.preventDefault();
        });
    };

    var inspiryPropertyAdditionalDetails = function () {
        var $additionalDetailsContainer = $('#inspiry-additional-details-container'),
            additionalDetailTemplate = wp.template('additional-details');

        $additionalDetailsContainer.sortable({
            revert: 100,
            placeholder: "detail-placeholder",
            handle: ".inspiry-detail-sort-handle",
            cursor: "move"
        });

        $document.on('click', '.remove-detail', function (event) {
            $(this).closest('.inspiry-detail').remove();
            event.preventDefault();
        });

        $('.add-detail').on('click', function (event) {
            $additionalDetailsContainer.append(additionalDetailTemplate());
            event.preventDefault();
        });
    };

    var inspiryFloorPlans = function () {
        var floorPlanClone = wp.template('floor-plan-clone');
        var floorPlanImageUploader = function ($button) {
            var $button = $button || 'inspiry-file-select';
            var $this = $("#" + $button);
            var $parent = $this.parents(".inspiry-group-clone");
            var $errorsLog = $parent.find(".errors-log");
            var floorPlanUploader = new plupload.Uploader({
                browse_button: $button, // this can be an id of a DOM element or the DOM element itself
                file_data_name: 'inspiry_upload_file',
                multi_selection: false,
                url: ajaxURL + "?action=ajax_img_upload&size=full&nonce=" + uploadNonce,
                filters: {
                    mime_types: [
                        {title: fileTypeTitle, extensions: "jpg,jpeg,gif,png"}
                    ],
                    max_file_size: '15000kb',
                    prevent_duplicates: true
                }
            });

            floorPlanUploader.init();

            floorPlanUploader.bind('FilesAdded', function (up, files) {
                up.refresh();
                floorPlanUploader.start();
            });

            floorPlanUploader.bind('UploadProgress', function (up, file) {
                $parent.find(".inspiry-btn-group").addClass('uploading-in-progress');
            });

            floorPlanUploader.bind('Error', function (up, err) {
                $errorsLog.html("Error #" + err.code + ": " + err.message);
            });

            floorPlanUploader.bind('FileUploaded', function (up, file, ajax_response) {
                var response = $.parseJSON(ajax_response.response);
                if (response.success) {
                    $errorsLog.html("");
                    $parent.find(".inspiry-file-input").attr('value', response.url);
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

            $.each($inspiryCloneGroups, function (index, value) {
                var browseButton = $(value).find('.inspiry-file-select').attr("id");
                floorPlanImageUploader(browseButton);
            });
        };

        bindFloorPlanEvents();

        $(document).on("click", ".inspiry-file-remove", function (event) {
            event.preventDefault();
            var $this = $(this);
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

        $(document).on("click", ".inspiry-remove-clone", function (event) {
            event.preventDefault();
            var $this = $(this);
            $this.closest('.inspiry-group-clone').remove();
        });
    };

    var inspiryProfileUploader = function () {

        /* Validate Edit Profile Form */
        if (jQuery().validate && jQuery().ajaxSubmit) {
            var formLoader = $('#profile-form-loader');
            var formMessage = $('#profile-form-message');

            $('#inspiry-edit-user').validate({
                submitHandler: function (form) {
                    $(form).ajaxSubmit({
                        url: ajaxURL,
                        type: 'post',
                        dataType: 'json',
                        timeout: 30000,
                        beforeSubmit: function (formData, jqForm, options) {
                            formLoader.fadeIn();
                            formMessage.empty().hide();
                            $('#errors-log').empty();
                        },
                        success: function (response, status, xhr, $form) {
                            if (response.success) {
                                formMessage.empty().append('<p>' + response.message + '</p>');
                                formMessage.addClass('success').show();
                            } else {
                                formMessage.empty().append('<p>' + response.errors + '</p>');
                                formMessage.addClass('error').show();
                            }

                            formLoader.fadeOut();
                            scrollTo(formMessage);

                            setTimeout(function () {
                                formMessage.slideUp().removeClass('success error');
                            }, 4000);
                        }
                    });
                }
            });
        }

        var profileUploader = new plupload.Uploader({
            browse_button: 'select-profile-image',  // this can be an id of a DOM element or the DOM element itself
            file_data_name: 'inspiry_upload_file',
            multi_selection: false,
            url: ajaxURL + "?action=profile_image_upload&nonce=" + uploadNonce,
            filters: {
                mime_types: [
                    {title: fileTypeTitle, extensions: "jpg,jpeg,gif,png"}
                ],
                max_file_size: '2000kb',
                prevent_duplicates: true
            }
        });

        profileUploader.init();

        /* Run after adding file */
        profileUploader.bind('FilesAdded', function (up, files) {
            var profileThumb = "";
            plupload.each(files, function (file) {
                profileThumb += '<div id="holder-' + file.id + '">' + '' + '</div>';
            });
            document.getElementById('profile-image').innerHTML = profileThumb;
            up.refresh();
            profileUploader.start();
        });

        /* Run during upload */
        profileUploader.bind('UploadProgress', function (up, file) {
            var holder = document.getElementById("holder-" + file.id);
            if (holder) {
                holder.innerHTML = '<span class="progress-bar"></span><span class="progress" style="width:' + file.percent + '%;"></span><span class="progress-text">' + file.percent + '%</span>';
            }
        });

        /* In case of error */
        profileUploader.bind('Error', function (up, err) {
            document.getElementById('errors-log').innerHTML += "<br/>" + "Error #" + err.code + ": " + err.message;
        });

        /* If files are uploaded successfully */
        profileUploader.bind('FileUploaded', function (up, file, ajax_response) {
            var response = $.parseJSON(ajax_response.response);
            if (response.success) {
                var profileThumbHTML = '<img width="100%" height="100%" src="' + response.url + '" alt="" />' +
                    '<input type="hidden" class="profile-image-id" name="profile-image-id" value="' + response.attachment_id + '"/>';
                document.getElementById("holder-" + file.id).innerHTML = profileThumbHTML;

            }
        });

        $('#remove-profile-image').on('click', function (event) {
            event.preventDefault();
            document.getElementById('profile-image').innerHTML = '';
        });
    };

    /**
     * Formats the price according to current local.
     *
     * @since 3.14.1
     */
    function dashboardFormatPrice(price) {
        var local = $('html').attr('lang');

        if (typeof dashboardData !== "undefined") {
            local = dashboardData.local;
        }

        return (new Intl.NumberFormat(local).format(price));
    }

    var dashboardPricePreview = function (element) {
        var $element = $(element),
            $price = $element.val(),
            $parent = $element.parent('p');

        if ($price) {
            $price.trim();
        }

        $parent
            .css('position', 'relative')
            .append('<strong class="dashboard-price-preview"><span></span></strong>');

        var $preview = $parent.find('.dashboard-price-preview'),
            $wrap = $preview.find('span');

        if ($price) {
            $price = dashboardFormatPrice($price);

            if ('NaN' !== $price && '0' !== $price) {
                $preview.addClass('overlap');
                $wrap.text($price);
            }
        }

        $element.on('input', function () {
            var price = $(this).val();

            if (price) {
                price.trim();
            }

            price = dashboardFormatPrice(price);
            if ('NaN' === price || '0' === price) {
                $wrap.text('');
            } else {
                $wrap.text(price);
            }
        });

        $element.on('focus', function () {
            $preview.removeClass('overlap');
        });

        $element.on('blur', function () {
            $preview.addClass('overlap');
        });

        $preview.on('click', function () {
            $element.focus();
        });
    };

    var memberships = function () {
        // Membership Page Stuff here!
        let cancel_btn = $('.cancel-membership');
        let back_btn = $('#ims-btn-close');
        let cancel_form = $('#ims-cancel-user-membership');

        // Slidedown the form.
        cancel_btn.on('click', function (e) {
            e.preventDefault();
            cancel_form.slideDown('fast');
        });

        // Slideup the form.
        back_btn.on('click', function (e) {
            e.preventDefault();
            cancel_form.slideUp('fast');
        });
    };

    var removeQueryStringParameters = function (url) {
        if (url) {
            if (url.indexOf('?') >= 0) {
                var urlParts = url.split('?');
                return urlParts[0];
            }
            return url;
        }
    };

    var insertParam = function (key, value) {

        var kvp = document.location.search.substr(1).split('&');
        var x;

        kvp = kvp.filter(function (item) {
            return (item != 'property-updated=true') && (item != 'property-added=true');
        });

        var i = kvp.length;

        while (i--) {
            x = kvp[i].split('=');

            if (x[0] == key) {
                x[1] = value;
                kvp[i] = x.join('=');
                break;
            }
        }

        if (i < 0) {
            kvp[kvp.length] = [key, value].join('=');
        }

        // This will reload the page, it's likely better to store this until finished
        document.location.search = kvp.join('&');
    };

    var fx = function (element) {
        element.fadeTo(100, 0, function () {
            element.slideUp(200, function () {
                element.remove();
            });
        });
    };

    var autoRemoveElement = function (element) {
        setTimeout(function () {
            fx(element);
        }, 3500);
    };

    var scrollTo = function (element) {
        $("html, body").animate({scrollTop: element.scrollTop()});
    };

    var updatePagingCounter = function () {
        var end = endNum.html(),
            total = totalNum.html(),
            pagination = $('.rh_pagination'),
            countPosts = $('.dashboard-posts-list-body').find('.property-column-wrap').length;

        if (1 === countPosts) {
            if (pagination.length) {
                location.href = pagination.find('a:first').attr('href');
            } else {
                location.reload();
            }
        } else if ('0' === end) {
            $pagingEntries.find('.paging').hide();
        }

        endNum.html(--end);
        totalNum.html(--total);
    };

    var stickyHeader = function () {
        var headerHeight = $siteHeader.outerHeight();

        $siteHeader.addClass('sticked-header');
        $body.css('padding-top', headerHeight);
        $sidebar.css('padding-top', headerHeight);
    };

    var resetSidebarMenu = function () {
        if ($sidebarDisplayToggle.hasClass('open')) {
            $sidebarDisplayToggle.removeClass('open');
        }

        if ($dashboard.hasClass('show-sidebar')) {
            $dashboard.removeClass('show-sidebar');
        }
    };

    var resetHeaderMobileMenu = function () {
        $('#rh-responsive-menu-toggle').removeClass('open');
        $('.rh-menu-responsive').removeClass('rh-menu-responsive-show');
        $('#rh-main-menus').find('.rh-menu-responsive .sub-menu').hide();
    };

    var headerMobileMenu = function () {
        var responsiveMenu = $('#rh-main-menus').find('.rh-menu-responsive');

        responsiveMenu.find('.sub-menu').parent().prepend('<i class="fas fa-caret-down rh-menu-indicator"></i>');
        responsiveMenu.find('.rh-menu-indicator').removeClass('rh-menu-indicator-up');

        $('.rh-menu-responsive > li .rh-menu-indicator').on('click', function (event) {
            var self = $(this);
            self.toggleClass('rh-menu-indicator-up');
            self.parent().children('.sub-menu').slideToggle();
        });
    };

    var inspiryDashboardSelect = function (id) {
        if (jQuery().selectpicker) {
            jQuery(id).selectpicker({
                iconBase: 'fas',
                dropupAuto: 'true',
                size: 5,
                tickIcon: 'fa-check',
                selectAllText: '<span class="inspiry_select_bs_buttons inspiry_bs_select"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><polygon points="22.1 9 20.4 7.3 14.1 13.9 15.8 15.6 "/><polygon points="27.3 7.3 16 19.3 9.6 12.8 7.9 14.5 16 22.7 29 9 "/><polygon points="1 14.5 9.2 22.7 10.9 21 2.7 12.8 "/></svg></span>',
                deselectAllText: '<span class="inspiry_select_bs_buttons inspiry_bs_deselect"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><style type="text/css">  \n' +
                    '\t.rh-st0{fill:none;stroke:#000000;stroke-width:2;stroke-miterlimit:10;}\n' +
                    '</style><path class="inspiry_des rh-st0" d="M3.4 10.5H20c3.8 0 7 3.1 7 7v0c0 3.8-3.1 7-7 7h-6"/><polyline class="inspiry_des rh-st0" points="8.4 15.5 3.4 10.5 8.4 5.5 "/></svg></span>',

            });
        }
    };

    var locationSuccessList = function (data, thisParent, refreshList = false) {

        if (true === refreshList) {
            thisParent.find('option').not(':selected, .none').remove().end();
        }
        var getSelected = $(thisParent).val();


        jQuery.each(data, function (index, text) {

            if (getSelected) {
                if (getSelected.indexOf(text[0]) < 0) {
                    thisParent.append(
                        $('<option value="' + text[0] + '">' + text[1] + '</option>')
                    );
                }
            } else {
                thisParent.append(
                    $('<option value="' + text[0] + '">' + text[1] + '</option>')
                );
            }
        });
        thisParent.selectpicker('refresh');
        $(parent).find('ul.dropdown-menu li:first-of-type a').focus();

        $(parent).find('input').focus();

    };

    var loaderFadeIn = function () {
        $('.rh-location-ajax-loader').fadeIn('fast');
    };

    var loaderFadeOut = function () {
        $('.rh-location-ajax-loader').fadeOut('fast');
    };

    var rhTriggerAjaxOnLoad = function (thisParent, fieldValue = '') {

        $.ajax({
            url: ajaxURL,
            dataType: 'json',
            delay: 250, // delay in ms while typing when to perform a AJAX search
            data: {
                action: 'inspiry_get_location_options', // AJAX action for admin-ajax.php
                query: fieldValue,

                // hideemptyfields: localizeSelect.hide_empty_locations,
                // sortplpha: localizeSelect.sort_location,
            },
            beforeSend: loaderFadeIn(),
            success: function (data) {
                loaderFadeOut();
                locationSuccessList(data, thisParent, true);
            }
        });

    };

    var rhTriggerAjaxOnScroll = function (thisParent, farmControl, fieldValue = '') {

        var paged = 2;

        farmControl.on('keyup', function (e) {
            paged = 2;

            fieldValue = $(this).val();
        });

        $('div.inspiry_dashboard_ajax_location_field div.inner').on('scroll', function () {
            var thisInner = $(this);

            var thisInnerHeight = thisInner.innerHeight();
            var getScrollIndex = thisInner.scrollTop() + thisInnerHeight;
            if (getScrollIndex >= $(this)[0].scrollHeight) {


                $.ajax({
                    url: ajaxURL,
                    dataType: 'json',
                    delay: 250, // delay in ms while typing when to perform a AJAX search
                    data: {
                        action: 'inspiry_get_location_options', // AJAX action for admin-ajax.php
                        query: fieldValue,
                        page: paged,
                        // hideemptyfields: localizeSelect.hide_empty_locations,
                        // sortplpha: localizeSelect.sort_location,
                    },
                    beforeSend: loaderFadeIn(),
                    success: function (data) {
                        loaderFadeOut();

                        if (!$.trim(data)) {
                            $('.rh-location-ajax-loader').fadeTo("fast", 0);
                        }
                        paged++;
                        locationSuccessList(data, thisParent, false);
                    }
                });
            }
        });
    };

    var inspiryDashboardAjaxSelect = function (parent, id) {
        var farmControl = $(parent).find('.form-control');
        var thisParent = $(id);

        rhTriggerAjaxOnScroll(thisParent, farmControl);

        rhTriggerAjaxOnLoad(thisParent);

        farmControl.on('keyup', function (e) {

            var fieldValue = $(this).val();

            fieldValue = fieldValue.trim();

            var wordcounts = jQuery.trim(fieldValue).length;

            // rhTriggerAjaxLoadMore(thisParent,fieldValue);

            $('.rh-location-ajax-loader').fadeTo("fast", 1);

            if (wordcounts > 0) {

                $.ajax({
                    url: ajaxURL,
                    dataType: 'json',
                    delay: 250, // delay in ms while typing when to perform a AJAX search

                    data: {
                        action: 'inspiry_get_location_options', // AJAX action for admin-ajax.php
                        query: fieldValue,
                        // hideemptyfields: localizeSelect.hide_empty_locations,
                        // sortplpha: localizeSelect.sort_location,
                    },
                    beforeSend: loaderFadeIn(),
                    success: function (data) {
                        loaderFadeOut();

                        thisParent.find('option').not(':selected, .none').remove().end();
                        // var options = [];
                        if (fieldValue && data) {
                            locationSuccessList(data, thisParent);

                        } else {
                            thisParent.find('option').not(':selected, .none').remove().end();
                            thisParent.selectpicker('refresh');

                            $(parent).find('ul.dropdown-menu li:first-of-type a').focus();

                            $(parent).find('input').focus();
                        }
                    },

                });

                // rhTriggerAjaxLoadMore(thisParent,fieldValue);

            } else {
                rhTriggerAjaxOnLoad(thisParent);
            }
        });
    };

    var deleteActionButton = function (event) {
        var link = $(this),
            link_parent = link.parents('.property-column-wrap'),
            confirm_span = link_parent.find('.confirmation');

        link.addClass('hide');
        confirm_span.removeClass('hide');

        event.preventDefault();
    };

    var cancelActionButton = function (event) {
        var link = $(this),
            link_parent = link.parents('.property-column-wrap'),
            link_delete = link_parent.find('.delete'),
            confirm_span = link_parent.find('.confirmation');

        confirm_span.addClass('hide');
        link_delete.removeClass('hide');

        event.preventDefault();
    };

    var removeFromFavorite = function (event) {
        var $this = $(this),
            property_item = $this.parents('.property-column-wrap'),
            loader = $this.find('.loader'),
            confirm = $this.find('.confirm-icon'),
            data = {};

        confirm.addClass('hide');
        loader.removeClass('hide');
        propertyMessage.empty();

        var remove_favorite_request = $.ajax({
            url: $this.attr('href'),
            type: 'POST',
            data: {
                property_id: $this.data('property-id'),
                action: 'remove_from_favorites'
            },
            dataType: 'json'
        });

        remove_favorite_request.done(function (response) {
            if (response.success) {
                fx(property_item);
                updatePagingCounter();
                data.type = 'success';
            } else {
                data.type = 'error';
                loader.addClass('hide');
                confirm.removeClass('hide');
            }

            data.message = response.message;
            propertyMessage.append(dashboardNotice(data));
            scrollTo(propertyMessage);
        });

        event.preventDefault();
    };

    var removeFavoriteFromLocalStorage = function (event) {
        var $this = $(this),
            favorite_properties = window.localStorage.inspiry_favorites,
            property_item = $this.parents('.property-column-wrap'),
            loader = $this.find('.loader'),
            confirm = $this.find('.confirm-icon');

        confirm.addClass('hide');
        loader.removeClass('hide');

        if (favorite_properties) {

            var prop_ids = favorite_properties.split(',');

            prop_ids = $.map(prop_ids, function (value) {
                return parseInt(value);
            });

            const index = prop_ids.indexOf($this.data('property-id'));

            if (index > -1) {
                prop_ids.splice(index, 1);
                fx(property_item);

                confirm.removeClass('hide');
                loader.addClass('hide');

                window.localStorage.setItem('inspiry_favorites', prop_ids);
            }
        }

        event.preventDefault();
    };

    /**
     * Callback function to show page leave warning on beforeunload event.
     */
    var beforeUnloadListener = function (event) {
        event.preventDefault();
        return event.returnValue = dashboardData.returnValue;
    };

    /**
     * Adds beforeunload event when the page has unsaved changes.
     */
    var pageHasUnsavedChanges = function () {
        addEventListener('beforeunload', beforeUnloadListener, {capture: true});
    };

    /**
     * Adds beforeunload event when the page's unsaved changes are resolved.
     */
    var allChangesSaved = function () {
        removeEventListener('beforeunload', beforeUnloadListener, {capture: true});
    };

    /**
     * Gives a form's score based on strings values length.
     */
    var getFormScore = function (formId) {

        const elements = $(formId).find('input[type="text"], textarea:not(#description)');

        let score = '';
        $.each(elements, function (index, field) {
            score += field.value.length;
        });

        // Check if wp editor exists.
        if ($('#wp-description-wrap').length) {
            score += window.tinyMCE.activeEditor.getContent().length;
        }

        return score;
    };

    var ajaxURL = removeQueryStringParameters(dashboardData.ajaxURL);
    var uploadNonce = dashboardData.uploadNonce;
    var fileTypeTitle = dashboardData.fileTypeTitle;
    var $dashboard = $('#dashboard');
    var $dashboardContent = $dashboard.find('#dashboard-content');
    var $sidebar = $dashboard.find('#dashboard-sidebar');
    var $sidebarDisplayToggle = $('#rh-sidebar-menu-toggle');
    var $siteHeader = $('.rh-header-slim');
    var $mobileMenuContainer = $('#rh-main-menus');
    var $pagingEntries = $('#paging-entries');
    var endNum = $pagingEntries.find('.end-num');
    var totalNum = $pagingEntries.find('.total-posts');
    var $propertyColumnWrap = $('.property-column-wrap');
    var $propertyActions = $propertyColumnWrap.find('.property-actions-wrapper');
    var $submitPropertyForm = $('#submit-property-form');
    var propertyMessage = $('#property-message');
    var dashboardNotice = wp.template('dashboard-notice');

    $document.ready(function () {

        $('#property-status-filter').on('change', function () {
            insertParam('property_status_filter', $(this).val());
        });

        $('#posts-per-page').on('change', function () {
            var key = encodeURI('posts_per_page'),
                value = encodeURI($(this).val()),
                kvp = document.location.search.substr(1).split('&'),
                x;

            kvp = kvp.filter(function (item) {
                return (item != 'property-updated=true') && (item != 'property-added=true');
            });

            var i = kvp.length;

            while (i--) {
                x = kvp[i].split('=');
                if (x[0] == key) {
                    x[1] = value;
                    kvp[i] = x.join('=');
                    break;
                }
            }

            if (i < 0) {
                kvp[kvp.length] = [key, value].join('=');
            }

            if (dashboardData.url) {
                window.location.href = dashboardData.url + '?' + kvp.join('&');
            }
        });

        $('#dashboard-search-form-submit-button').on('click', function (event) {
            const $form = $('#dashboard-search-form'),
                $input = $form.find('#dashboard-search-form-input');

            if ($input.val()) {
                window.location.href = $form.attr('action') + '&prop_search=' + encodeURIComponent($input.val());
            }

            event.preventDefault();
        });

        $document.on('click', '.dashboard-notice-dismiss-button', function (event) {
            var $notice = $(this).parent('.dashboard-notice.is-dismissible');

            fx($notice);

            event.preventDefault();
        });

        $propertyActions.find('.delete').on('click', deleteActionButton);

        $propertyActions.find('.cancel').on('click', cancelActionButton);

        $propertyActions.find('.remove-property').on('click', function (event) {
            var $this = $(this),
                property_item = $this.parents('.property-column-wrap'),
                loader = $this.find('.loader'),
                confirm = $this.find('.confirm-icon'),
                data = {};

            confirm.addClass('hide');
            loader.removeClass('hide');
            propertyMessage.empty();

            var remove_property_request = $.ajax({
                url: $this.attr('href'),
                type: 'POST',
                data: {
                    property_id: $this.data('property-id'),
                    action: 'remove_my_property'
                },
                dataType: 'json'
            });

            remove_property_request.done(function (response) {
                if (response.success) {
                    data.type = 'success';
                    fx(property_item);
                    updatePagingCounter();
                } else {
                    data.type = 'error';
                    loader.addClass('hide');
                    confirm.removeClass('hide');
                }

                data.message = response.message;
                propertyMessage.append(dashboardNotice(data));
                scrollTo(propertyMessage);
            });

            remove_property_request.fail(function (jqXHR, textStatus) {
                loader.addClass('hide');
                confirm.removeClass('hide');
                data.message = 'Request Failed: ' + textStatus;
                data.type = 'error';
                propertyMessage.append(dashboardNotice(data));
                scrollTo(propertyMessage);
            });

            event.preventDefault();
        });

        $propertyActions.find('.remove-from-favorite').on('click', removeFromFavorite);

        $('#rh-responsive-menu-toggle').on('click', function (event) {
            $(this).toggleClass('open');
            $mobileMenuContainer.find('.rh-menu-responsive').toggleClass('rh-menu-responsive-show');
        });

        // Reset header mobile menu
        $document.on('mouseup', function (event) {
            if (!$mobileMenuContainer.is(event.target) && $mobileMenuContainer.has(event.target).length === 0) {
                resetHeaderMobileMenu();
            }
        });

        $sidebarDisplayToggle.on('click', function () {
            $(this).toggleClass('open');
            $dashboard.toggleClass('show-sidebar');
        });

        // Reset sidebar menu
        $document.on('mouseup', function (event) {
            if (!$sidebarDisplayToggle.is(event.target) && $sidebarDisplayToggle.has(event.target).length === 0) {
                if (!$sidebar.is(event.target) && $sidebar.has(event.target).length === 0) {
                    resetSidebarMenu();
                }
            }
        });

        stickyHeader();
        headerMobileMenu();

        // Resize window event
        $window.on('resize', function () {
            stickyHeader();
            resetSidebarMenu();
            resetHeaderMobileMenu();
        });

        // Run this on property add/edit page.
        if (isDashboardPage('dashboard-submit-property')) {

            isIe_9();
            inspiryGalleryUploader();
            inspirySliderUploader();
            inspiryAttachmentsUploader();
            inspiryPropertyAdditionalDetails();
            inspiryFloorPlans();
            dashboardPricePreview('#price');
            dashboardPricePreview('#old-price');

            // RVR Meta Fields
            inspiryRepeaterGroup('rvr-outdoor-features');
            inspiryRepeaterGroup('rvr-surroundings');
            inspiryRepeaterGroup('rvr-included');
            inspiryRepeaterGroup('rvr-not-included');
            inspiryRepeaterGroup('rvr-policies');

            // Multiple videos fields.
            inspiryRepeaterGroup('video-group');

            // Property submit Location fields related code.
            inspiryDashboardSelect('.inspiry_select_picker_trigger');
            inspiryDashboardAjaxSelect('.inspiry_dashboard_ajax_location_wrapper', 'select.inspiry_dashboard_ajax_location_field');

            $(".inspiry_bs_submit_location").on('changed.bs.select', function () {
                $('.inspiry_bs_submit_location').selectpicker('refresh');
            });

            var dashboardColorPicker = $('.dashboard-color-picker');
            if (dashboardColorPicker.length) {
                dashboardColorPicker.find('#inspiry_property_label_color').wpColorPicker();
                dashboardColorPicker.find('.wp-color-result-text').text(dashboardData.pick);
                dashboardColorPicker.find('.wp-picker-clear').val(dashboardData.clear);
            }

            // Search form Tabs layout code starts here!
            if ($submitPropertyForm.hasClass('submit-property-form-wizard')) {
                var $dashboardTabs = $('#dashboard-tabs');
                var $dashboardTabsNav = $dashboardTabs.find('#dashboard-tabs-nav');
                var $dashboardTabsContent = $dashboardTabs.find('.dashboard-tab-content');
                var $previous = $submitPropertyForm.find('#previous');
                var $next = $submitPropertyForm.find('#next');
                var $saveProperty = $submitPropertyForm.find('#submit-property-button');

                var disableButton = function ($button) {
                    $button.addClass('disabled').prop("disabled", true)
                };

                var enableButton = function ($button) {
                    $button.removeClass('disabled').prop("disabled", false);
                };

                var enableNavigation = function (item) {
                    if (item.hasClass('first')) {
                        $saveProperty.hide();
                        disableButton($previous);
                        enableButton($next);
                    } else if (item.hasClass('last')) {
                        $saveProperty.show();
                        enableButton($previous);
                        disableButton($next);
                    } else {
                        $saveProperty.hide();
                        enableButton($previous);
                        enableButton($next);
                    }
                };

                var disableNavigation = function () {
                    $next.prop("disabled", true);
                    $previous.prop("disabled", true);
                    $dashboardTabsNav.find('li').addClass('disabled');
                };

                var validateForm = function () {
                    if (jQuery().validate) {
                        return $submitPropertyForm.valid();
                    } else {
                        return true
                    }
                };

                var currentTab = function (index) {
                    $dashboardTabsNav.find('li').removeClass('current');
                    $dashboardTabsNav.find('li').eq(index).addClass('current');
                };

                var currentTabId = function () {
                    return $dashboardTabsNav.find('li.current').data('id');
                };

                var currentTabContent = function (index) {
                    $dashboardTabsContent.hide();
                    $dashboardTabsContent.eq(index).show();
                };

                // Generates the tabs nav
                if (!$dashboardTabsNav.find('li').length) {
                    var itemIndex = 0;
                    var totalItems = $dashboardTabsContent.length;

                    if (totalItems) {
                        $dashboardTabsContent.each(function (i, el) {
                            var elem = $(el);
                            var item = '<li';

                            if (0 === itemIndex) {
                                item += ' class="first current"';
                            }

                            if ((totalItems - 1) === itemIndex) {
                                item += ' class="last"';
                            }

                            elem.attr('data-content-id', i);

                            item += ' data-id="' + i + '">' + elem.data('content-title') + '</li>';

                            $dashboardTabsNav.append(item);

                            itemIndex++;
                        });
                    }

                    // Show submit button if there is only one tab
                    if (1 === $dashboardTabsNav.find('li').length) {
                        $saveProperty.show();
                        $previous.hide();
                        $next.hide();
                    }
                }

                // Tabs nav click event
                $dashboardTabsNav.on('click', 'li', function () {
                    var item = $(this);
                    var index = item.data('id');

                    if (validateForm()) {
                        currentTab(index);
                        currentTabContent(index);
                        enableNavigation(item);
                    } else {
                        disableNavigation();

                        var currenItem = $dashboardTabsNav.find('li.current');

                        scrollTo(currenItem);
                        currenItem.addClass('error').removeClass('disabled');

                        $('input, textarea, select').on('focusout keyup change', function () {
                            if (validateForm()) {
                                $dashboardTabsNav.find('li').removeClass('error disabled');
                                enableNavigation($dashboardTabsNav.find('li.current'));
                            } else {
                                disableNavigation();
                            }
                        });
                    }
                });

                // Next button click event
                $submitPropertyForm.find('#next').on('click', function (event) {
                    $dashboardTabsNav.find('li').eq(currentTabId() + 1).trigger('click');
                    scrollTo($dashboardTabs);
                    event.preventDefault();
                });

                // Previous button click event
                $submitPropertyForm.find('#previous').on('click', function (event) {
                    $dashboardTabsNav.find('li').eq(currentTabId() - 1).trigger('click');
                    scrollTo($dashboardTabs);
                    event.preventDefault();
                });
            }

            // Cancel button click event to return to my properties page.
            $submitPropertyForm.find('#cancel').on('click', function (event) {
                window.location.href = dashboardData.url + '?module=properties';
                event.preventDefault();
            });

            /**
             * Property submit form ajax validation
             * @since 3.13.0
             */
            if (jQuery().validate && jQuery().ajaxSubmit) {
                let data = {},
                    formNoticeWrapper = $submitPropertyForm.hasClass('submit-property-form-wizard') ? $('#dashboard-submit-property') : $dashboardContent,
                    options = {
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
                        },
                    };

                options.submitHandler = function (form) {
                    $(form).ajaxSubmit({
                        url: ajaxURL,
                        beforeSubmit: function () {
                            $('.dashboard-notice').remove();
                            $dashboardContent.addClass('loading');
                        },
                        success: function (response, statusText, xhr, $form) {
                            if (response.success) {

                                // Remove the page leave warning.
                                allChangesSaved();

                                // Check for reCaptcha and reset reCAPTCHA
                                if ($('.inspiry-recaptcha-wrapper').length && (typeof inspiryResetReCAPTCHA == 'function')) {
                                    inspiryResetReCAPTCHA();
                                }

                                // Redirect to given page
                                if (response.data.redirect_url) {
                                    setTimeout(function () {
                                        window.location.replace(response.data.redirect_url);
                                    }, 1000);
                                }

                                // Move to success page when guest submission is enabled.
                                if (response.data.guest_submission) {
                                    insertParam('property-added', 'true');
                                }
                            } else {
                                $dashboardContent.removeClass('loading');

                                let message;
                                if (response.data) {
                                    message = response.data.message;
                                } else {
                                    response = $.parseJSON(response);
                                    message = response.message;
                                }
                                data.type = 'error';
                                data.message = message;
                                formNoticeWrapper.prepend(dashboardNotice(data));
                                scrollTo(formNoticeWrapper);
                            }
                        }
                    });
                };

                $submitPropertyForm.validate(options);
            }

            // Script to add/remove page leave alert.
            $window.on('load', function () {
                const submitPropertyFormCurrentData = getFormScore($submitPropertyForm);

                if ($('#wp-description-wrap').length) {
                    window.tinyMCE.activeEditor.on('change', function () {
                        if (submitPropertyFormCurrentData !== getFormScore($submitPropertyForm)) {
                            pageHasUnsavedChanges();
                        } else {
                            allChangesSaved();
                        }
                    });
                }

                $submitPropertyForm.on('change', 'input[type="text"], textarea', function () {
                    if (submitPropertyFormCurrentData !== getFormScore($submitPropertyForm)) {
                        pageHasUnsavedChanges();
                    } else {
                        allChangesSaved();
                    }
                });
            });

        } else if (isDashboardPage('dashboard-user-profile')) {

            inspiryDashboardSelect('.inspiry_select_picker_trigger');
            inspiryProfileUploader();

        } else if (isDashboardPage('dashboard-membership')) {

            memberships();

        } else if (isDashboardPage('dashboard-favorites')) {

            // Get favorite properties from localStorage.
            var favorite_properties = window.localStorage.inspiry_favorites;
            if (!$body.hasClass('logged-in') && favorite_properties) {
                $.ajax({
                    type: 'post',
                    dataType: 'html',
                    url: ajaxurl,
                    data: {
                        action: 'display_favorite_properties',
                        prop_ids: favorite_properties.split(','),
                        design_variation: 'dashboard'
                    },
                    success: function (response) {
                        $('#dashboard-favorites').html(response);
                        $document = $(document);
                        $document.on('click', '.remove-from-favorite', removeFavoriteFromLocalStorage);
                        $document.on('click', '.delete', deleteActionButton);
                        $document.on('click', '.cancel', cancelActionButton);
                    }
                });
            }

            // Migrate favorite properties from local to server side after user login.
            var favorite_properties = window.localStorage.inspiry_favorites; // Get local favorite properties data.
            if (favorite_properties && $('body').hasClass('logged-in')) {
                var migrate_prop_options = {
                    type: 'post',
                    url: ajaxurl,
                    data: {
                        action: 'inspiry_favorite_prop_migration',
                        prop_ids: favorite_properties.split(','),
                    },
                    success: function (response) {
                        if ('true' === response) {
                            window.localStorage.removeItem('inspiry_favorites');
                        }
                    }
                };
                $.ajax(migrate_prop_options);
            }
        } else if (isDashboardPage('saved-searches')) {

            // Delete saved search item.
            $('.search-actions .delete-search').on('click', function (e) {

                e.preventDefault();

                let button = $(this);
                let search_item = button.closest('.search-item-wrap');
                let search_item_id = search_item.data('search-item');
                let icon = button.find('i');
                icon.addClass('fa-spin');

                $.post(ajaxurl,
                    {
                        action: 'inspiry_delete_saved_search_item',
                        search_item_id: search_item_id,
                    },
                    function (response) {
                        response = JSON.parse(response);
                        if (response.success) {
                            search_item.remove();
                        }
                    }
                );
            });
        }
    });

    // Migrate saved searches from local to server.
    var all_saved_searches = JSON.parse(window.localStorage.getItem('realhomes_saved_searches'));
    if (all_saved_searches && $('body').hasClass('logged-in')) {
        var migrate_saved_searches = {
            type: 'post',
            url: ajaxurl,
            data: {
                action: 'realhomes_saved_searches_migration',
                saved_searches: all_saved_searches,
            },
            success: function (response) {
                if ('true' === response) {
                    // Clear all saved searches from local storage.
                    window.localStorage.removeItem('realhomes_saved_searches');
                }
            }
        };
        $.ajax(migrate_saved_searches);
    }

})(jQuery);
