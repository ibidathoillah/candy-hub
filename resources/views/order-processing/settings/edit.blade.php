@extends('hub::layout')

@section('side_menu')
    @include('hub::order-processing.partials.side-menu')
@endsection

@section('header_title')
    <small>Pengaturan</small>
    <h1>@verbatim<template v-if="title">{{ title }}</template>@endverbatim</h1>
@endsection

@section('header_actions')
@stop


@section('content')
    <candy-settings-edit id="{{ $id }}"></candy-settings-edit>
@endsection
