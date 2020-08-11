@extends('hub::layout', [
    'title' => 'Attributes',
])

@section('side_menu')
    @include('hub::catalogue-manager.partials.side-menu')
@endsection

@section('header_title')
    <small>Manajer Katalog</small>
    <h1>Attributes</h1>
@endsection

@section('header_actions')
    <candy-attribute-create></candy-attribute-create>
@stop

@section('content')
    <candy-attributes-table></candy-attributes-table>
@endsection