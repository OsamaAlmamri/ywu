@extends('adminpanel.master')
@section('content')
    <div class="right_col" role="main">
        <div class="row tile_count">
            <div style="font-weight: bold"><b>صلاحيات النظام</b></div>
            <br>

        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">

            <div class="page-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5> @if(isset($role))   {{trans('permissions.role.update')}}  {{$role->name}} @else {{trans('permissions.role.new')}}  @endif </h5>
                            </div>
                            <div class="card-block">
                                <div class="j-wrapper ">
                                    @if(isset($role))
                                        {!! Form::model($role, ['route' => ['admin.permissions.update', $role->id], 'method' => 'put','class'=>'j-pro','id' => 'j-pro', 'files' => true]) !!}
                                    @else
                                        {!! Form::open(['role' => 'form', 'route' => 'admin.permissions.store', 'class'=>'j-pro','id' => 'j-pro', 'method' => 'post', 'files' => true]) !!}
                                    @endif

                                    <div class="j-content">

                                        <!-- start name -->
                                        <div class="j-unit">
                                            <div class="accordion" id="accordionExample">

                                                <label> <input type="checkbox"
                                                               id="select_all"/> {{trans('permissions.role.selectAll')}}
                                                </label>

                                                @foreach($permissions as $k => $sub_permission)
                                                    <div class="card">


                                                        <div class="card-header" id="headingOne">
                                                            <h6 class="mb-0" style="font-size: 16px">
                                                                <input type="checkbox" class="selectGroup"
                                                                       data-id="{{$k}}"
                                                                       onclick="selectSub($(this),'{{$k}}')"
                                                                       data-selected="0"/> {{trans('permissions.role.selectAllFor')}} {{$k}}
                                                                <a data-toggle="collapse" data-target="#{{$k}}"
                                                                   aria-expanded="true" aria-controls="collapseOne">
                                                                    <i style="font-size: 18px"
                                                                       class="fa fa-plus-square primary_site_color"></i>
                                                                </a>

                                                            </h6>
                                                        </div>
                                                        <div id="{{$k}}" class="collapse "
                                                             aria-labelledby="headingOne"
                                                             data-parent="#accordionExample">
                                                            <div class="card-body">
                                                                <label
                                                                    class="col-md-3 col-sm-3 col-xs-12 control-label">

                                                                    <br>
                                                                </label>

                                                                <div class="form-group row" style="padding-bottom: 19px;
    margin-top: -20px;">

                                                                    @foreach ($sub_permission as $k_sub => $permission)
                                                                        @if (
                                                                               ( ($permission->name=="manage products")
                                                                                or ($permission->name=="manage products_questions")
                                                                                or ($permission->name=="show products_questions")
                                                                                or ($permission->name=="show products")
                                                                                 )
                                                                                )
                                                                            @if  (auth()->user()->getRoleNames()->first() === 'Developer')
                                                                                <div
                                                                                    class=" col-md-4 col-sm-6 col-xs-12">
                                                                                    <div class=" radio-inline">
                                                                                        <label>
                                                                                            <input type="checkbox"
                                                                                                   name="permissions[]"
                                                                                                   @if(in_array($permission->id, $oldRolePermission))
                                                                                                   checked
                                                                                                   @endif
                                                                                                   class=" selectAll select-message{{$k}}"
                                                                                                   value="{{$permission->id}}"> {{$permission->name}}
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            @endif

                                                                        @else
                                                                            <div
                                                                                class=" col-md-4 col-sm-6 col-xs-12">
                                                                                <div class=" radio-inline">
                                                                                    <label>
                                                                                        <input type="checkbox"
                                                                                               name="permissions[]"
                                                                                               @if(in_array($permission->id, $oldRolePermission))
                                                                                               checked
                                                                                               @endif
                                                                                               class=" selectAll select-message{{$k}}"
                                                                                               value="{{$permission->id}}"> {{$permission->name}}
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                    @endif
                                                                @endforeach
                                                                <!--                        @error('categories') <span class="btn-block badge badge-danger">{{ $message }}</span> @enderror-->

                                                                </div>

                                                            </div>
                                                        </div>

                                                    </div>

                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end name -->
                                </div>
                                <!-- end /.content -->
                                <div class="j-footer">
                                    <button type="submit" class="btn btn-primary">حفظ</button>
                                </div>
                                <!-- end /.footer -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('scripts')
    <!-- Custom js -->
    <script>
        $(document).on('click', '#select_all', function () {
            if (this.checked) {
                // Iterate each checkbox
                $('input:checkbox.selectAll').each(function () {
                    this.checked = true;
                });

                $('input:checkbox.selectGroup').each(function () {
                    // alert($(this).attr('data-id'))
                    this.checked = true;
                });

            } else {
                $('input:checkbox.selectAll').each(function () {
                    this.checked = false;
                });
                $('input:checkbox.selectGroup').each(function () {
                    this.checked = false;
                });
            }
        });

        function selectSub(e, id) {
            if (e.attr('data-selected') == 0) {
                // Iterate each checkbox
                $('input:checkbox.select-message' + id).each(function () {
                    this.checked = true;
                    e.attr('data-selected', 1);
                });

            } else {
                $('input:checkbox.select-message' + id).each(function () {
                    this.checked = false;
                    e.attr('data-selected', 0)
                });
            }
        }

    </script>
@endsection

