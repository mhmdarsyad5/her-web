@extends('frontend.layouts.app')

@section('title', 'Beranda - ' . strip_tags(setting('site_name', 'her.co.id')))

@section('content')

    {{-- Hero Section --}}
    @include('frontend.pages.home.sections.hero')

    {{-- Rental Steps Section --}}
    {{-- @include('frontend.pages.home.sections.rental_steps') --}}

    {{-- Product Section --}}
    @include('frontend.pages.home.sections.product')

    {{-- Section lainnya --}}
    @include('frontend.pages.home.sections.dss')
    @include('frontend.pages.home.sections.service')
    @include('frontend.pages.home.sections.customer')
    <!-- @include('frontend.pages.home.sections.abouts') -->
    @include('frontend.pages.home.sections.page')
    @include('frontend.pages.home.sections.contactmessage')

@endsection