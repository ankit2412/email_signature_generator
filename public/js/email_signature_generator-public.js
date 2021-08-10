var $ = jQuery.noConflict();
var SignatureData = {};
SignatureData['general'] = {};
SignatureData['image'] = {};
SignatureData['social'] = {};
SignatureData['design'] = {};

function CopyElementToClipboard(el) {
    var body = document.body,
            range, sel;
    if (document.createRange && window.getSelection) {
        range = document.createRange();
        sel = window.getSelection();
        sel.removeAllRanges();
        range.selectNodeContents(el);
        sel.addRange(range);
    }
    document.execCommand("Copy");
}

function create_signature_table(SignatureData = '') {
    $.ajax({
        type: "post",
        dataType: "html",
        url: ajax_url.url,
        data: {action: "create_email_signature", data: SignatureData},
        success: function (response) {
            $('.email-wrapper .email-signature-preview').html(response);
        }
    });
}

function validate_fields(field) {
    if (field.attr('name') == 'InputPhone' || field.attr('name') == 'InputMobile') {
        var phone = field.val();
        var phonefilter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
        if (field.val() == '') {
            return true;
        } else if (phonefilter.test(phone)) {
            return true;
        } else {
            return false;
        }
    }
    if (field.attr('name') == 'InputWebsite') {
        var website = field.val();
        var websitefilter = /^[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/i;
        if (websitefilter.test(website)) {
            return true;
        } else {
            return false;
        }
    }
    if (field.attr('name') == 'InputEmail') {
        var email = field.val();
        var emailfilter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (emailfilter.test(email)) {
            return true;
        } else {
            return false;
        }
    }

    return true;
}

$(document).ready(function () {
    create_signature_table();
    var current_size = $('#DesignFontSize').val();
    var current_color = $("#DesignFontColor").val();
    if ($("#DesignFontFamily").length > 0) {
        var email_font_famliy = $("#DesignFontFamily").val().replace(/'/g, "\\'");
    }
    SignatureData['design']['FontSize'] = current_size;
    SignatureData['design']['FontColor'] = current_color;
    SignatureData['design']['FontFamily'] = email_font_famliy;

    $("#general span.field-error").remove();
    $("#generate_email_signature").attr('disabled', 'disabled');
    $("#SignatureContent #general input").on('change keyup paste', function () {

        $(this).each(function (index) {
            var input = $(this);
            var validate_field = validate_fields(input);
            if (validate_field) {
                if (input.val() != null) {
                    $("#generate_email_signature").removeAttr('disabled');
                    input.css('border', '1px solid #ccc');
                    input.parent('.form-group').find('span.field-error').remove();
                    SignatureData['general'][input.attr('name')] = input.val();
                }
            } else {
                input.focus();
                input.css('border', '1px solid red');
                var field_name = '';
                if (input.attr('name') == "InputPhone") {
                    field_name = 'Phone number';
                }
                if (input.attr('name') == "InputMobile") {
                    field_name = 'Mobile number';
                }
                if (input.attr('name') == "InputWebsite") {
                    field_name = 'Website Url';
                }
                if (input.attr('name') == "InputEmail") {
                    field_name = 'Email';
                }
                if (input.parent('.form-group').find('span.field-error').length == 0) {
                    input.parent('.form-group').append('<span class="field-error">Please enter valid ' + field_name + '!</span>');
                }
                return false;
            }
        });

        $('.active-social-icons li').each(function (index, value) {
            //if ($(this).find('input[type="text"]').val() != "") {
            var new_order = (index + 1);
            $(this).attr('data-order', new_order);

            var key = $(this).attr('id');
            var caption = $('#social #socialCaption').val();
            SignatureData['social'][new_order] = {
                social_type: key,
                link: $(this).find('input[type="text"]').val()
            };

            if (caption !== null && caption.length > 0) {
                $.each(SignatureData['social'], function (index, value) {
                    SignatureData['social'][index]['caption'] = caption;
                });
            }
            //}
        });

        create_signature_table(SignatureData);
    });



    $("#generate_email_signature").on('click', function () {
        var generated_email_signature = $('.email-wrapper .email-signature-preview').html();

        var sindata = {};
        sindata['preview'] = true;
        sindata['signature_source_code'] = $.trim(generated_email_signature);
        sessionStorage.setItem('sindata', JSON.stringify(sindata));
        window.location.href = site_url.url + "/email-signature-preview";
    });

    $('#signature_source_code').on('click', function () {
        $(this).focus();
        $(this).select();
        document.execCommand('copy');
    });

    $('.avtar-option .slider').on('change', function () {
        $(this).next('.slider-current-value').html($(this).val());
        var key = $(this).attr('id');
        SignatureData['image'][key] = $(this).val();
        create_signature_table(SignatureData);
    });

    $(".active-social-icons").sortable({
        update: function (event, ui) {
            delete SignatureData['social'];
            SignatureData['social'] = {}
            $('.active-social-icons li').each(function (e) {
                var li_element = $(this);
                //if (li_element.find('input[type="text"]').val() != "") {
                var new_order = (li_element.index() + 1);
                li_element.attr('data-order', new_order);

                var key = li_element.attr('id');
                var caption = $('#social #socialCaption').val();
                SignatureData['social'][new_order] = {
                    social_type: key,
                    link: li_element.find('input[type="text"]').val()
                };

                if (caption !== null && caption.length > 0) {
                    $.each(SignatureData['social'], function (index, value) {
                        SignatureData['social'][index]['caption'] = caption;
                    });
                }
                setTimeout(function () {
                    create_signature_table(SignatureData);
                }, 900);
                //}
            });
        }
    });
    //$(".active-social-icons").disableSelection();

    $('.active-social-icons .close-icon').on('click', function () {
        $(this).parent('li').remove();

        delete SignatureData['social'];
        SignatureData['social'] = {}
        $('.active-social-icons li').each(function (index, value) {
            //if ($(this).find('input[type="text"]').val() != "") {
            var new_order = (index + 1);
            $(this).attr('data-order', new_order);

            var key = $(this).attr('id');
            var caption = $('#social #socialCaption').val();
            SignatureData['social'][new_order] = {
                social_type: key,
                link: $(this).find('input[type="text"]').val()
            };

            if (caption !== null && caption.length > 0) {
                $.each(SignatureData['social'], function (index, value) {
                    SignatureData['social'][index]['caption'] = caption;
                });
            }
            setTimeout(function () {
                create_signature_table(SignatureData);
            }, 900);
            //}
        });
    });

    $('.active-social-icons > li > input').on('change keyup paste', function () {
        if ($(this).val() != "") {
            var key = $(this).parent('li').attr('id');
            var order = $(this).parent('li').data('order');
            var caption = $('#social #socialCaption').val();
            SignatureData['social'][order] = {
                social_type: key,
                link: $(this).val()
            };

            if (caption !== null && caption.length > 0) {
                $.each(SignatureData['social'], function (index, value) {
                    SignatureData['social'][index]['caption'] = caption;
                });
            }
            create_signature_table(SignatureData);
        }
    });

    $('.design-option .slider').on('change', function () {
        $(this).next('.slider-current-value').html($(this).val());

        SignatureData['design']['FontSize'] = $(this).val();
        create_signature_table(SignatureData);
    });

    $("#DesignFontColor").spectrum({
        showInput: true,
        className: "full-spectrum",
        showInitial: true,
        showPalette: true,
        showSelectionPalette: true,
        maxSelectionSize: 10,
        preferredFormat: "hex",
        localStorageKey: "spectrum.demo",
        move: function (color) {
            var new_color = color.toHexString();
            SignatureData['design']['FontColor'] = new_color;
            create_signature_table(SignatureData);
        },
        change: function (color) {
            var new_color = color.toHexString();
            SignatureData['design']['FontColor'] = new_color;
            create_signature_table(SignatureData);
        },
        palette: [
            ["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)",
                "rgb(204, 204, 204)", "rgb(217, 217, 217)", "rgb(255, 255, 255)"],
            ["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",
                "rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)"],
            ["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)",
                "rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)",
                "rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)",
                "rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)",
                "rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)",
                "rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)",
                "rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",
                "rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",
                "rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)",
                "rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
        ]
    });

    $('#DesignFontFamily').on('change', function () {
        var email_font_famliy = $(this).val().replace(/'/g, "\\'");
        SignatureData['design']['FontFamily'] = email_font_famliy;
        create_signature_table(SignatureData);
    });
});

window.addEventListener('DOMContentLoaded', function () {
    var avatar = document.getElementById('avatar');
    var image = document.getElementById('dummy_image');
    var input = document.getElementById('Input_image');
    if (avatar !== null && image !== null && input !== null) {
        var $modal = $('#modal');
        var cropper;
        var file_type = '';
        input.addEventListener('change', function (e) {
            var files = e.target.files;
            var done = function (url) {
                input.value = '';
                image.src = url;
                $modal.modal('show');
            };
            var reader;
            var file;
            var url;

            if (files && files.length > 0) {
                file = files[0];
                file_type = file.type.split('image/').pop().toLowerCase();
                if (URL) {
                    done(URL.createObjectURL(file));
                } else if (FileReader) {
                    reader = new FileReader();
                    reader.onload = function (e) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });

        $modal.on('shown.bs.modal', function () {
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 3,
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });

        document.getElementById('crop').addEventListener('click', function () {
            var canvas;

            $modal.modal('hide');
            $('#images .upload-label').hide();

            if (cropper) {
                canvas = cropper.getCroppedCanvas({
                    width: 200,
                    height: 200,
                });

                canvas.toBlob(function (blob) {
                    var formData = new FormData();
                    formData.append('avatar', blob, 'avatar.' + file_type);
                    formData.append('action', 'upload_avtar');

                    $.ajax({
                        url: ajax_url.url,
                        method: 'POST',
                        dataType: "json",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            avatar.src = response.full_image_path;
                            $('#images .uploaded-avtar-wrapper, #images .avtar-options').show();
                            $("#generate_email_signature").removeAttr('disabled');
                            SignatureData['image']['full_path'] = response.full_image_path;
                            SignatureData['image']['AvtarImageWidth'] = $('#AvtarImageWidth').val();
                            SignatureData['image']['AvtarImageShape'] = $('#AvtarImageShape').val();
                            create_signature_table(SignatureData);
                        }
                    });
                });
            }
        });
    }
});