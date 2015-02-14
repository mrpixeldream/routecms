<!DOCTYPE html>
<html dir="ltr" lang="{$country}">
<head>
    <title>{option option="page_title"} - {lang $title}</title>
    <base href="{@$baseHref}">
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="css/foundation.css"/>
    <link rel="stylesheet" href="css/style.css"/>
    {if $template == 'login' || $template == 'errorLogin'}
        <link rel="stylesheet" href="css/login.css"/>
    {/if}
    <link rel="stylesheet" href="css/foundation-icons.css"/>
    <link rel="stylesheet" href="css/normalize.css"/>
    <script src="js/vendor/modernizr.js"></script>
    <link rel="apple-touch-icon" sizes="57x57" href="apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="60x60" href="apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="120x120" href="apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="76x76" href="apple-touch-icon-76x76.png">
    <link rel="icon" type="image/png" href="favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="favicon-32x32.png" sizes="32x32">
    <meta name="msapplication-TileColor" content="#5096cc">
    <meta name="msapplication-TileImage" content="mstile-144x144.png">
</head>
<body>
<div id="main" role="main">
    <a id="top"></a>
