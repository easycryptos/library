function swalOptions(message) {
    return {
        text: message,
        icon: 'warning',
        buttons: true,
        buttons: [InfConfig.textCancel, InfConfig.textOk],
        dangerMode: true,
    };
}

function setAjaxData(object = null) {
    var data = {
        'sysLangId': InfConfig.sysLangId
    };
    data[InfConfig.csrfTokenName] = $('meta[name="X-CSRF-TOKEN"]').attr('content');
    if (object != null) {
        Object.assign(data, object);
    }
    return data;
}

function setSerializedData(serializedData) {
    serializedData.push({name: 'sysLangId', value: InfConfig.sysLangId});
    serializedData.push({name: InfConfig.csrfTokenName, value: $('meta[name="X-CSRF-TOKEN"]').attr('content')});
    return serializedData;
}

$(document).ready(function () {
    //home main slider
    $('#home-slider').slick({
        autoplay: true,
        autoplaySpeed: 4900,
        slidesToShow: 4,
        slidesToScroll: 1,
        infinite: true,
        speed: 200,
        rtl: rtl,
        swipeToSlide: true,
        lazyLoad: 'progressive',
        prevArrow: $('#home-slider-nav .prev'),
        nextArrow: $('#home-slider-nav .next'),
        responsive: [
            {
                breakpoint: 2000,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });
    //home boxed slider
    $('#home-slider-boxed').slick({
        autoplay: true,
        autoplaySpeed: 4900,
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        speed: 200,
        rtl: rtl,
        swipeToSlide: true,
        lazyLoad: 'progressive',
        prevArrow: $('#home-slider-boxed-nav .prev'),
        nextArrow: $('#home-slider-boxed-nav .next'),
    });
    //random post slider
    $('#random-slider').slick({
        autoplay: true,
        autoplaySpeed: 4900,
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        speed: 200,
        rtl: rtl,
        lazyLoad: 'progressive',
        prevArrow: $('#random-slider-nav .prev'),
        nextArrow: $('#random-slider-nav .next'),
    });
    //post details additional images slider
    $('#post-details-slider').slick({
        autoplay: false,
        autoplaySpeed: 4900,
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: false,
        speed: 200,
        rtl: rtl,
        adaptiveHeight: true,
        lazyLoad: 'progressive',
        prevArrow: $('#post-details-slider-nav .prev'),
        nextArrow: $('#post-details-slider-nav .next'),
    });
});
$(window).load(function () {
    $("#post-details-slider").css('opacity', '1');
});
//redirect onclik
$(document).on('click', '.redirect-onclik', function () {
    var url = $(this).attr('data-url');
    window.location.href = url;
});

//mobile memu
$(document).on('click', '.btn-open-mobile-nav', function () {
    document.getElementById("navMobile").style.width = "280px";
    $('#overlay_bg').show();
});
$(document).on('click', '.btn-close-mobile-nav', function () {
    document.getElementById("navMobile").style.width = "0";
    $('#overlay_bg').hide();
});
$(document).on('click', '#overlay_bg', function () {
    document.getElementById("navMobile").style.width = "0";
    $('#overlay_bg').hide();
});

//scroll to top
$(window).scroll(function () {
    if ($(this).scrollTop() > 100) {
        $('.scrollup').fadeIn();
    } else {
        $('.scrollup').fadeOut();
    }
});
$('.scrollup').click(function () {
    $("html, body").animate({scrollTop: 0}, 700);
    return false;
});

// Search Modal
$("[data-toggle='modal-search']").click(function () {
    //if click open
    $('body').toggleClass('search-open');
    return false;
});

$(".modal-search .s-close").click(function () {
    //close modal
    $('body').removeClass('search-open');
    return false;
});
//mobile menu search
$(document).on('click', '#search_button', function () {
    $('body').toggleClass('search-open');
});
$(document).on('click', '#mobile_search_button', function () {
    $('body').toggleClass('search-open');
});
$(document).on('click', '.modal-search .s-close', function () {
    $('body').removeClass('search-open');
});

//show slider navigation on hover
$(document).ready(function () {
    $('#home-slider').hover(
        function () {
            $("#home-slider .owl-nav").css({"display": "block"});
        },
        function () {
            $("#home-slider .owl-nav").css({"display": "none"});
        }
    );
    $('#first-tmp-home-slider').hover(
        function () {
            $("#first-tmp-home-slider .owl-nav").css({"display": "block"});
        },

        function () {
            $("#first-tmp-home-slider .owl-nav").css({"display": "none"});
        }
    );
});

//add att to iframe
$(document).ready(function () {
    $('iframe').attr("allowfullscreen", "");
});

//add reaction
function addReaction(postId, reaction) {
    var data = {
        postId: postId,
        reaction: reaction
    };
    $.ajax({
        type: 'POST',
        url: InfConfig.baseUrl + '/save-reaction-post',
        data: setAjaxData(data),
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                document.getElementById("reactions_result").innerHTML = obj.content;
            }
        }
    });
}

