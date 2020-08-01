@extends('hub::layout')

@section('side_menu')
    @include('hub::order-processing.partials.side-menu')
@endsection

@section('header_title')
    <small>Settings</small>
    <h1>Settings</h1>
@endsection

@section('header_actions')
    <candy-settings-create style="display: inline-block;"></candy-settings-create>
@endsection

@section('content')
    <candy-settings-table></candy-settings-table>
@endsection
