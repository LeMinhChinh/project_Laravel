@extends('admin.layout')

@section('title', "This is update Posts")

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
        <li class="breadcrumb-item active">Update Post</li>
    </ol>
    <div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            <h3>Update Post</h3>
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



    <form action="{{ route('admin.handleUpdatePost',['id' => $info['id']]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <label for="titlePost">Title (*)</label>
                    <input type="text" class="form-control" id="titlePost" name="titlePost" value="{{ $info['title'] }}">
                </div>
                <div class="form-group">
                    <label for="sapoPost">Sapo (*)</label>
                    <textarea type="text" class="form-control" id="sapoPost" name="sapoPost" rows="5">{!! $info['sapo'] !!}</textarea>
                </div>
                <div class="form-group">
                    <p><img src="{{ URL::to('/')}}/uploads/images/{{ $info['avatar'] }}" alt="{{ $info['title'] }}" width="120" height="120" class="img-fluid"></p>
                    <label for="avatarPost">Avatar (*) </label>
                    <input type="file" class="form-control" id="avatarPost" name="avatarPost">
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <label for="languagePost">Language</label>
                    <select type="text" class="form-control" id="languagePost" name="languagePost">
                        <option value="">--- Choose Language ---</option>
                        <option value="1" {{ $info['lang_id'] == 1 ? 'selected=selected' : '' }}>Vietnamese</option>
                        <option value="2" {{ $info['lang_id'] == 2 ? 'selected=selected' : '' }}>English</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="categoryPost">Category (*)</label>
                    <select type="text" class="form-control" id="categoryPost" name="categoryPost">
                        @foreach ($cates as $key => $item)
                            <option value="{{ $item['id'] }}" {{ $info['categories_id'] == $item['id'] ? 'selected=selected' : '' }}>{{ $item['name_cate'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="publishdatePost">Publish date</label>
                    <input type="text" name="publishdatePost" id="publishdatePost" class="form-control" value="{{ $info['publish_date'] }}">
                </div>
                <div class="form-group">
                    <label for="tagsPost">Tags (*)</label>
                    <select name="tagsPost[]" id="tagsPost" class="form-control js-multi-tag" multiple="multiple">
                        @foreach ($tags as $key => $item)
                            <option {{ in_array($item['id'], $arrIdTags) ? 'selected=selected' : '' }} value="{{ $item['id'] }}">{{ $item['name_tag'] }}</option>
                        @endforeach
                    </select>
                </div>
                {{-- chon status --}}
                <div class="form-group">
                    <label for="statusPost">Status (*)</label>
                    <select name="statusPost" id="statusPost" class="form-control">

                            <option {{ $info['status'] == 0 ? 'selected=selected' : '' }} value="0">Deactive</option>
                            <option {{ $info['status'] == 1 ? 'selected=selected' : '' }} value="1">Active</option>

                    </select>
                </div>
                <button class="btn btn-primary" type="submit">Update post</button>
                <button class="btn btn-secondary" type="submit">Cancel</button>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="contentPost">Content (*)</label>
                    <textarea type="text" class="form-control" id="contentPost" name="contentPost" rows="8">{!! $info['content_web'] !!}</textarea>
                </div>
            </div>
        </div>
    </form>
@endsection
