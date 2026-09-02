<!DOCTYPE html>
<html lang="en">
<head>
	@php
    $favIcon = \App\Models\Setting::where('key','Site.fav_icon')->first();
    @endphp
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="description" content="meta description">
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <title>8Thniq Jewells Online Store</title>
   <link rel="shortcut icon" href="{{ env('WEBSITE_URL').'uploads/settings/'.@$favIcon->value }}" type="image/x-icon" />
   <link href="{{ asset('assets/front/8thniqjewells/assets/css/bootstrap.min.css')}}" rel="stylesheet">
   <link href="{{ asset('assets/front/8thniqjewells/assets/css/font-awesome.min.css')}}" rel="stylesheet">
   <link href="{{ asset('assets/front/8thniqjewells/assets/css/ionicons.min.css')}}" rel="stylesheet">
   <link href="{{ asset('assets/front/8thniqjewells/assets/css/helper.min.css')}}" rel="stylesheet">
   <link href="{{ asset('assets/front/8thniqjewells/assets/css/plugins.css')}}" rel="stylesheet">
   <link href="{{ asset('assets/front/8thniqjewells/assets/css/style.css')}}" rel="stylesheet">
   <link href="{{ asset('assets/front/8thniqjewells/assets/css/login.css')}}" rel="stylesheet">
</head>
<body>