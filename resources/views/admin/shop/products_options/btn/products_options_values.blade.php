<ul class="list-unstyled">
    @foreach($row->optionsValues as $op)
        <li style="padding: 5px;">
            <a style="color: #5a738e;"> {{$op->products_options_values_name}}</a>
                <a name="edit" id="{{$row->products_options_id}}"
                   data-option_name="{{$row->products_options_name}}"
                   data-option_val_id="{{$op->products_options_values_id}}"
                   data-option_val_name="{{$op->products_options_values_name}}"
                   data-option_id="{{$row->products_options_id}}"
                   class="edit_option_val  btn-sm"><span
                        class='glyphicon glyphicon-pencil'></span></a>
                <a name="delete" id="{{$op->products_options_values_id}}"
                   data-option_val_id="{{$op->products_options_values_id}}"
                   data-type="option_value"
                   class="delete  btn-sm">
                    <span class='glyphicon glyphicon-trash'> </span></a>


        </li>
    @endforeach

    <li><a style="color: #5a738e;" class="newOption_val" data-option_name="{{$row->products_options_name}}"
           data-option_id="{{$row->products_options_id}}"> اضافة خيار جديد <i
                class="fa fa-plus"> </i></a></li>
</ul>
