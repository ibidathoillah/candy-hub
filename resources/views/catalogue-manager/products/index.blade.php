@extends('hub::layout', [
    'title' => 'Products',
])

@section('side_menu')
    @include('hub::catalogue-manager.partials.side-menu')
@endsection

@section('header_title')
    <small>Manajer Katalog</small>
    <h1>Produk</h1>
@endsection

@section('header_actions')
    <candy-product-create style="display: inline-block;"></candy-product-create>
@endsection

@section('content')
  <candy-products-table></candy-products-table>
@endsection