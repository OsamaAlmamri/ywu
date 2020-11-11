@extends('adminpanel.dataTableLayout')
@section('card_header')
    <div class="card-header">
        <br/>
        <h3 align="right"> خيارات المنتجات </h3>
        <br/>
    </div>
@endsection
@section('content')
    <div class="content-wrapper">


        <!-- Main content -->
        <section class="content">
            <!-- Info boxes -->
            <!-- /.row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">{{ trans('labels.ListingDefaultOptions') }} </h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-block btn-primary" data-toggle="modal"
                                        data-target="#adddefaultattributesmodal">
                                    {{ trans('labels.AddDefaultOption') }}
                                </button>
                            </div>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>{{ trans('labels.ID') }}</th>
                                            <th>{{ trans('labels.OptionName') }}</th>
                                            <th>{{ trans('labels.OptionValue') }}</th>
                                            <th>{{ trans('labels.Action') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody class="contentDefaultAttribute">

                                        @if (count($result['products_attributes']) > 0)
                                            @foreach($result['products_attributes'] as $key=>$products_attributes)
                                                @if($products_attributes->is_default == '1')
                                                    <tr>
                                                        <td>{{ ++$key }}</td>
                                                        <td>{{ $products_attributes->products_options_name }}</td>
                                                        <td>{{ $products_attributes->products_options_values_name }}</td>
                                                    <!--<td>{{ $products_attributes->price_prefix }}{{ $products_attributes->options_values_price }}</td>-->
                                                        <td>
                                                            <a class="badge bg-light-blue editdefaultattributemodal"
                                                               product_id='{{ $products_attributes->product_id }}'
                                                               products_attributes_id="{{ $products_attributes->products_attributes_id }}"
                                                               options_id='{{ $products_attributes->options_id }}'><i
                                                                    class="fa fa-pencil-square-o"
                                                                    aria-hidden="true"></i></a>
                                                            <a product_id='{{ $products_attributes->product_id }}'
                                                               products_attributes_id="{{ $products_attributes->products_attributes_id }}"
                                                               class="badge bg-red deletedefaultattributemodal"><i
                                                                    class="fa fa-trash " aria-hidden="true"></i></a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5"><strong>
                                                        {{ trans('labels.NoRecordFoundTextForDefaultOption') }}</strong>
                                                </td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>

                                    <!-- adddefaultattributesmodal -->
                                    <div class="modal fade" id="adddefaultattributesmodal" tabindex="-1" role="dialog"
                                         aria-labelledby="addAttributeModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close"><span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <h4 class="modal-title"
                                                        id="addAttributeModalLabel">{{ trans('labels.AddOptions') }}</h4>
                                                </div>
                                                {!! Form::open(array('url' =>'admin/products/attach/attribute/default', 'name'=>'addattributefrom', 'id'=>'adddefaultattributefrom', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                                               @csrf
                                                {!! Form::hidden('product_id',  $result['data']['product_id'], array('class'=>'form-control', 'id'=>'product_id')) !!}
                                                {!! Form::hidden('subcategory_id',  $result['subcategory_id'], array('class'=>'form-control', 'id'=>'subcategory_id')) !!}
                                                {!! Form::hidden('is_default',  '1', array('class'=>'form-control', 'id'=>'is_default')) !!}

                                                <div class="modal-body">

                                                    <div class="form-group">
                                                        <label for="name" class="col-sm-2 col-md-4 control-label">
                                                            {{ trans('labels.OptionName') }}
                                                        </label>
                                                        <div class="col-sm-10 col-md-8">
                                                            <select
                                                                class="form-control default-option-id field-validate"
                                                                name="products_options_id">
                                                                <option value=""
                                                                        class="field-validate">{{ trans('labels.ChooseOptions') }}</option>
                                                                @foreach($result['options'] as $option)
                                                                    <option
                                                                        value="{{ $option->products_options_id }}">{{ $option->products_options_name }}</option>
                                                                @endforeach
                                                            </select><span class="help-block"
                                                                           style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                            	{{ trans('labels.AddOptionNameText') }}
                                 </span>

                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="name"
                                                               class="col-sm-2 col-md-4 control-label">{{ trans('labels.OptionValues') }}</label>
                                                        <div class="col-sm-10 col-md-8">
                                                            <select
                                                                class="form-control products_options_values_id field-validate"
                                                                name="products_options_values_id"> </select>
                                                            <span class="help-block"
                                                                  style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                  {{ trans('labels.AddOptionValueText') }}</span>
                                                        </div>
                                                    </div>

                                                    <div class="alert alert-danger addDefaultError"
                                                         style="display: none; margin-bottom: 0;" role="alert"><i
                                                            class="icon fa fa-ban"></i><span></span></div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">{{ trans('labels.Close') }}</button>
                                                    <button type="button" class="btn btn-primary"
                                                            id="addDefaultAttribute">{{ trans('labels.AddOption') }}</button>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- editdefaultattributemodal -->
                                    <div class="modal fade" id="editdefaultattributemodal" tabindex="-1" role="dialog"
                                         aria-labelledby="editdefaultattributemodalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content editDefaultContent">

                                            </div>
                                        </div>
                                    </div>

                                    <!-- deletedefaultattributemodal -->
                                    <div class="modal fade" id="deletedefaultattributemodal" tabindex="-1" role="dialog"
                                         aria-labelledby="deletedefaultattributemodalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content deleteDefaultEmbed">

                                            </div>
                                        </div>


                                    </div>

                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- Main row -->
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">{{ trans('labels.ListingAdditionalProductsOptions') }} </h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-block btn-primary" data-toggle="modal"
                                        data-target="#addAttributeModal">
                                    {{ trans('labels.AddAdditionalOption') }}</button>
                            </div>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>{{ trans('labels.ID') }}</th>
                                            <th>{{ trans('labels.OptionName') }}</th>
                                            <th>{{ trans('labels.OptionValue') }}</th>
                                            <th>{{ trans('labels.Price') }}</th>
                                            <th>{{ trans('labels.Action') }}</th>

                                        </tr>
                                        </thead>
                                        <tbody class="contentAttribute">

                                        @if (count($result['products_attributes']) > 0)
                                            @foreach($result['products_attributes'] as $key=>$products_attributes)

                                                @if($products_attributes->is_default == '0')
                                                    <tr>
                                                        <td>{{ ++$key }}</td>
                                                        <td>{{ $products_attributes->products_options_name }}</td>
                                                        <td>{{ $products_attributes->products_options_values_name }}</td>
                                                        <td>{{ $products_attributes->price_prefix }}{{ $products_attributes->options_values_price }}</td>
                                                        <td>
                                                            <a class="badge bg-light-blue editproductattributemodal"
                                                               product_id='{{ $products_attributes->product_id }}'
                                                               products_attributes_id="{{ $products_attributes->products_attributes_id }}"
                                                               options_id='{{ $products_attributes->options_id }}'><i
                                                                    class="fa fa-pencil-square-o"
                                                                    aria-hidden="true"></i></a>
                                                            <a product_id='{{ $products_attributes->product_id }}'
                                                               products_attributes_id="{{ $products_attributes->products_attributes_id }}"
                                                               class="badge bg-red deleteproductattributemodal"><i
                                                                    class="fa fa-trash " aria-hidden="true"></i></a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5">
                                                    {{ trans('labels.NoRecordFoundTextForAdditionalOption') }}
                                                </td>
                                            </tr>
                                        @endif


                                        </tbody>
                                    </table>

                                    <!-- addAttributeModal -->
                                    <div class="modal fade" id="addAttributeModal" tabindex="-1" role="dialog"
                                         aria-labelledby="addAttributeModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close"><span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <h4 class="modal-title"
                                                        id="addAttributeModalLabel">{{ trans('labels.AddOptions') }}</h4>
                                                </div>
                                                {!! Form::open(array('url' =>'admin/products/attach/attribute/default/options/add', 'name'=>'addattributefrom', 'id'=>'addattributefrom', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                                              @csrf
                                                {!! Form::hidden('product_id',  $result['data']['product_id'], array('class'=>'form-control', 'id'=>'product_id')) !!}

                                                {!! Form::hidden('subcategory_id',  $result['subcategory_id'], array('class'=>'form-control', 'id'=>'subcategory_id')) !!}
                                                {!! Form::hidden('is_default',  '0', array('class'=>'form-control', 'id'=>'is_default')) !!}
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="name"
                                                               class="col-sm-2 col-md-4 control-label">{{ trans('labels.OptionName') }}  </label>
                                                        <div class="col-sm-10 col-md-8">
                                                            <select
                                                                class="form-control  additional-option-id field-validate"
                                                                name="products_options_id">
                                                                <option value=""
                                                                        class="field-validate">{{ trans('labels.ChooseOptions') }}</option>
                                                                @foreach($result['options'] as $option)
                                                                    <option
                                                                        value="{{ $option->products_options_id }}">{{ $option->products_options_name }}</option>
                                                                @endforeach
                                                            </select> <span class="help-block"
                                                                            style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
								  {{ trans('labels.OptionNameText') }}
								  </span>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="name"
                                                               class="col-sm-2 col-md-4 control-label">{{ trans('labels.OptionValues') }}</label>
                                                        <div class="col-sm-10 col-md-8">
                                                            <select
                                                                class="form-control additional_products_options_values_id field-validate"
                                                                name="products_options_values_id">
                                                            </select>
                                                            <span class="help-block"
                                                                  style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                  {{ trans('labels.OptionValuesText') }}</span>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="name"
                                                               class="col-xs-12 col-sm-2 col-md-4 control-label">{{ trans('labels.Price') }}</label>
                                                        <div class="col-xs-4 col-sm-2">
                                                            <select class="form-control" name="price_prefix"
                                                                    id="price_prefix">
                                                                <option value="+">+</option>
                                                                <option value="-">-</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-xs-8 col-sm-8 col-md-6">
                                                            {!! Form::text('options_values_price',  '0', array('class'=>'form-control', 'id'=>'options_values_price')) !!}
                                                            <span class="help-block"
                                                                  style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.NumericValueError') }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="alert alert-danger addError"
                                                         style="display: none; margin-bottom: 0;" role="alert">Already
                                                        Exist<i class="icon fa fa-ban"></i><span></span></div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">{{ trans('labels.Close') }}</button>
                                                    <button type="button" class="btn btn-primary"
                                                            id="addAttribute">{{ trans('labels.AddOption') }}</button>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- editproductattributemodal -->
                                    <div class="modal fade" id="editproductattributemodal" tabindex="-1" role="dialog"
                                         aria-labelledby="editproductattributemodalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content editContent">

                                            </div>
                                        </div>
                                    </div>

                                    <!-- deleteproductattributemodal -->
                                    <div class="modal fade" id="deleteproductattributemodal" tabindex="-1" role="dialog"
                                         aria-labelledby="deleteproductattributemodalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content deleteEmbed">

                                            </div>
                                        </div>


                                    </div>

                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer text-center">
                                <a href="{{ route('admin.shop.products.index')}}" class="btn btn-default pull-right"><i
                                        class="fa fa-angle-right"></i> {{ trans('labels.back') }} </a>
                                <a href="{{ URL::to("admin/products/images/display/{$result['data']['product_id']}")}}"
                                   class="btn btn-primary pull-left"> {{ trans('labels.Save_And_Continue') }} <i
                                        class="fa fa-angle-left"></i></a>
                            </div>

                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- Main row -->


                <!-- Main row -->
            </div>

            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
@endsection
@section('custom_js')

    <script>
        //ajax call for submit value
        $(document).on('click', '#addDefaultAttribute', function (e) {
            $("#loader").show();
            var formData = $('#adddefaultattributefrom').serialize();
            $.ajax({
                url: '{{ URL::to("admin/products/attach/attribute/default")}}',
                type: "POST",
                data: formData,
                success: function (res) {
                    $("#loader").hide();
                    if (res.length != '') {
                        $('.addError').hide();
                        $('#adddefaultattributesmodal').modal('hide');
                        var i;
                        var showData = [];
                        for (i = 0; i < res.length; ++i) {
                            var j = i + 1;
                            showData[i] = "<tr><td>" + j + "</td><td>" + res[i].products_options_name + "</td><td>" + res[i].products_options_values_name + "</td><td><a class='badge bg-light-blue editdefaultattributemodal' products_attributes_id = '" + res[i].products_attributes_id + "' product_id = '" + res[i].product_id + "' language_id ='" + res[i].language_id + "' options_id ='" + res[i].options_id + "'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a> <a class='badge bg-red deletedefaultattributemodal' products_attributes_id = '" + res[i].products_attributes_id + "' product_id = '" + res[i].product_id + "' ><i class='fa fa-trash' aria-hidden='true'></i></a></td></tr>";

                        }
                        $(".contentDefaultAttribute").html(showData);

                    } else {
                        $('.addDefaultError').show();
                    }


                },
            });


        });
        //editproductattributemodal
        $(document).on('click', '.editproductattributemodal', function () {
            var product_id = $(this).attr('product_id');
            var products_attributes_id = $(this).attr('products_attributes_id');
            var language_id = $(this).attr('language_id');
            var options_id = $(this).attr('options_id');
            $.ajax({
                url: '{{ URL::to("admin/products/attach/attribute/default/options/edit")}}',
                type: "POST",
                data:  '_token=' + ("{{csrf_token()}}") +'&product_id=' + product_id + '&products_attributes_id=' + products_attributes_id + '&language_id=' + language_id + '&options_id=' + options_id,
                success: function (data) {
                    $('.editContent').html(data);
                    $('#editproductattributemodal').modal('show');
                },
                dataType: 'html'
            });
        });

        //editdefaultattributemodal
        $(document).on('click', '.editdefaultattributemodal', function () {
            var product_id = $(this).attr('product_id');
            var products_attributes_id = $(this).attr('products_attributes_id');
            var language_id = $(this).attr('language_id');
            var options_id = $(this).attr('options_id');
            $.ajax({
                url: "{{ URL::to('admin/products/attach/attribute/default/edit')}}",
                type: "POST",
                data:  '_token=' + ("{{csrf_token()}}") +'&product_id=' + product_id + '&products_attributes_id=' + products_attributes_id + '&language_id=' + language_id + '&options_id=' + options_id,
                success: function (data) {
                    $('.editDefaultContent').html(data);
                    $('#editdefaultattributemodal').modal('show');
                },
                dataType: 'html'
            });
        });

        $(document).on('click', '#updateProductAttribute', function (e) {
            $("#loader").show();
            var formData = $('#editAttributeFrom').serialize();
            $.ajax({
                url: '{{ URL::to("admin/products/attach/attribute/default/options/update")}}',
                type: "POST",
                data: formData,
                success: function (res) {
                    $("#loader").hide();
                    if (res.length != '') {
                        $('.addError').hide();
                        $('#editproductattributemodal').modal('hide');
                        var i;
                        var showData = [];
                        for (i = 0; i < res.length; ++i) {
                            var j = i + 1;
                            showData[i] = "<tr><td>" + j + "</td><td>" + res[i].products_options_name + "</td><td>" + res[i].products_options_values_name + "</td><td>" + res[i].price_prefix + " " + res[i].options_values_price + "</td><td>    <a class='badge bg-light-blue editproductattributemodal' products_attributes_id = '" + res[i].products_attributes_id + "' product_id = '" + res[i].product_id + "'  language_id = '" + res[i].language_id + "'  options_id = '" + res[i].options_id + "'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a> <a class='badge bg-red deleteproductattributemodal' products_attributes_id = '" + res[i].products_attributes_id + "' product_id = '" + res[i].product_id + "' language_id = '" + res[i].language_id + "'  options_id = '" + res[i].options_id + "'><i class='fa fa-trash' aria-hidden='true'></i></a></td></tr>";

                        }
                        $(".contentAttribute").html(showData);
                    } else {
                        $('.addError').show();
                    }


                },
            });

        });


        $(document).on('click', '#updateDefaultAttribute', function (e) {
            $("#loader").show();
            var formData = $('#editDefaultAttributeFrom').serialize();
            $.ajax({
                url: "{{ URL::to('admin/products/attach/attribute/default/update')}}",
                type: "POST",
                data: formData,
                success: function (res) {
                    $("#loader").hide();
                    if (res.length != '') {
                        $('.addError').hide();
                        $('#editdefaultattributemodal').modal('hide');
                        var i;
                        var showData = [];
                        for (i = 0; i < res.length; ++i) {
                            var j = i + 1;
                            showData[i] = "<tr><td>" + j + "</td><td>" + res[i].products_options_name + "</td><td>" + res[i].products_options_values_name + "</td><td><a class='badge bg-light-blue editdefaultattributemodal' products_attributes_id = '" + res[i].products_attributes_id + "' product_id = '" + res[i].product_id + "' language_id ='" + res[i].language_id + "' options_id ='" + res[i].options_id + "'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a> <a class='badge bg-red deletedefaultattributemodal' products_attributes_id = '" + res[i].products_attributes_id + "' product_id = '" + res[i].product_id + "' ><i class='fa fa-trash' aria-hidden='true'></i></a></td></tr>";
                        }
                        $(".contentDefaultAttribute").html(showData);
                    } else {
                        $('.addError').show();
                    }


                },
            });

        });
        //product options option with language id
        $(document).on('change', '.default-option-id', function(){
            var option_id = $(this).val();
            getOptionsValue(option_id);
        });

        //product options option with language id
        $(document).on('change', '.edit-default-option-id', function(){
            var option_id = $(this).val();
            getEditOptionsValue(option_id);
        });
        //deleteproductattributemodal
        $(document).on('click', '.deleteproductattributemodal', function () {
            var product_id = $(this).attr('product_id');
            var products_attributes_id = $(this).attr('products_attributes_id');
            $.ajax({
                url: "{{ URL::to('admin/products/attach/attribute/default/options/showdeletemodal')}}",
                type: "POST",
                data: '_token=' + ("{{csrf_token()}}") +'&product_id=' + product_id + '&products_attributes_id=' + products_attributes_id,
                success: function (data) {
                    $('.deleteEmbed').html(data);
                    $('#deleteproductattributemodal').modal('show');
                },
                dataType: 'html'
            });
        });

        //deletedefaultattributemodal
        $(document).on('click', '.deletedefaultattributemodal', function () {
            var product_id = $(this).attr('product_id');
            var products_attributes_id = $(this).attr('products_attributes_id');
            $.ajax({
                url: "{{ URL::to('admin/products/attach/attribute/default/deletedefaultattributemodal')}}",
                type: "POST",
                data:  '_token=' + ("{{csrf_token()}}") +'&product_id=' + product_id + '&products_attributes_id=' + products_attributes_id,
                success: function (data) {
                    $('.deleteDefaultEmbed').html(data);
                    $('#deletedefaultattributemodal').modal('show');
                },
                dataType: 'html'
            });
        });
        //product options option with language id
        $(document).on('change', '.additional-option-id', function(){
            // alert('a');
            var option_id = $(this).val();
            getAdditionalOptionsValue(option_id);
        });

        //product options option with language id
        $(document).on('change', '.edit-additional-option-id', function(){
            var option_id = $(this).val();
            getEditAdditionalOptionsValue(option_id);
        });
        //deleteOption
        $(document).on('click', '.deleteOption', function () {
            $("#loader").show();
            var option_id = $(this).attr('option_id');
            $.ajax({
                url: "{{ URL::to('admin/products/attributes/options/values/checkattributeassociate')}}",
                type: "POST",
                data: '_token=' + ("{{csrf_token()}}") + '&option_id=' + option_id,
                success: function (res) {
                    $("#loader").hide();
                    if (res.length != '') {
                        $('.addError').hide();
                        $("#assciate-products").html(res);
                        $('#productListModal').modal('show');
                    } else {
                        $('#option_id').val(option_id);
                        $('#productListModal').modal('hide');
                        $('#deleteattributeModal').modal('show');
                        $(".contentAttribute").html(res);
                    }
                },
            });
        });


        // delete-value
        $(document).on('click', '.delete-value', function () {
            $("#loader").show();
            var value_id = $(this).attr('value_id');
            var delete_products_options_id = $(this).attr('option_id');
            var delete_language_id = $(this).attr('language_id');
            //alert(delete_language_id);
            $.ajax({
                url: "{{ URL::to('admin/products/attributes/options/values/checkvalueassociate')}}",
                type: "POST",
                data:  '_token=' + ("{{csrf_token()}}") +'&value_id=' + value_id,
                success: function (res) {
                    $("#loader").hide();
                    //$('.deleteEmbed').html(res);
                    //alert(res);
                    if (res.length != '') {
                        $('.addError').hide();
                        $("#assciate-products-value").html(res);
                        $('#productListModalValue').modal('show');
                    } else {
                        $('#value_id').val(value_id);
                        $('#delete_products_options_id').val(delete_products_options_id);
                        $('#delete_language_id').val(delete_language_id);
                        $('#productListModalValue').modal('hide');
                        $('#deleteValueModal').modal('show');
                        $(".contentAttribute").html(res);

                    }


                },
            });
        });

        //deleteProductAttribute
        $(document).on('click', '#deleteProductAttribute', function () {
            $("#loader").show();
            var formData = $('#deleteattributeform').serialize();
            console.log(formData);
            $.ajax({
                url: "{{ URL::to('admin/products/attach/attribute/default/delete')}}",
                type: "POST",
                data: formData,
                success: function (res) {
                    $("#loader").hide();
                    //$('.deleteEmbed').html(res);
                    //alert(res);
                    if (res.length != '') {
                        $('.addError').hide();
                        $('#deleteproductattributemodal').modal('hide');
                        var i;
                        var showData = [];
                        for (i = 0; i < res.length; ++i) {
                            var j = i + 1;
                            showData[i] = "<tr><td>" + j + "</td><td>" + res[i].products_options_name + "</td><td>" + res[i].products_options_values_name + "</td><td>" + res[i].price_prefix + " " + res[i].options_values_price + "</td><td>    <a class='badge bg-light-blue editproductattributemodal' products_attributes_id = '" + res[i].products_attributes_id + "' product_id = '" + res[i].product_id + "'  language_id = '" + res[i].language_id + "'  options_id = '" + res[i].options_id + "'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a> <a class='badge bg-red deleteproductattributemodal' products_attributes_id = '" + res[i].products_attributes_id + "' product_id = '" + res[i].product_id + "' language_id = '" + res[i].language_id + "'  options_id = '" + res[i].options_id + "'><i class='fa fa-trash' aria-hidden='true'></i></a></td></tr>";
                        }

                        $(".contentAttribute").html(showData);
                    } else {

                        $('#deleteproductattributemodal').modal('hide');
                        $('.addError').show();
                        $(".contentAttribute").html(res);
                    }
                },
            });
        });


        //deletedefaultattributemodal
        $(document).on('click', '#deleteDefaultAttribute', function () {
            $("#loader").show();
            var formData = $('#deletedefaultattributeform').serialize();
            console.log(formData);
            $.ajax({
                url: "{{ URL::to('admin/products/attach/attribute/default/delete')}}",
                type: "POST",
                data: formData,
                success: function (res) {
                    $("#loader").hide();
                    //$('.deleteEmbed').html(res);
                    //alert(res);
                    if (res.length != '') {
                        $('.addError').hide();
                        $('#deletedefaultattributemodal').modal('hide');
                        var i;
                        var showData = [];
                        for (i = 0; i < res.length; ++i) {
                            var j = i + 1;
                            showData[i] = "<tr><td>" + j + "</td><td>" + res[i].products_options_name + "</td><td>" + res[i].products_options_values_name + "</td><td><a class='badge bg-light-blue editdefaultattributemodal' products_attributes_id = '" + res[i].products_attributes_id + "'  product_id = '" + res[i].product_id + "' language_id ='" + res[i].language_id + "' options_id ='" + res[i].options_id + "'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a> <a class='badge bg-red deletedefaultattributemodal' products_attributes_id = '" + res[i].products_attributes_id + "' product_id = '" + res[i].product_id + "' ><i class='fa fa-trash' aria-hidden='true'></i></a></td></tr>";
                        }

                        $(".contentDefaultAttribute").html(showData);
                    } else {

                        $('#deletedefaultattributemodal').modal('hide');
                        $('.addDefaultError').show();
                        $(".contentDefaultAttribute").html(res);
                    }
                },
            });
        });

        function getOptionsValue(option_id) {
            var language_id = $('.language_id').val();
            $.ajax({
                url: '{{ URL::to("admin/products/attach/attribute/default/options/getOptionsValue")}}',
                type: "POST",
                data:  '_token=' + ("{{csrf_token()}}") +'&option_id=' + option_id + '&language_id=' + language_id,
                success: function (data) {
                    $('.products_options_values_id').html(data);
                },
            });
        }

        function getEditOptionsValue(option_id) {

            var language_id = $('.edit_language_id').val();
            $.ajax({
                url: '{{ URL::to("admin/products/attach/attribute/default/options/getOptionsValue")}}',
                type: "POST",
                data:  '_token=' + ("{{csrf_token()}}") +'&option_id=' + option_id + '&language_id=' + language_id,
                success: function (data) {
                    $('.edit-products_options_values_id').html(data);
                },
            });
        }


        function getAdditionalOptionsValue(option_id) {

            var language_id = $('.additional_language_id').val();
            $.ajax({
                url: '{{ URL::to("admin/products/attach/attribute/default/options/getOptionsValue")}}',
                type: "POST",
                data:  '_token=' + ("{{csrf_token()}}") +'&option_id=' + option_id + '&language_id=' + language_id,
                success: function (data) {
                    $('.additional_products_options_values_id').html(data);
                },
            });
        }


        function getEditAdditionalOptionsValue(option_id) {

            var language_id = $('.edit_additional_language_id').val();
            $.ajax({
                url: '{{ URL::to("admin/products/attach/attribute/default/options/getOptionsValue")}}',
                type: "POST",
                data:  '_token=' + ("{{csrf_token()}}") +'&option_id=' + option_id + '&language_id=' + language_id,
                success: function (data) {
                    $('.edit-additional-products_options_values_id').html(data);
                },
            });
        }

        //ajax call for add option value
        $(document).on('click', '.currentstock', function (e) {
            $("#loader").show();
            var options_id = $(this).attr('attributeid');
            var attributeid = $(this).val();
            $('.attributeid_' + options_id).val(attributeid);
            //alert('.attributeid_'+options_id);
            var formData = $('#addewinventoryfrom').serialize();
            $.ajax({
                url: '{{ URL::to("admin/products/attach/attribute/default/options/currentstock")}}',
                type: "POST",
                data: formData,
                dataType: "json",
                success: function (res) {
                    $("#loader").hide();
                    console.log(res);
                    $('#current_stocks').html(res.remainingStock);
                    //console.log(res.remainingStock);
                    var min_level = 0;
                    var max_level = 0;
                    var inventory_ref_id = res.inventory_ref_id;
                    var purchasePrice = res.purchasePrice;
                    var product_id = res.product_id;

                    if (res.minMax != '') {
                        min_level = res.minMax[0].min_level;
                        max_level = res.minMax[0].max_level;
                        var product_id = res.minMax[0].product_id;
                        $('.product_id').val(product_id);
                        $('#inventory_pro_id').val(product_id);

                    }

                    $('#min_level').val(min_level);
                    $('#product_id').val(product_id);
                    $('#max_level').val(max_level);
                    $('#inventory_ref_id').val(inventory_ref_id);
                    $('#inventory_pro_id').val(product_id);
                    $('#total_purchases').html(purchasePrice);

                },
            });
        });


        //ajax call for add option value
        $(document).on('click', '.add-value', function (e) {
            $("#loader").show();
            var parentFrom = $(this).parent('.addvalue-form');
            var language_id = parentFrom.children('#language_id').val();
            var products_options_id = parentFrom.children('#products_options_id').val();
            var formData = parentFrom.serialize();
            $.ajax({
                url: '{{ URL::to("admin/products/attributes/options/values/addattributevalue")}}',
                type: "POST",
                data: formData,
                success: function (res) {
                    $("#loader").hide();
                    $('.addError').hide();
                    $('#addAttributeModal').modal('hide');
                    $("#content_" + products_options_id + '_' + language_id).parent('tbody').html(res);
                },
            });

        });
        //ajax call for add option value
        $(document).on('click', '.update-value', function (e) {
            $("#loader").show();
            var parentFrom = $(this).parent('.editvalue-form');
            var language_id = parentFrom.children('#language_id').val();
            var products_options_id = parentFrom.children('#products_options_id').val();
            var formData = parentFrom.serialize();
            console.log('language_id: ' + language_id);
            console.log('products_options_id: ' + products_options_id);
            $.ajax({
                url: '{{ URL::to("admin/products/attributes/options/values/updateattributevalue")}}',
                type: "POST",
                data: formData,
                success: function (res) {
                    $("#loader").hide();
                    $('.addError').hide();

                    $("#content_" + products_options_id + '_' + language_id).parent('tbody').html(res);
                },
            });

        });
        //deleteattribute
        $(document).on('click', '#deleteAttribute', function (e) {
            $("#loader").show();
            var parentFrom = $('#deleteValue');
            var language_id = parentFrom.children('#delete_language_id').val();
            var products_options_id = parentFrom.children('#delete_products_options_id').val();
            var formData = parentFrom.serialize();
            $.ajax({
                url: '{{ URL::to("admin/products/attributes/options/values/delete")}}',
                type: "POST",
                data: formData,
                success: function (res) {
                    $('.addError').hide();
                    $("#loader").hide();
                    $("#content_" + products_options_id + '_' + language_id).parent('tbody').html(res);
                    $('#deleteValueModal').modal('hide');
                    location.reload();
                },
            });

        });

        //ajax call for submit value
        $(document).on('click', '#addAttribute', function (e) {
            $("#loader").show();
            var formData = $('#addattributefrom').serialize();
            $.ajax({
                url: '{{ URL::to("admin/products/attach/attribute/default/options/add")}}',
                type: "POST",
                data: formData,
                success: function (res) {
                    $("#loader").hide();

                    if (res.length != '') {
                        $('.addError').hide();
                        $('#addAttributeModal').modal('hide');
                        var i;
                        var showData = [];
                        for (i = 0; i < res.length; ++i) {
                            var j = i + 1;
                            showData[i] = "<tr><td>" + j + "</td><td>" + res[i].products_options_name + "</td><td>" + res[i].products_options_values_name + "</td><td>" + res[i].price_prefix + " " + res[i].options_values_price + "</td><td>    <a class='badge bg-light-blue editproductattributemodal' products_attributes_id = '" + res[i].products_attributes_id + "' product_id = '" + res[i].product_id + "'  language_id = '" + res[i].language_id + "' options_id= '" + res[i].options_id + "'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a> <a class='badge bg-red deleteproductattributemodal' products_attributes_id = '" + res[i].products_attributes_id + "' product_id = '" + res[i].product_id + "' ><i class='fa fa-trash' aria-hidden='true'></i></a></td></tr>";

                        }
                        $(".contentAttribute").html(showData);

                    } else {
                        $('.addError').show();
                    }
                },
            });
        });




    </script>
@endsection

