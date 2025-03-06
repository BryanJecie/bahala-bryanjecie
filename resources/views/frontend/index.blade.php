@extends('frontend.layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">


                <main-index />
                {{-- <x-frontend.card>
                    <x-slot name="header">
                        @lang('List of Purchases')
                    </x-slot>

                    <x-slot name="body">
                        @lang('You are logged in!')
                    </x-slot>
                </x-frontend.card> --}}
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection
