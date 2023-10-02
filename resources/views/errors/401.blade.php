@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '401')
@section('message', __($exception->getMessage() ?: 'Forbidden'))
