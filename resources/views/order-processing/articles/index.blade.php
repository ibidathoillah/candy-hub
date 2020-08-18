@extends('hub::layout')

@section('side_menu')
    @include('hub::order-processing.partials.side-menu')
@endsection

@section('header_title')
    <small>Artikel</small>
    <h1>List Artikel</h1>
@endsection

@section('header_actions')
    <candy-article-create style="display: inline-block;"></candy-article-create>
@endsection

@section('content')
    <candy-articles-table></candy-articles-table>
@endsection
