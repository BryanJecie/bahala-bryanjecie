@extends('frontend.layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <dashboard-index />
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection
