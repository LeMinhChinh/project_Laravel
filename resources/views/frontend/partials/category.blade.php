<div class="sidebar-box">
        <h3 class="heading">@lang('common.categories')</h3>
        <ul class="categories">
          @foreach ($view['catePost'] as $key => $value)
            <li><a href="#">{{ $value['name_cate'] }} <span>({{ count($value['list_post']) }})</span></a></li>
          @endforeach
        </ul>
      </div>