//view poll results
function viewPollResults(a) {
    $("#poll_" + a + " .question").hide();
    $("#poll_" + a + " .result").show()
}

//view poll options
function viewPollOptions(a) {
    $("#poll_" + a + " .result").hide();
    $("#poll_" + a + " .question").show()
}

//poll
$(document).ready(function () {
    $(".poll-form").submit(function (event) {
        event.preventDefault();
        var formId = $(this).attr("data-form-id");
        var data = {
            'poll_id': $("#formPoll_" + formId + " [name = 'poll_id']").val(),
            'option': $("#formPoll_" + formId + " [name = 'option']:checked").val()
        }
        $(':input[type="submit"]').prop('disabled', true);
        $.ajax({
            type: "POST",
            url: InfConfig.baseUrl + "/add-poll-vote-post",
            data: setAjaxData(data),
            success: function (response) {
                var obj = JSON.parse(response);
                if (obj.result == 1) {
                    if (obj.response == "required") {
                        $("#poll-required-message-" + formId).show();
                        $("#poll-error-message-" + formId).hide();
                    } else if (obj.response == "voted") {
                        $("#poll-error-message-" + formId).show();
                        $("#poll-required-message-" + formId).hide();
                    } else {
                        document.getElementById("poll-results-" + formId).innerHTML = obj.response;
                        $("#poll_" + formId + " .result").show();
                        $("#poll_" + formId + " .question").hide()
                    }
                    $(':input[type="submit"]').prop('disabled', false);
                }
            }
        });
    });

    //add registered comment
    $("#form_add_comment_registered").submit(function (event) {
        event.preventDefault();
        var formValues = $(this).serializeArray();
        var data = {
            'limit': $('#post_comment_limit').val()
        };
        var submit = true;
        $(formValues).each(function (i, field) {
            if ($.trim(field.value).length < 1) {
                $("#form_add_comment_registered [name='" + field.name + "']").addClass("is-invalid");
                submit = false;
            } else {
                $("#form_add_comment_registered [name='" + field.name + "']").removeClass("is-invalid");
                data[field.name] = field.value;
            }
        });
        if (submit == true) {
            $('#comments form .btn').prop('disabled', true);
            $.ajax({
                type: "POST",
                url: InfConfig.baseUrl + "/add-comment-post",
                data: setAjaxData(data),
                success: function (response) {
                    $('#comments form .btn').prop('disabled', false);
                    var obj = JSON.parse(response);
                    if (obj.type == 'message') {
                        document.getElementById("message-comment-result").innerHTML = obj.message;
                    } else {
                        document.getElementById("comment-result").innerHTML = obj.message;
                    }
                    $("#form_add_comment_registered")[0].reset();
                }
            });
        }
    });

    //add comment
    $("#form_add_comment").submit(function (event) {
        event.preventDefault();
        var formValues = $(this).serializeArray();
        var data = {
            'limit': $('#post_comment_limit').val()
        };
        var submit = true;
        $(formValues).each(function (i, field) {
            if ($.trim(field.value).length < 1) {
                $("#form_add_comment [name='" + field.name + "']").addClass("is-invalid");
                submit = false;
            } else {
                $("#form_add_comment [name='" + field.name + "']").removeClass("is-invalid");
                data[field.name] = field.value;
            }
        });
        if (InfConfig.isRecaptchaEnabled == true) {
            if (typeof data['g-recaptcha-response'] === 'undefined') {
                $('.g-recaptcha').addClass("is-recaptcha-invalid");
                submit = false;
            } else {
                $('.g-recaptcha').removeClass("is-recaptcha-invalid");
            }
        }
        if (submit == true) {
            $('.g-recaptcha').removeClass("is-recaptcha-invalid");
            $('#comments form .btn').prop('disabled', true);
            $.ajax({
                type: "POST",
                url: InfConfig.baseUrl + "/add-comment-post",
                data: setAjaxData(data),
                success: function (response) {
                    $('#comments form .btn').prop('disabled', false);
                    var obj = JSON.parse(response);
                    if (obj.type == 'message') {
                        document.getElementById("message-comment-result").innerHTML = obj.message;
                    } else {
                        document.getElementById("comment-result").innerHTML = obj.message;
                    }
                    if (InfConfig.isRecaptchaEnabled == true) {
                        grecaptcha.reset();
                    }
                    $("#form_add_comment")[0].reset();
                }
            });
        }
    });
});

