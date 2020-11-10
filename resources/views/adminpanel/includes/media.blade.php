<script>

    $(function () {
        $("img").click(function () {
            $(this).toggleClass("hover");
            var id = [];
            $(".hover").each(function () {
                //jQuery.each('.hover', function() {
                id.push(jQuery(this).attr("image_id"));

            });
            //  id.push(jQuery('.test_image').attr("image_id"));
            jQuery('#images').val(id);
            console.log(id);
        });

        $("#btn").click(function () {

            if (confirm('Are You Sure To Delete This?')) {

                var imgs = $("img.hover").length;
                var parentFrom = $('#images_form');
                var formData = parentFrom.serialize();
                console.log(imgs);
                if (imgs > 0) {
                    $.ajax({
                        url: '{{ URL::to("admin/shop/media/delete")}}',
                        type: "POST",
                        data: formData,
                        success: function (res) {
                            if (res == 'success') {
                                location.reload();
                            }
                        },
                    });
                } else {
                    alert('Please choose image first.');
                }

            } else {
                // Do nothing!

            }


        });

        jQuery("#btn11").click(function () {
            var images = '<?php echo $images; ?>';
            var all_images = JSON.parse(images);
            jQuery.each(all_images, function () {
                jQuery('.test_image').addClass("hover");

            });
            var id = [];
            $(".hover").each(function () {
                id.push(jQuery(this).attr("image_id"));

            });
            jQuery('#images').val(id);

        });

        jQuery("#btn12").click(function () {
            var images = '<?php echo $images; ?>';
            var all_images = JSON.parse(images);
            jQuery.each(all_images, function () {
                jQuery('.test_image').removeClass("hover");

            });

        });

    });
    Dropzone.options.myDropzone = {
        paramName: 'file',
        maxFilesize: 5, // MB
        maxFiles: 20,
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        init: function () {
            this.on("success", function (file, response) {
                var a = document.createElement('span');
                // a.className = "thumb-url btn btn-primary";
                a.setAttribute('data-clipboard-text', '{{url('admin/shop/media/uploadimage')}}' + '/' + response);
                // a.innerHTML = "copy url";
                file.previewTemplate.appendChild(a);


            });

            this.on("success", function () {
                $("#compelete").removeAttr("disabled");
                $("#compelete").click(function () {

                    location.reload()
                })
            });


        }
    };

    $(document).on('click','#regenrate', function(e){
        $('#loader').show();
    })


</script>
