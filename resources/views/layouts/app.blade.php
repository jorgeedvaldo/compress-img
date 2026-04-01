<!DOCTYPE html>
<html lang="{{ $htmlLang ?? 'pt-BR' }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-6QLW63BEMJ"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date()); gtag('config', 'G-6QLW63BEMJ'); 
    </script>

    {{-- SEO Meta --}}
    <title>@yield('title', __('messages.meta_title'))</title>
    <meta name="description" content="@yield('meta_description', __('messages.meta_description'))">
    <meta name="keywords"
        content="compress image, image compressor, compress jpg, compress png, compress gif, compress webp, optimize image, compress image online, compressor de imagem, comprimir imagem">
    <meta name="author" content="CompressImg">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url(($locale ?? 'pt')) }}">

    {{-- Hreflang tags for SEO --}}
    @foreach(($locales ?? ['en', 'pt', 'es', 'fr', 'zh', 'hi', 'ru']) as $loc)
        <link rel="alternate" hreflang="{{ $loc }}" href="{{ url($loc) }}">
    @endforeach
    <link rel="alternate" hreflang="x-default" href="{{ url('pt') }}">

    {{-- OpenGraph --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og_title', __('messages.og_title'))">
    <meta property="og:description" content="@yield('og_description', __('messages.og_description'))">
    <meta property="og:image" content="@yield('og_image', asset('img/og-cover.png'))">
    <meta property="og:locale" content="{{ $htmlLang ?? 'pt-BR' }}">
    <meta property="og:site_name" content="CompressImg">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', __('messages.og_title'))">
    <meta name="twitter:description" content="@yield('og_description', __('messages.og_description'))">
    <meta name="twitter:image" content="@yield('og_image', asset('img/og-cover.png'))">

    {{-- RSS Feed --}}
    <link rel="alternate" type="application/rss+xml" title="CompressImg RSS Feed"
        href="{{ url(($locale ?? 'pt') . '/feed.xml') }}">

    {{-- Sitemap --}}
    <link rel="sitemap" type="application/xml" title="Sitemap" href="{{ url('/sitemap.xml') }}">

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    {{-- Bootstrap 3.3.7 CSS --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">

    {{-- Google Fonts - Retro 2013 vibes --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700;800&family=Oswald:wght@400;500;700&display=swap"
        rel="stylesheet">

    {{-- Font Awesome 4 --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    {{-- JSON-LD NewsArticle --}}
    @hasSection('jsonld')
        @yield('jsonld')
    @else
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebApplication",
            "name": "CompressImg",
            "url": "{{ url(($locale ?? 'pt')) }}",
            "description": "{{ __('messages.jsonld_app_description') }}",
            "applicationCategory": "MultimediaApplication",
            "operatingSystem": "All",
            "offers": {
                "@type": "Offer",
                "price": "0",
                "priceCurrency": "USD"
            },
            "author": {
                "@type": "Organization",
                "name": "CompressImg",
                "url": "{{ url('/') }}"
            }
        }
        </script>
    @endif
</head>

<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-default navbar-static-top navbar-custom">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url(($locale ?? 'pt')) }}">
                    <i class="fa fa-compress"></i> Compress<span>Img</span>
                </a>
            </div>
            <div class="collapse navbar-collapse" id="main-nav">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="{{ url(($locale ?? 'pt')) }}"><i class="fa fa-home"></i>
                            {{ __('messages.nav_home') }}</a></li>
                    <li><a href="#como-funciona"><i class="fa fa-info-circle"></i> {{ __('messages.nav_how') }}</a></li>
                    <li><a href="#formatos"><i class="fa fa-file-image-o"></i> {{ __('messages.nav_formats') }}</a></li>
                    <li><a href="#artigo"><i class="fa fa-newspaper-o"></i> {{ __('messages.nav_article') }}</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="fa fa-globe"></i> {{ __('messages.lang_' . ($locale ?? 'pt')) }} <span
                                class="caret"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-lang">
                            @foreach(($locales ?? ['en', 'pt', 'es', 'fr', 'zh', 'hi', 'ru']) as $loc)
                                <li class="{{ ($locale ?? 'pt') === $loc ? 'active' : '' }}">
                                    <a href="{{ url($loc) }}">{{ __('messages.lang_' . $loc) }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    @yield('content')

    {{-- Footer --}}
    <footer class="footer-custom">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h4><i class="fa fa-compress"></i> CompressImg</h4>
                    <p>{{ __('messages.footer_desc') }}</p>
                </div>
                <div class="col-md-4">
                    <h4><i class="fa fa-link"></i> {{ __('messages.footer_links') }}</h4>
                    <ul class="list-unstyled footer-links">
                        <li><a href="{{ url(($locale ?? 'pt')) }}">{{ __('messages.footer_link_compressor') }}</a></li>
                        <li><a href="{{ url(($locale ?? 'pt') . '/sitemap.xml') }}">Sitemap</a></li>
                        <li><a href="{{ url(($locale ?? 'pt') . '/feed.xml') }}">RSS Feed</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h4><i class="fa fa-file-image-o"></i> {{ __('messages.footer_formats') }}</h4>
                    <p>
                        <span class="label label-primary">JPG</span>
                        <span class="label label-info">PNG</span>
                        <span class="label label-success">GIF</span>
                        <span class="label label-warning">WebP</span>
                        <span class="label label-default">SVG</span>
                        <span class="label label-danger">BMP</span>
                        <span class="label label-primary">TIFF</span>
                        <span class="label label-info">ICO</span>
                    </p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="footer-copy">&copy; {{ date('Y') }} {{ __('messages.footer_copy') }}</p>
                    <p class="footer-tech">{{ __('messages.footer_tech') }} <i class="fa fa-lock"></i></p>
                </div>
            </div>
        </div>
    </footer>

    {{-- jQuery & Bootstrap 3 JS --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    {{-- Custom JS --}}
    <script src="{{ asset('js/compressor.js') }}"></script>

    @yield('scripts')
</body>

</html>