//add registered subcomment
$(document).on('click', '.btn-subcomment-registered', function () {
    var commentId = $(this).attr("data-comment-id");
    var data = {};
    $("#form_add_subcomment_registered_" + commentId).ajaxSubmit({
        beforeSubmit: function () {
            $('#comments form .btn').prop('disabled', true);
            var form = $("#form_add_subcomment_registered_" + commentId).serializeArray();
            var comment = $.trim(form[0].value);
            if (comment.length < 1) {
                $(".form-comment-text").addClass("is-invalid");
                return false;
            } else {
                $(".form-comment-text").removeClass("is-invalid");
            }
        },
        type: "POST",
        url: InfConfig.baseUrl + "/add-comment-post",
        data: setAjaxData(data),
        success: function (response) {
            $('#comments form .btn').prop('disabled', false);
            var obj = JSON.parse(response);
            if (obj.type == 'message') {
                document.getElementById("message-subcomment-result-" + commentId).innerHTML = obj.message;
            } else {
                document.getElementById("comment-result").innerHTML = obj.message;
            }
            $('.visible-sub-comment form').empty();
        }
    })
});

//make subcomment
$(document).on('click', '.btn-subcomment', function () {
    var commentId = $(this).attr("data-comment-id");
    var data = {
        'limit': $('#post_comment_limit').val()
    };
    var formId = "#form_add_subcomment_" + commentId;
    $(formId).ajaxSubmit({
        beforeSubmit: function () {
            $('#comments form .btn').prop('disabled', true);
            var formValues = $("#form_add_subcomment_" + commentId).serializeArray();
            var submit = true;
            $(formValues).each(function (i, field) {
                if ($.trim(field.value).length < 1) {
                    $(formId + " [name='" + field.name + "']").addClass("is-invalid");
                    submit = false;
                } else {
                    $(formId + " [name='" + field.name + "']").removeClass("is-invalid");
                    data[field.name] = field.value;
                }
            });
            if (InfConfig.isRecaptchaEnabled == true) {
                if (typeof data['g-recaptcha-response'] === 'undefined') {
                    $(formId + ' .g-recaptcha').addClass("is-recaptcha-invalid");
                    submit = false;
                } else {
                    $(formId + ' .g-recaptcha').removeClass("is-recaptcha-invalid");
                }
            }
            if (submit == false) {
                return false;
            }
        },
        type: "POST",
        url: InfConfig.baseUrl + "/add-comment-post",
        data: setAjaxData(data),
        success: function (response) {
            $('#comments form .btn').prop('disabled', false);
            if (InfConfig.isRecaptchaEnabled == true) {
                grecaptcha.reset();
            }
            var obj = JSON.parse(response);
            if (obj.type == 'message') {
                document.getElementById("message-subcomment-result-" + commentId).innerHTML = obj.message;
            } else {
                document.getElementById("comment-result").innerHTML = obj.message;
            }
            $('.visible-sub-comment form').empty();
        }
    })
});

//load more comment
function loadMoreComment(postId) {
    var limit = parseInt($("#post_comment_limit").val());
    var data = {
        "post_id": postId,
        "limit": limit
    };
    $("#load_comment_spinner").show();
    $.ajax({
        type: "POST",
        url: InfConfig.baseUrl + "/load-more-comment",
        data: setAjaxData(data),
        success: function (response) {
            setTimeout(function () {
                $("#load_comment_spinner").hide();
                var obj = JSON.parse(response);
                if (obj.result == 1) {
                    document.getElementById("comment-result").innerHTML = obj.content;
                }
            }, 1000)
        }
    });
}

