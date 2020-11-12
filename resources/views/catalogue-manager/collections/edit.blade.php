@extends('hub::layout', [
    'title' => 'Edit Collection',
])

@section('side_menu')
    @include('hub::catalogue-manager.partials.side-menu')
@endsection

@section('header_title')
    <small>Manajer Katalog</small>
    <h1>@verbatim<template v-if="title">{{ title }}</template>@endverbatim</h1>
@endsection

@section('header_actions')
    <candy-delete
      element="collection"
      endpoint="/collections/{{ $id }}"
      id="{{ $id }}"
      redirect="/{{ config('getcandy.hub_prefix', 'hub') }}/catalogue-manager/occasions"
      style="display: inline-block;"
    ></candy-delete>
    <candy-button style="display: inline-block;" event="save-collection">Simpan Occasion</candy-button>
@endsection

@section('content')
  <candy-collection-edit id="{{ $id }}"></candy-collection-edit>
@endsection