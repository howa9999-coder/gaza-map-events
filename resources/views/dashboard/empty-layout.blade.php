<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/x-icon" href="/dashboard-favicon.png">

    @yield('meta')

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ isset($page_title) ? $page_title : config('app.name', 'Laravel') . ' | ' . __('Dashboard') }}</title>
    <meta name="title" content="CES CONTENT">
    <meta name="author" content="Walid Isa">
    <meta name="description" content="CES CONTENT">
    <meta name="keywords" content="CES CONTENT" />
    <link rel="canonical" href="CES MAIN PAGE">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="CES CONTENT">
    <meta property="og:title" content="CES CONTENT TITLE">
    <meta property="og:description" content="CES CONTENT">
    <meta property="og:image" content="CES CONTENT">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="CES CONTENT">
    <meta property="twitter:title" content="CES CONTENT TITLE">
    <meta property="twitter:description" content="CES CONTENT">
    <meta property="twitter:image" content="CES CONTENT">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="120x120" href="../../assets/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../../assets/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="../../assets/images/favicon/site.webmanifest">
    <link rel="mask-icon" href="../../assets/images/favicon/safari-pinned-tab.svg" color="{{ __('ffffff') }}">
    <meta name="msapplication-TileColor" content="{{ __('ffffff') }}">
    <meta name="theme-color" content="{{ __('ffffff') }}">

    @yield('header')

  </head>

  <body class="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

    @yield('page')

  </body>

</html>
