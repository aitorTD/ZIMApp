@extends('layouts.admin')

@section('title', $title ?? config('app.name') . ' - Admin')

@section('content')
    {{ $slot }}
@endsection
