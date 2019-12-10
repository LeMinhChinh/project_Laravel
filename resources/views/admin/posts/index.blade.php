{{-- Extend file layout--}}
@extends('admin.layout')

@section('title', "This is Posts")

{{-- đẩy sang file layout cha --}}

@section('content')
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">Posts</a>
        </li>
        <li class="breadcrumb-item active">Overview</li>
    </ol>
    <div class="row">
        @if($createPostSuccess)
            <div class="alert alert-danger my-3">
                <h6>{{ $createPostSuccess }}</h6>
            </div>
        @endif
        @if($updatePostSuccess)
        <div class="alert alert-danger my-3">
            <h6>{{ $updatePostSuccess }}</h6>
        </div>
        @endif
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <a href="{{ route('admin.createPost') }}" class="btn btn-primary">Create post</a>
                    <a href="{{ route('admin.posts') }}" class="btn btn-primary">View All</a>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Searching..." id="js-keyword" value="{{ $keyword }}">

                            <div class="input-group-append">
                                <button class="input-group-text" id="js-search">Search</button>
                            </div>
                        </div>
                </div>
            </div>


            <table class="table table-border table-striped table-hover mt-2">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Tags</th>
                        <th>Author</th>
                        <th>Publish Date</th>
                        <th>Count View</th>
                        <th colspan="2" width="5%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lstPosts as $key => $post)
                        <tr class="js-post-{{ $post['id'] }}">
                            <td>{{ $post['id'] }}</td>
                            <td>
                                <img src="{{ URL::to('/') }}/uploads/images/{{ $post['avatar'] }}" alt="{{ $post['title'] }}" width="120" height="120" class="img-fluid">
                            </td>
                            <td>
                                <h5>{{ $post['title'] }}</h3>
                                <div class="my-2">{!! $post['sapo'] !!}</div>
                            </td>
                            <td>
                                <p>{{ $post['name_cate'] }}</p>
                            </td>
                            <td>
                                @if($post['lstTags'])
                                    @foreach ($post['lstTags'] as $item)
                                        <p class="border-bottom">{!! $item !!}</p>

                                    @endforeach
                                @endif
                            </td>
                            <td>
                                <p>{{ $post['fullname'] }}</p>
                            </td>
                            <td>
                                <p>{{ $post['publish_date'] }}</p>
                            </td>
                            <td>
                                <p>{{ $post['count_view'] }}</p>
                            </td>
                            <td>
                                <button id="{{ $post['id'] }}" class="btn btn-sm btn-danger js-delete-post">Delete</button>
                            </td>
                            <td>
                                <a href="{{ route('admin.editPost',['slug' => $post['slug'], 'id' => $post['id']]) }}" class="btn btn-info btn-sm">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $paginate->appends(request()->query())->links() }}
            {{-- {{ $paginate->links() }} --}}
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function(){
            $('.js-delete-post').click(function(){
                var self = $(this);
                var idPost = self.attr('id').trim();
                if($.isNumeric(idPost)){
                    $.ajax({
                        url: "{{ route('admin.deletePost') }}",
                        type: "POST",
                        data: {id: idPost},
                        beforeSend: function(){
                            self.text('Loading ...');
                        },
                        success: function(data){
                            self.text('Delete');
                            if(data === 'Err' || data === 'Fail'){
                                alert('Co loi xay ra');
                            }else{
                                $('.js-post-'+idPost ).hide();
                                alert('Success');
                            }
                        }
                    });
                }
            });

            $('#js-search').click(function(){
                var keyword = $('#js-keyword').val().trim();
                if(keyword.length > 0){
                    window.location.href =  "{{ route('admin.posts') }}" + "?keyword=" + keyword;
                }
            });
        });


    </script>
@endpush
