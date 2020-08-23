@extends('hub::layout')

@section('side_menu')
    @include('hub::order-processing.partials.side-menu')
@endsection

@section('header_title')
    <small>Artikel</small>
    <h1>@verbatim<template v-if="title">{{ title }}</template>@endverbatim</h1>
@endsection

@section('header_actions')
    <candy-button class="btn btn-warning" style="display: inline-block;" override="delete">Hapus</candy-button>
    <candy-button style="display: inline-block;" override="save">Simpan</candy-button>
    @verbatim<candy-button style="display: inline-block;" v-if="status== 'Unpublish'" override="Unpublish">{{status}}</candy-button><candy-button style="display: inline-block;" v-if="status== 'Publish'" override="Publish">{{status}}</candy-button>@endverbatim
@stop


@section('content')
    <candy-article-edit id="{{ $id }}"></candy-article-edit>
@endsection
