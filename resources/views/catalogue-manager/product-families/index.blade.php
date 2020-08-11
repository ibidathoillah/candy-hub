@extends('hub::layout', [
    'title' => 'Brands',
])

@section('side_menu')
    @include('hub::catalogue-manager.partials.side-menu')
@endsection

@section('header_title')
    <small>Manajer Katalog</small>
    <h1>Brands</h1>
@endsection

@section('header_actions')
    <candy-product-family-create></candy-product-family-create>
@stop

@section('content')
    <candy-product-families-table></candy-product-families-table>
@endsection