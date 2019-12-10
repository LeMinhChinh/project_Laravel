<div class="sidebar-box">
        <h3 class="heading mt-3">@lang('common.latest-posts')</h3>
        <div class="post-entry-sidebar">
          <ul>
              @foreach ($view['popularPost'] as $item)
                <li>
                    <a href="{{ route('fr.detailBlog',['slug' => $item['slug']]) }}">
                        <img src="{{ URL::to('/') }}/uploads/images/{{ $item['avatar'] }}" alt="Image placeholder" class="mr-4">
                        <div class="text">
                        <h4>{{ $item['title'] }}</h4>
                        <div class="post-meta">
                            <span class="mr-2">{{ date('d/m/Y', strtotime($item['publish_date'])) }}</span>
                        </div>
                        </div>
                    </a>
                </li>
                @endforeach
          </ul>
        </div>
      </div>
