{{-- Extend file layout--}}
@extends('admin.layout')

@section('title', "This is tags")

{{-- đẩy sang file layout cha --}}

@section('content')
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">Tags</a>
        </li>
        <li class="breadcrumb-item active">Overview</li>
    </ol>
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
            <h2>This is Tags</h2>
        </div>
    </div>
@endsection
