@extends('adminpanel.master')
@section('content')
    <div class="right_col" role="main">
        <div class="container">
            <div class="card">
                @yield('card_header')
                <div class="card-footer">
                    <br>
                    <table class="table table-striped table-hover table table-bordered" id="user_table">
                    </table>
                </div>
            </div>

        </div>
    </div>
    @yield('models')
@endsection
@section('scripts')
    <script>
        var lang={
                lengthMenu: "Show _MENU_ Entries",
                sSearch: '{{trans('dataTable.sSearch')}}',
                info: "Showing _START_ to _END_ of _TOTAL_ Entries",
                sEmptyTable: '{{ trans('dataTable.sEmptyTable')}}',
                sInfo: '{{ trans('dataTable.sInfo')}}',
                sInfoEmpty: '{{ trans('dataTable.sInfoEmpty')}}',
                sInfoFiltered: '{{ trans('dataTable.sInfoFiltered')}}',
                sInfoPostFix: '{{ trans('dataTable.sInfoPostFix')}}',
                sLengthMenu: '{{ trans('dataTable.sLengthMenu')}}',
                sInfoThousands: '{{ trans('dataTable.sInfoThousands')}}',
                sLoadingRecords: '{{ trans('dataTable.sLoadingRecords')}}',
                sProcessing: '{{ trans('dataTable.sProcessing')}}',
                sZeroRecords: '{{ trans('dataTable.sZeroRecords')}}',
                sSearch: '{{ trans('dataTable.sSearch')}}',
                oPaginate: {
                    sNext: '{{ trans('dataTable.sNext')}}',
                    sPrevious: '{{ trans('dataTable.sPrevious')}}',
                    sFirst: '{{ trans('dataTable.sFirst')}}',
                    sLast: '{{ trans('dataTable.sLast')}}',
                },
                oAria: {
                    sSortAscending: '{{ trans('dataTable.sSortAscending')}}',
                    sSortDescending: '{{ trans('dataTable.sSortDescending')}}',
                },
            };
    </script>
    @yield('custom_js')
@endsection
