@extends('hub::layout', [
    'title' => 'Occassion',
])
@section('side_menu')
    @include('hub::catalogue-manager.partials.side-menu')
@endsection

@section('header_title')
    <small>Manajer Katalog</small>
    <h1>Occassion</h1>
@endsection

@section('header_actions')
    <candy-collection-create style="display: inline-block;"></candy-collection-create>
@endsection

@section('content')
    <candy-collections-table></candy-collections-table>
@endsection