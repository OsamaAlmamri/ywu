<script>
    function Active(route_url) {
        $(document).on('click', '.active_disable_btn', function () {
            var data = '_token=' + encodeURIComponent("{{csrf_token()}}") + '&status=' + encodeURIComponent($(this).attr('data-status')) + '&id=' + encodeURIComponent($(this).attr('data-id'));
            var url = route_url;
            var _this = $(this);
            var active_type = $(this).data('active_type');
            $.ajax({
                url: url,//   var url=$('#news').attr('action');
                method: 'post',
                dataType: 'json',// data type that i want to return
                data: data,// var form=$('#news').serialize();
                success: function (data) {
                    if (data == 1) {
                        if (active_type == 'account')
                            _this.html("<i class=\"fa fa-toggle-on\"> </i>");
                        else
                            _this.html("<i class=\"fa fa-eye\"> </i>");
                        _this.attr("data-status", data);
                    } else {
                        if (active_type == 'account')
                            _this.html("<i class=\"fa fa-toggle-off\"> </i>");
                        else
                        _this.html("<i class=\"fa fa-eye-slash\"> </i>");
                        _this.attr("data-status", data);
                    }
                },
                error: function (xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
            return (false);
        });

    }
</script>
