@extends('frontend.master')

@section('title','category - ' .$slug)
@section('content')
    <div class="col-md-12 col-lg-8 main-content">
        <div class="row mb-5 mt-5">
          <div class="col-md-12">
            @foreach ($mainCate as $item)
                <div class="post-entry-horzontal">
                    <a href="{{ route('fr.detailBlog', ['slug' => $item['slug']]) }}">
                      <div class="image element-animate" data-animate-effect="fadeIn" style="background-image: url({{ URL::to('/') }}/uploads/images/{{ $item['avatar'] }});"></div>
                      <span class="text">
                        <div class="post-meta">
                          <span class="author mr-2">{{ $item['fullname'] }}</span>&bullet;
                          <span class="mr-2">{{ date('d/m/Y', strtotime($item['publish_date'])) }}</span> &bullet;

                          <span class="ml-2"><span class="fa fa-comments"></span>{{ $item['count_view'] }}</span>
                        </div>
                        <h2>{{ $item['title'] }}</h2>
                      </span>
                    </a>
                </div>
            @endforeach
          </div>
        </div>

        <div class="row mt-5">
          <div class="col-md-12 text-center">
            {{ $paginate->links() }}
          </div>
        </div>
      </div>
@endsection
