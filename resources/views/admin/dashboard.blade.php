@extends('admin.layout')

@section('content')
    <h1>Dashboard</h1>
    <p>Usuario Autentificado: {{ auth()->user()->email }}</p>
@stop
