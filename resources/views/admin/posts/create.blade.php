@extends('admin.layout')

@section('title', "This is create Posts")

@push('stylesheet')
    <link rel="stylesheet" href="{{ asset('admin/css/jquery.datetimepicker.min.css') }}">

    {{-- <link rel="stylesheet" href="{{ asset('admin/css/multiple-select.min.css') }}"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.css">
@endpush

@push('scripts')
    <script type="text/javascript" src="{{ asset('admin/js/posts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/js/jquery.datetimepicker.js') }}"></script>
    {{-- <script type="text/javascript" src="{{ asset('admin/js/multiple-select.min.js') }}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>

    <script type="text/javascript">
        $(function(){
            $('#publishdatePost').datetimepicker({
                format:'d-m-Y H:m:s',
            });
            $(".js-multi-tag").select2();
        })
    </script>
@endpush

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.posts') }}">List Posts</a>
        </li>
        <li class="breadcrumb-item active">Create Post</li>
    </ol>
    <div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            <h3>Create Post</h3>
        </div>
    </div>
    <hr>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($errorPublishDate)
        <div class="alert alert-danger">
            <span>{{ $errorPublishDate }}</span>
        </div>
    @endif

    @if ($errorAvatar)
        <div class="alert alert-danger">
            <span>{{ $errorAvatar }}</span>
        </div>
    @endif

    <form action="{{ route('admin.handleCreatePost') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <label for="titlePost">Title (*)</label>
                    <input type="text" class="form-control" id="titlePost" name="titlePost">
                </div>
                <div class="form-group">
                    <label for="sapoPost">Sapo (*)</label>
                    <textarea type="text" class="form-control" id="sapoPost" name="sapoPost" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <label for="avatarPost">Avatar (*) </label>
                    <input type="file" class="form-control" id="avatarPost" name="avatarPost">
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <label for="languagePost">Language</label>
                    <select type="text" class="form-control" id="languagePost" name="languagePost">
                        <option value="">--- Choose Language ---</option>
                        <option value="1">Vietnamese</option>
                        <option value="2">English</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="categoryPost">Category (*)</label>
                    <select type="text" class="form-control" id="categoryPost" name="categoryPost">
                        @foreach ($cates as $key => $item)
                            <option value="{{ $item['id'] }}">{{ $item['name_cate'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="publishdatePost">Publish date</label>
                    <input type="text" name="publishdatePost" id="publishdatePost" class="form-control">
                </div>
                <div class="form-group">
                    <label for="tagsPost">Tags (*)</label>
                    <select name="tagsPost[]" id="tagsPost" class="form-control js-multi-tag" multiple="multiple">
                        @foreach ($tags as $key => $item)
                            <option value="{{ $item['id'] }}">{{ $item['name_tag'] }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-primary" type="submit">Publish post</button>
                <button class="btn btn-secondary" type="submit">Cancel</button>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="contentPost">Content (*)</label>
                    <textarea type="text" class="form-control" id="contentPost" name="contentPost" rows="8"></textarea>
                </div>
            </div>
        </div>
    </form>
@endsection
