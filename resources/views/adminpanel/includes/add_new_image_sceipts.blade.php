<script>
    var idCount = 1;

    var selectid = '#left_banner_selected' + idCount;

    var selectedthumbnail = '#selectedthumbnail' + idCount;
    var imageright = '#newImageleft' + idCount;
    // alert(selectid);
    var imageclose = '#image-close' + idCount

    $(document).on('click', selectid, function () {
        var image_src = $('.thumbnail.selected').children('img').attr('src');
        if (image_src != undefined) {
            $(selectedthumbnail).html('<img src="' + image_src + '" class = "thumbnail" style="max-height: 100px; margin-top: 20px;">');
            $(selectedthumbnail).show();
            $(imageclose).show();
            $('#imageselected').removeClass('has-error');
            $(imageright).removeClass('field-validate');
            $('.thumbnail.selected').removeClass('selected');
        }

    });

    $(document).on('click', imageclose, function () {
        $("select.show-html:not(#countertop_countertype_id)").val('').imagepicker({
            // show_label:   true,
            clicked: function () {
                $(this).find("option[value='" + $(this).val() + "']").empty();
            }
        });
        $(selectedthumbnail).hide();
        $(imageclose).hide();
        $('#imageselected').removeClass('has-error');
    });
    $(document).on('click', selectid, function () {
        var image_src = $('.thumbnail.selected').children('img').attr('src');
        if (image_src != undefined) {
            $(selectedthumbnail).html('<img src="' + image_src + '" class = "thumbnail" style="max-height: 100px; margin-top: 20px;">');
            $(selectedthumbnail).show();
            $(imageclose).show();
            $('#imageselected').removeClass('has-error');
            $(imageright).removeClass('field-validate');
            $('.thumbnail.selected').removeClass('selected');
        }

    });

    $(document).on('click', imageclose, function () {
        $("select.show-html:not(#countertop_countertype_id)").val('').imagepicker({
            // show_label:   true,
            clicked: function () {
                $(this).find("option[value='" + $(this).val() + "']").empty();
            }
        });
        $(selectedthumbnail).hide();
        $(imageclose).hide();
        $('#imageselected').removeClass('has-error');
    });
    $(document).on('click', '#selected', function () {
        var image_src = $('.thumbnail.selected').children('img').attr('src');
        if (image_src != undefined) {
            $('#selectedthumbnail').html('<img src="' + image_src + '" class = "thumbnail" style="max-height: 100px; margin-top: 20px;">');
            $('#selectedthumbnail').show();
            $('#image-close').show();
            $('#imageselected').removeClass('has-error');
            $('#newImage').removeClass('field-validate');
            $('.thumbnail.selected').removeClass('selected');
        }
    });
    $("select.show-html").imagepicker();
    $("#AddImage").click(function(){ window.location.href = '{{url("admin/shop/media/addimages")}}'; });

    $(document).on('click','#selected', function(){
        var image_src = $('.thumbnail.selected').children('img').attr('src');
        if(image_src != undefined){
            $('#selectedthumbnail').html('<img src="'+image_src+'" class = "thumbnail" style="max-height: 100px; margin-top: 20px;">');
            $('#selectedthumbnail').show();
            $('#image-close').show();
            $('#imageselected').removeClass('has-error');
            $('#newImage').removeClass('field-validate');
            $('.thumbnail.selected').removeClass('selected');
        }
    });

    $(document).on('click','#image-close', function(){
        $("select.show-html:not(#countertop_countertype_id)").val('').imagepicker({
            // show_label:   true,
            clicked:function(){
                $(this).find("option[value='" + $(this).val() + "']").empty();
            }
        });
        $('#selectedthumbnail').hide();
        $('#image-close').hide();
        $('#imageselected').removeClass('has-error');
    });

    $(document).on('click','#closemodal', function(){
        $("select.show-html:not(#countertop_countertype_id)").val('').imagepicker({
            // show_label:   true,
            clicked:function(){
                $(this).find("option[value='" + $(this).val() + "']").empty();
            }
        });
    });

    $(document).on('click','#selectedICONE', function(){
        var image_src = $('.thumbnail.selected').children('img').attr('src');
        if(image_src != undefined){
            $('#selectedthumbnailIcon').html('<img src="'+image_src+'" class = "thumbnail" style="max-height: 100px; margin-top: 20px; ">');
            $('#selectedthumbnailIcon').show();
            $('#image-Icone').show();
            $('#imageIcone').removeClass('has-error');
            $('#newIcon').removeClass('field-validate');
        }
    });

    //show modal
    $(document).on('click','.add-image', function(){
        var parent_id = $(this).parents('.image-content').attr('id');
        $('#'+parent_id+ ' #imagemodel').modal('show');
    });


    //select image from modal
    $(document).on('click','.selected-image', function(){
        var parent_id = $(this).parents('.image-content').attr('id');
        var image_src = $('#'+parent_id + ' .thumbnail.selected').children('img').attr('src');
        if(image_src != undefined){
            $('#'+parent_id+ ' .selectedthumbnail').html('<img src="'+image_src+'" class = "thumbnail" style="max-height: 100px; margin-top: 20px; ">');

            $('#'+parent_id+ '.selectedthumbnail').show();
            $('#'+parent_id+ '#show-image-btn').show();
            $('#'+parent_id).removeClass('has-error');
            $('#'+parent_id).removeClass('field-validate');

        }
    });

    $(document).on('click','#image-Icone', function(){
        var oldimage = $('#oldImage').val();
        console.log(oldimage);
        if(oldimage == undefined){
            $('#newIcon').addClass('field-validate');
        }

        $("select.show-html:not(#countertop_countertype_id)").val('').imagepicker({
            //$("select.show-html.iconimg:not(#countertop_countertype_id)").val('').imagepicker({
            // show_label:   true,
            clicked:function(){
                $(this).find("option[value='" + $(this).val() + "']").empty();
            }
        });
        $('#selectedthumbnailIcon').hide();
        $('#image-Icone').hide();
        $('#imageIcone').removeClass('has-error');

    });

    $(document).on('click', '#image-close', function () {
        $("select.show-html:not(#countertop_countertype_id)").val('').imagepicker({
            // show_label:   true,
            clicked: function () {
                $(this).find("option[value='" + $(this).val() + "']").empty();
            }
        });
        $('#selectedthumbnail').hide();
        $('#image-close').hide();
        $('#imageselected').removeClass('has-error');
    });


    //ajax call for submit value
    $(document).on('click', '.refresh-image', function(e){
        $("#loader").show();
        $.ajax({
            url: '{{ URL::to("admin/shop/media/refresh")}}',
            type: "GET",
            success: function (res) {
                $("#loader").hide();
                if(res.length != ''){
                    $('.show-html').html(res);
                }else{
                    $('.addError').show();
                }
                $("select.show-html").imagepicker();
            },
        });
    });

</script>
