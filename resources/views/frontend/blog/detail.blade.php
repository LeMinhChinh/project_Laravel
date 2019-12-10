@extends('frontend.master')

@section('title', $info['slug'])

@section('content')
    <div class="col-md-12 col-lg-8 main-content mt-3">
        <img src="{{ URL::to('/') }}/uploads/images/{{ $info['avatar'] }}" alt="Image" class="img-fluid mb-5">
        <div class="post-meta">
            <span class="author mr-2">{{ $info['fullname'] }}</span>&bullet;
            <span class="mr-2">{{ date('d/m/Y', strtotime($info['publish_date'])) }}</span> &bullet;
            <span class="ml-2"><span class="fa fa-comments"></span>{{ $info['count_view'] }}</span>
        </div>
        <h1 class="mb-4">{{ $info['title'] }}</h1>
        <a class="category mb-5" href="#">{{ $info['name_cate'] }}</a>

        <div class="post-content-body">
                {!! $info['content_web'] !!}
        </div>
        <div class="pt-5">
            <p>Tags:
                    @foreach ($lstTags as $key => $item)
                        <a href="">{{ $info['name_cate'] }}</a>
                        @if ($key < count($lstTags) - 1)
                            <span>,</span>
                        @endif
                    @endforeach
                </p>
        </div>

        {{-- Comment --}}
        <div class="fb-comments" data-width="" data-numposts="5"></div>
    </div>
@endsection

@section('related-post')
    <section class="py-5">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <h2 class="mb-3 ">Related Post</h2>
            </div>
          </div>
          <div class="row">
                @foreach ($related as $item)
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ route('fr.detailBlog',['slug' => $item['slug']]) }}" class="a-block sm d-flex align-items-center height-md" style="background-image: url('{{ URL::to('/') }}/uploads/images/{{ $item['avatar'] }}'); ">
                          <div class="text">
                            <div class="post-meta">
                              <span class="category">{{ $item['fullname'] }}</span>
                              <span class="mr-2">{{ date('d/m/Y', strtotime($item['publish_date'])) }}</span> &bullet;
                              <span class="ml-2"><span class="fa fa-comments"></span>{{ $item['count_view'] }}</span>
                            </div>
                            <h3>{{ $item['title'] }}</h3>
                          </div>
                        </a>
                    </div>
                @endforeach
          </div>
        </div>
      </section>
@endsection

@push('scripts')
    <script>
        $(function(){
            var idPost = "{{ $info['id'] }}";
            $.ajax({
                url : "{{ route('fr.updateCountView') }}",
                type : 'POST',
                data : {id: idPost},
                success: function(res){
                    res = $.trim(res);
                    if(res === 'OK'){
                        console.log('Ok');
                    }else{
                        console.log("Err");
                    }
                }
            });
        });
    </script>
@endpush
