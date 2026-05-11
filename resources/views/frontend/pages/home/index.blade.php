@extends('frontend.layouts.app')

@section('title', 'Beranda - ' . strip_tags(setting('site_name', 'mulaidigital.com')))

@section('content')

{{-- Hero Section --}}
@include('frontend.pages.home.sections.hero')

{{-- Section lainnya --}}
@include('frontend.pages.home.sections.service')
@include('frontend.pages.home.sections.dss', compact('locations', 'industries', 'cargoTypes', 'weights', 'heights', 'aisles', 'energies', 'units', 'operators'))
@include('frontend.pages.home.sections.product')
@include('frontend.pages.home.sections.abouts')
@include('frontend.pages.home.sections.page')
@include('frontend.pages.home.sections.contactmessage')

@endsection
