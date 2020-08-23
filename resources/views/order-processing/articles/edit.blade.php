@extends('hub::layout')

@section('side_menu')
    @include('hub::order-processing.partials.side-menu')
@endsection

@section('header_title')
    <small>Artikel</small>
    <h1>@verbatim<template v-if="title">{{ title }}</template>@endverbatim</h1>
@endsection

@section('header_actions')
    <candy-button style="display: inline-block;" override="save">Simpan</candy-button>
    @verbatim<candy-button style="display: inline-block;" :override="status">{{status}}</candy-button>@endverbatim
@stop


@section('content')
    <candy-article-edit id="{{ $id }}"></candy-article-edit>
@endsection
