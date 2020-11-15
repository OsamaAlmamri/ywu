@extends('adminpanel.master')
@section('content')
    <div class="right_col" role="main">
        <div class="row tile_count">
            <div style="font-weight: bold"><b>صلاحيات النظام</b></div>
            <br>

        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="row">

                    <div class="col-xs-1" style="margin: 20px">
                        <button id="btnShowModel" class="btn btn-primary"><i class="fa fa-plus"> </i></button>
                    </div>
                </div>
                <div class="card-block table-border-style">

                    <div class="table-responsive text-center">
                        <table class="table table-styling">
                            <thead>
                            <tr class="table-primary">
                                <th class="text-center">#</th>
                                <th class="text-center"> الدور </th>
                                <th class="text-center"> عمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $k=> $role)
                                <tr>
                                    <td>{{$k}}</td>
                                    <td>{{$role->name}}</td>
                                    <td>
                                        <a href="{{ route('admin.permissions.edit', $role->id) }}"
                                        ><i
                                                class="fa fa-pencil"></i></a>
                                        @if($role->users()->count() == 0 )
                                            <a href="{{route('admin.permissions.delete',encrypt( $role->id))}}"
                                               onclick="return confirm('هل أنت متأكد من الحذف');"><i
                                                    class="fa fa-trash"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="role_model" tabindex="-1">
                <style>
                    .form-group {
                        position: initial;
                    }
                </style>
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div id="additional_form_data"></div>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span class="ion-close-round">X</span>
                            </button>
                            <div>
                                <div class="row m-0">
                                    <div class="food-menu-details custom-head-details">
                                        <h4 class="p_name" style="text-align: center;"> اضافة صلاحية جديدة </h4>
                                        <!--<p class="p_price"></p>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="custom-content">
                                <input type="text" name="role" id="newRoleName">
                                <div class="print-error-msg alert-danger" id="error_role_name"></div>
                                <!-- Custom Section Ends -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btn_save_new_role" class="btn btn-primary btn-sm"> اضافة
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).on('click', '#btn_save_new_role', function () {
            var describtion = $('#newRoleName').val();
            var describtion = describtion.replace(/\s+/g, '');
            if (describtion == '')
                alert('يجب  ذكر اسم الصلاحية');
            else {
                $.ajax({
                    type: 'POST',
                    url: '{{route('admin.permissions.addNewRole')}}', //Returns ID in body
                    data: '_token=' + "{{csrf_token()}}" + '&name=' + $('#newRoleName').val(),
                    success: function (data) {
                        location.reload();
                    },
                    error: function (jqXhr, status) {
                        console.log(jqXhr);
                        if (jqXhr.status === 422) {
                            console.log('value');
                            $(".print-error-msg").html('');
                            $(".print-error-msg").show();
                            var errors = jqXhr.responseJSON.errors;
                            $.each(errors, function (key, value) {
                                $("#role_model").find("#error_role_" + key).html(value);

                            });
                        }
                    }
                });
            }


        })
        $(document).on('click', '#btnShowModel', function () {
            $('#role_model').modal('show');
            $('#btn_modal_cancel_order').attr('data-order_id', $(this).data('order_id'));
        });
    </script>
@endsection
