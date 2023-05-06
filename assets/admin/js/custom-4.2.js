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


//datatable
$(document).ready(function () {
    $('#cs_datatable').DataTable({
        "order": [[0, "desc"]],
        "aLengthMenu": [[15, 30, 60, 100], [15, 30, 60, 100, "All"]]
    });
});

$(function () {
    $('#tags_1').tagsInput({
        width: '100%',
        height: '80px',
        'defaultText': '',
    });
    $('#input_allowed_file_extensions').tagsInput({
        width: '100%',
        height: '100px',
        'defaultText': '',
    });
});

//Flat red color scheme for iCheck
$('input[type="checkbox"].flat-orange, input[type="radio"].flat-orange').iCheck({
    checkboxClass: 'icheckbox_flat-orange',
    radioClass: 'iradio_flat-orange'
});
$('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
    checkboxClass: 'icheckbox_flat-blue',
    radioClass: 'iradio_flat-blue'
});
$('input[type="checkbox"].square-purple, input[type="radio"].square-purple').iCheck({
    checkboxClass: 'icheckbox_square-purple',
    radioClass: 'iradio_square-purple',
    increaseArea: '20%' // optional
});

function getSubCategories(val) {
    var data = {
        "parent_id": val
    };
    $.ajax({
        type: "POST",
        url: InfConfig.baseUrl + "/CategoryController/getSubCategories",
        data: setAjaxData(data),
        success: function (response) {
            $('#subcategories').children('option:not(:first)').remove();
            $("#subcategories").append(response);
        }
    });
}

function getParentCategoriesByLang(val) {
    var data = {
        "lang_id": val
    };
    $.ajax({
        type: "POST",
        url: InfConfig.baseUrl + "/CategoryController/getParentCategoriesByLang",
        data: setAjaxData(data),
        success: function (response) {
            $('#categories').children('option:not(:first)').remove();
            $('#subcategories').children('option:not(:first)').remove();
            $("#categories").append(response);
        }
    });
}

function getAlbumsByLang(val) {
    var data = {
        "lang_id": val
    };
    $.ajax({
        type: "POST",
        url: InfConfig.baseUrl + "/GalleryController/galleryAlbumsByLang",
        data: setAjaxData(data),
        success: function (response) {
            $('#albums').children('option:not(:first)').remove();
            $("#albums").append(response);
        }
    });
}

function getCategoriesByAlbums(val) {
    var data = {
        "category_id": val
    };
    $.ajax({
        type: "POST",
        url: InfConfig.baseUrl + "/GalleryController/galleryCategoriesByAlbum",
        data: setAjaxData(data),
        success: function (response) {
            $('#categories').children('option:not(:first)').remove();
            $("#categories").append(response);
        }
    });
}

function setAsAlbumCover(val) {
    var data = {
        "image_id": val
    };
    $.ajax({
        type: "POST",
        url: InfConfig.baseUrl + "/GalleryController/setAsAlbumCover",
        data: setAjaxData(data),
        success: function (response) {
            location.reload();
        }
    });
}

function getMenuLinksByLang(val) {
    var data = {
        "lang_id": val
    };
    $.ajax({
        type: "POST",
        url: InfConfig.baseUrl + "/AdminController/getMenuLinksByLang",
        data: setAjaxData(data),
        success: function (response) {
            $('#parent_links').children('option:not(:first)').remove();
            $("#parent_links").append(response);
        }
    });
}

//datetimepicker
$(function () {
    $('#datetimepicker').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss'
    });
});

