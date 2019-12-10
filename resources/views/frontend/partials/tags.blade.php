<div class="sidebar-box">
        <h3 class="heading">@lang('common.tags')</h3>
        <ul class="tags">
            @foreach ($view['lstTag'] as $item)
                <li><a href="#">{{ $item['name_tag'] }}</a></li>
            @endforeach
        </ul>
      </div>
