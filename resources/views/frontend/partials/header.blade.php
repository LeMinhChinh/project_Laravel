<header role="banner">
    <div class="top-bar">
        <div class="container">
        <div class="row">
            <div class="col-9 social">
                <a href="#"><span class="fa fa-twitter"></span></a>
                <a href="#"><span class="fa fa-facebook"></span></a>
                <a href="#"><span class="fa fa-instagram"></span></a>
                <a href="#"><span class="fa fa-youtube-play"></span></a>
                <a href="{{ route('switchLang',['lang' => 'vi']) }}"><span class="fa fa-language"></span>Vietnames</a>
                <a href="{{ route('switchLang',['lang' => 'en']) }}"><span class="fa fa-language"></span>English</a>
            </div>
            <form class="search-top-form">
                {{-- <button type="submit" class="icon fa fa-search btn btn-primary"></button> --}}
                <input type="text" id="s" placeholder="Type keyword to search..." name="s">
            </form>
            </div>
        </div>
        </div>
    </div>
    <div class="container" id="js-search" style="display:none">

    </div>
    <div class="container logo-wrap">
        <div class="row pt-5">
        <div class="col-12 text-center">
            <a class="absolute-toggle d-block d-md-none" data-toggle="collapse" href="#navbarMenu" role="button" aria-expanded="false" aria-controls="navbarMenu"><span class="burger-lines"></span></a>
            <h1 class="site-logo"><a href="{{ route('fr.home') }}">Lê Minh Chính Blog</a></h1>
        </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-md  navbar-light bg-light">
        <div class="container">
        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav mx-auto">
            @foreach ($view['treeCate'] as $key => $val)
                @if(empty($val['subCate']))
                <li class="nav-item">
                    <a class="nav-link active" href="#">{{ $val['name_cate'] }}</a>
                </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="dropdown-{{ $val['id'] }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $val['name_cate'] }}</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown-{{ $val['id'] }}">
                            @foreach ($val['subCate'] as $k => $v)
                                <a class="dropdown-item" href="{{ route('fr.categories',['slug' => Str::slug($v['name_cate'],'-'), 'id' => $v['id']]) }}">{{ $v['name_cate'] }}</a>
                            @endforeach
                        </div>
                        </li>
                @endif
            @endforeach
            </ul>
        </div>
        </div>
    </nav>
</header>
@push('scripts')
    <script>
        $(function(){
            $('#s').keyup(function(){
                var self = $(this);
                var timeout;
                clearTimeout(timeout);
                timeout = setTimeout(function(){
                    var keyword = self.val().trim();
                    if(keyword.length > 0){
                        $.ajax({
                            url: "{{ route('fr.ajaxSearch') }}",
                            type: "GET",
                            data: {key : keyword},
                            beforeSend:function(){
                                $('#js-search').hide();
                            },
                            success: function(data){
                                $('#js-search').html(data);
                                $('#js-search').show();
                            }
                        })
                    }
                },1000);
            });
        });
    </script>
@endpush