$('#cb_scheduled').on('ifChecked', function () {
    $("#date_published_content").show();
    $("#input_date_published").prop('required', true);
});
$('#cb_scheduled').on('ifUnchecked', function () {
    $("#date_published_content").hide();
    $("#input_date_published").prop('required', false);
});

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
$(document).on('change', '#ckMultifileupload', function () {
    var MultifileUpload = document.getElementById("ckMultifileupload");
    if (typeof (FileReader) != "undefined") {
        var MultidvPreview = document.getElementById("ckMultidvPreview");
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
/*
*
* Video Upload Functions
*
* */

$("#video_embed_code").on("change keyup paste", function () {
    var embed_code = $("#video_embed_code").val();
    $("#video_preview").attr('src', embed_code);

    if ($("#video_embed_code").val() == '') {
        $("#selected_image_file").attr('src', '');
    }
});

$("#video_thumbnail_url").on("change keyup paste", function () {
    var url = $("#video_thumbnail_url").val();
    $("#selected_image_file").attr('src', url);
    $('input[name="post_image_id"]').val('');
});

//reset file input
function reset_file_input(id) {
    $(id).val('');
    $(id + "_label").html('');
    $(id + "_button").hide();
}

//reset preview image
function reset_preview_image(id) {
    $(id).val('');
    $(id + "_image").remove();
    $(id + "_button").hide();
}

//check all checkboxes
$("#checkAll").click(function () {
    $('input:checkbox').not(this).prop('checked', this.checked);
});

//show hide delete button
$('.checkbox-table').click(function () {
    if ($(".checkbox-table").is(':checked')) {
        $(".btn-table-delete").show();
    } else {
        $(".btn-table-delete").hide();
    }
});

//delete selected posts
function deleteSelectedPosts(message) {
    swal(swalOptions(message)).then(function (isConfirm) {
        if (isConfirm) {
            var postIds = [];
            $("input[name='checkbox-table']:checked").each(function () {
                postIds.push(this.value);
            });
            var data = {
                'post_ids': postIds,
            };
            $.ajax({
                type: "POST",
                url: InfConfig.baseUrl + "/PostController/deleteSelectedPosts",
                data: setAjaxData(data),
                success: function (response) {
                    location.reload();
                }
            });
        }
    });
};

//approve selected comments
function approveSelectedComments() {
    var commentIds = [];
    $("input[name='checkbox-table']:checked").each(function () {
        commentIds.push(this.value);
    });
    var data = {
        'comment_ids': commentIds,
    };
    $.ajax({
        type: "POST",
        url: InfConfig.baseUrl + "/AdminController/approveSelectedComments",
        data: setAjaxData(data),
        success: function (response) {
            location.reload();
        }
    });
};

//delete selected comments
function deleteSelectedComments(message) {
    swal(swalOptions(message)).then(function (isConfirm) {
        if (isConfirm) {
            var commentIds = [];
            $("input[name='checkbox-table']:checked").each(function () {
                commentIds.push(this.value);
            });
            var data = {
                'comment_ids': commentIds,
            };
            $.ajax({
                type: "POST",
                url: InfConfig.baseUrl + "/AdminController/deleteSelectedComments",
                data: setAjaxData(data),
                success: function (response) {
                    location.reload();
                }
            });
        }
    });
};

//delete post main image
$(document).on('click', '#btn_delete_post_main_image', function () {
    var content = '<a class="btn-select-image" data-toggle="modal" data-target="#image_file_manager" data-image-type="main">' +
        '<div class="btn-select-image-inner">' +
        '<i class="fa fa-image"></i>' +
        '<button class="btn">' + txt_select_image + '</button>' +
        '</div>' +
        '</a>';
    document.getElementById("post_select_image_container").innerHTML = content;
    $("#post_image_id").val('');
    $("#input_image_url").val('');
});

//delete post main image database
$(document).on('click', '#btn_delete_post_main_image', function () {
    var content = '<a class="btn-select-image" data-toggle="modal" data-target="#image_file_manager" data-image-type="main">' +
        '<div class="btn-select-image-inner">' +
        '<i class="fa fa-image"></i>' +
        '<button class="btn">' + txt_select_image + '</button>' +
        '</div>' +
        '</a>';
    document.getElementById("post_select_image_container").innerHTML = content;
    $("#post_image_id").val('');
    $("#input_image_url").val('');
});

$("#input_image_url").on("change keyup paste", function () {
    var url = $("#input_image_url").val();
    var image = '<div class="post-select-image-container">' +
        '<img src="' + url + '" alt="">' +
        '<a id="btn_delete_post_main_image" class="btn btn-danger btn-sm btn-delete-selected-file-image">' +
        '<i class="fa fa-times"></i> ' +
        '</a>' +
        '</div>';
    document.getElementById("post_select_image_container").innerHTML = image;
    $('#selected_image_file').css('margin-top', '15px');
});

$(document).on('click', '#btn_delete_post_main_image_database', function () {
    var data = {
        "post_id": $(this).attr('data-post-id')
    };
    $.ajax({
        type: "POST",
        url: InfConfig.baseUrl + "/PostController/deletePostMainImage",
        data: setAjaxData(data),
        success: function (response) {
            var content = '<a class="btn-select-image" data-toggle="modal" data-target="#image_file_manager" data-image-type="main">' +
                '<div class="btn-select-image-inner">' +
                '<i class="fa fa-image"></i>' +
                '<button class="btn">' + txt_select_image + '</button>' +
                '</div>' +
                '</a>';
            document.getElementById("post_select_image_container").innerHTML = content;
            $("#post_image_id").val('');
            $("#input_image_url").val('');
        }
    });
});

$('.increase-count').each(function () {
    $(this).prop('Counter', 0).animate({
        Counter: $(this).text()
    }, {
        duration: 1000,
        easing: 'swing',
        step: function (now) {
            $(this).text(Math.ceil(now));
        }
    });
});

//delete item
function deleteItem(url, id, message) {
    swal(swalOptions(message)).then(function (isConfirm) {
        if (isConfirm) {
            var data = {
                'id': id,
            };
            $.ajax({
                type: "POST",
                url: InfConfig.baseUrl + '/' + url,
                data: setAjaxData(data),
                success: function (response) {
                    location.reload();
                }
            });
        }
    });
};

//delete additional image
$(document).on('click', '.btn-delete-additional-image', function () {
    var item_id = $(this).attr("data-value");
    $('.additional-item-' + item_id).remove();

});

//delete additional image from database
$(document).on('click', '.btn-delete-additional-image-database', function () {
    var fileId = $(this).attr("data-value");
    $('.additional-item-' + fileId).remove();
    var data = {
        "file_id": fileId
    };
    $.ajax({
        type: "POST",
        url: InfConfig.baseUrl + "/PostController/deletePostAdditionalImage",
        data: setAjaxData(data),
        success: function (response) {
        }
    });
});

//delete selected file
$(document).on('click', '.btn-delete-selected-file', function () {
    var item_id = $(this).attr("data-value");
    $('#file_' + item_id).remove();
});

//delete selected file from database
$(document).on('click', '.btn-delete-selected-file-database', function () {
    var fileId = $(this).attr("data-value");
    $('#post_selected_file_' + fileId).remove();
    var data = {
        "file_id": fileId
    };
    $.ajax({
        type: "POST",
        url: InfConfig.baseUrl + "/PostController/deletePostFile",
        data: setAjaxData(data),
        success: function (response) {
        }
    });
});

//delete video image
function delete_video_image(post_id) {
    var data = {
        "post_id": post_id,
    };
    $.ajax({
        type: "POST",
        url: InfConfig.baseUrl + "/PostController/deletePostMainImage",
        data: setAjaxData(data),
        success: function (response) {
            $('.btn-delete-main-img').hide();
            $("#selected_image_file").attr('src', '');
            $("#video_thumbnail_url").val('');
            document.getElementById("post_selected_video").innerHTML = " ";
            $(".btn-delete-post-video").hide();
        }
    });
}

/*
*
* Video Upload Functions
*
* */

$("#video_embed_code").on("change keyup paste", function () {
    var embed_code = $("#video_embed_code").val();
    $("#video_preview").attr('src', embed_code);

    if ($("#video_embed_code").val() == '') {
        $("#selected_image_file").attr('src', '');
    }
});

function getVideoFromURL() {
    var url = $("#video_url").val();
    if (url) {
        var data = {
            "url": url,
        };
        $.ajax({
            type: "POST",
            url: InfConfig.baseUrl + "/PostController/getVideoFromURL",
            data: setAjaxData(data),
            success: function (response) {
                var obj = JSON.parse(response);
                if (obj.video_embed_code) {
                    $("#video_embed_code").html(obj.video_embed_code);
                    $("#video_embed_preview").attr('src', obj.video_embed_code);
                    $("#video_embed_preview").show();
                }
                if (obj.video_thumbnail) {
                    $("#video_thumbnail_url").val(obj.video_thumbnail);
                    $("#selected_image_file").attr('src', obj.video_thumbnail);
                }
            }
        });
    }
}

$("#video_thumbnail_url").on("change keyup paste", function () {
    var url = $("#video_thumbnail_url").val();
    $("#selected_image_file").attr('src', url);
    $('input[name="post_image_id"]').val('');
});


$(document).ajaxStop(function () {
    $('input[type="checkbox"].square-purple, input[type="radio"].square-purple').iCheck({
        checkboxClass: 'icheckbox_square-purple',
        radioClass: 'iradio_square-purple',
        increaseArea: '20%' // optional
    });
    $('#cb_scheduled').on('ifChecked', function () {
        $("#date_published_content").show();
        $("#input_date_published").prop('required', true);
    });
    $('#cb_scheduled').on('ifUnchecked', function () {
        $("#date_published_content").hide();
        $("#input_date_published").prop('required', false);
    });
});