//delete comment
function deleteComment(commentId, postId, message) {
    swal(swalOptions(message)).then(function (isConfirm) {
        if (isConfirm) {
            var limit = parseInt($("#post_comment_limit").val());
            var data = {
                "id": commentId,
                "post_id": postId,
                "limit": limit
            };
            $.ajax({
                type: "POST",
                url: InfConfig.baseUrl + "/delete-comment-post",
                data: setAjaxData(data),
                success: function (response) {
                    var obj = JSON.parse(response);
                    if (obj.result == 1) {
                        document.getElementById("comment-result").innerHTML = obj.content;
                    }
                }
            });
        }
    });
}

//show comment box
function showCommentBox(commentId) {
    $('.visible-sub-comment').empty();
    var limit = parseInt($("#post_comment_limit").val());
    var data = {
        "comment_id": commentId,
        "limit": limit
    };
    $.ajax({
        type: "POST",
        url: InfConfig.baseUrl + "/load-subcomment-post",
        data: setAjaxData(data),
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                $('#sub_comment_form_' + commentId).append(obj.content);
            }
        }
    });
}

$(document).ready(function () {
    $(".form-newsletter").submit(function (event) {
        event.preventDefault();
        var formId = $(this).attr('id');
        var input = "#" + formId + " .newsletter-input";
        var email = $(input).val().trim();
        if (email == "") {
            $(input).addClass('has-error');
            return false;
        } else {
            $(input).removeClass('has-error');
        }
        var data = {
            'email': email,
            'url': $("#" + formId + " [name = 'url']").val()
        }
        $.ajax({
            type: "POST",
            url: InfConfig.baseUrl + "/add-to-newsletter-post",
            data: setAjaxData(data),
            success: function (response) {
                var obj = JSON.parse(response);
                if (obj.result == 1) {
                    if (formId == "form_newsletter_footer") {
                        document.getElementById("form_newsletter_response").innerHTML = obj.response;
                    } else {
                        document.getElementById("modal_newsletter_response").innerHTML = obj.response;
                    }
                    if (obj.is_success == 1) {
                        $(input).val('');
                    }
                }
            }
        });
    });
});

//hide cookies warning
function hideCookiesWarning() {
    $(".cookies-warning").hide();
    $.ajax({
        type: "POST",
        url: InfConfig.baseUrl + "/cookies-warning-post",
        data: setAjaxData({}),
        success: function (response) {
        }
    });
}

//upload product image update page
$(document).on('change', '#Multifileupload', function () {
    var MultifileUpload = document.getElementById("Multifileupload");
    if (typeof (FileReader) != "undefined") {
        var MultidvPreview = document.getElementById("MultidvPreview");
        MultidvPreview.innerHTML = "";
        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
        for (var i = 0; i < MultifileUpload.files.length; i++) {
            var file = MultifileUpload.files[i];
            var reader = new FileReader();
            reader.onload = function (e) {
                var img = document.createElement("IMG");
                img.height = "100";
                img.width = "100";
                img.src = e.target.result;
                img.id = "Multifileupload_image";
                MultidvPreview.appendChild(img);
                $("#Multifileupload_button").show();
            }
            reader.readAsDataURL(file);
        }
    } else {
        alert("This browser does not support HTML5 FileReader.");
    }

});

$(document).ready(function () {
    $('.validate_terms').submit(function (e) {
        if (!$(".checkbox_terms_conditions").is(":checked")) {
            e.preventDefault();
            $('.custom-checkbox .checkbox-icon').addClass('is-invalid');
        } else {
            $('.custom-checkbox .checkbox-icon').removeClass('is-invalid');
        }
    });
});

//contact iframe
if ($('#contact_iframe').length) {
    var contactIframe = document.getElementById("contact_iframe");
    contactIframe.src = contactIframe.src;
}

//loader checkmark
$(document).ready(function () {
    $('.circle-loader').toggleClass('load-complete');
    $('.checkmark').toggle();
});

$(function () {
    $('.post-text table').wrap('<div style="overflow-x:auto;"></div>');
});

if ($(".fb-comments").length > 0) {
    $(".fb-comments").attr("data-href", window.location.href);
}

$("#form_validate").validate();
