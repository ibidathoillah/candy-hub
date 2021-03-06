@extends('hub::layout', [
    'title' => 'Attribute Groups',
])
@section('side_menu')
    @include('hub::catalogue-manager.partials.side-menu')
@endsection

@section('header_title')
    <small>Manajer Katalog</small>
    <h1>Atribut Grup</h1>
@endsection

@section('header_actions')
    <candy-attribute-group-create></candy-attribute-group-create>
@stop

@section('content')
    <candy-attribute-groups-table></candy-attribute-groups-table>
@endsection