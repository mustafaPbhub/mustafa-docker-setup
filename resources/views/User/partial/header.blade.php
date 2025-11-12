@php
     $currentDomain = Illuminate\Support\Facades\Request::getHost();
@endphp
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="title" content="{!! config('metatags.meta_title') ?? "" !!}">
<meta name="description" content="{!!config('metatags.meta_description') ?? "" !!}">
<meta name="keywords" content="{!! config('metatags.meta_keywords') ?? "" !!}" />
<title> {!! config('metatags.meta_title') ?? "" != null ? config('metatags.meta_title') ?? "" : '' !!}
</title>
<meta name="linkbuxverifycode" content="32dc01246faccb7f5b3cad5016dd5033" />
<meta name="lhverifycode" content="32dc01246faccb7f5b3cad5016dd5033" />
<meta name="influencerrate-verification" content="21a3e1d6f5b4bfbf5b07c275a2d57093" />
<meta name="fo-verify" content="56af566a-f114-45e5-93e3-91ba267dee2d" />
<link rel="shortcut icon" href="{{ config('setting.site_favicon') }}" type="image/x-icon">


   <!-- og tags -->
    <meta property="og:title" content="{!! config('metatags.meta_title') ?? '' !!}" />
    <meta property="og:description" content="{!! config('metatags.meta_description') ?? '' !!}" />
    <meta property="og:locale" content="en_GB" />
    <meta property="og:type" content="{!! config('metatags.meta_type') ?? 'website' !!}" />
    <meta property="og:image" content="{!! url(config('metatags.meta_image')) ?? '' !!}" />
    <meta property="og:image:alt" content="{!! config('metatags.meta_alt') ?? '' !!}" />
    <meta property="og:url" content="{!! url()->current() !!}" />
    <!-- Twitter Card Meta Tags -->
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content="{!! config('metatags.meta_title') ?? '' !!}">
        <meta name="twitter:description" content="{!! config('metatags.meta_description') ?? '' !!}" />
        <meta name="twitter:image:src" content="{!! url(config('metatags.meta_image')) ?? '' !!}">
        <meta name="twitter:site" content="{!! '@' . $currentDomain ?? '' !!}">
        <meta name="twitter:creator" content="{!! '@' . $currentDomain ?? '' !!}">
    <!-- Twitter Card Meta Tags -->
<!-- og tags -->

@if(Route::is('home'))
    <meta name="verify-admitad" content="5d480905de" />
    <link rel="canonical" href="{{ url()->current() }}/">
@else
    <link rel="canonical" href="{{ url()->current() }}">
@endif
@foreach (config('stylelink') as $stylelinks )
<link type="text/CSS" rel="stylesheet" href="{{ asset($stylelinks) }}">
@endforeach
