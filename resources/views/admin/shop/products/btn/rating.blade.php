<p> عدد المقيمين :
    @if($count_rating==0)
        {{round($count_rating)}}
    @else
        <a href="{{route('admin.shop.products.ratings.index',$id)}}"> {{round($count_rating)}}</a>
    @endif
</p>
<div class="ratingDiv">
    @for($i=1;$i<6;$i++)
        <span class="fa fa-star @if(round($average_rating)>=$i) checked @endif "></span>
    @endfor
</div>
<p> متوسط التقييم : {{round($average_rating)}} </p>


