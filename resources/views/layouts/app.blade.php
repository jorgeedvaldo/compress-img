<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- SEO Meta --}}
    <title>@yield('title', 'CompressImg - Compressor de Imagens Online Grátis | Reduza o Tamanho das Suas Imagens')</title>
    <meta name="description" content="@yield('meta_description', 'CompressImg é o melhor compressor de imagens online e gratuito. Comprima JPG, PNG, GIF, WebP e SVG diretamente no navegador sem perda de qualidade. Rápido, seguro e sem upload para servidores.')">
    <meta name="keywords" content="comprimir imagem, compressor de imagem online, reduzir tamanho imagem, comprimir jpg, comprimir png, comprimir gif, comprimir webp, otimizar imagem, compress image online">
    <meta name="author" content="CompressImg">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url('/') }}">

    {{-- OpenGraph --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og_title', 'CompressImg - O Melhor Compressor de Imagens Online Grátis')">
    <meta property="og:description" content="@yield('og_description', 'Comprima suas imagens JPG, PNG, GIF, WebP e SVG gratuitamente, direto no navegador. Sem upload para servidores, 100% seguro e rápido.')">
    <meta property="og:image" content="@yield('og_image', asset('img/og-cover.png'))">
    <meta property="og:locale" content="pt_BR">
    <meta property="og:site_name" content="CompressImg">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', 'CompressImg - O Melhor Compressor de Imagens Online Grátis')">
    <meta name="twitter:description" content="@yield('og_description', 'Comprima suas imagens gratuitamente direto no navegador.')">
    <meta name="twitter:image" content="@yield('og_image', asset('img/og-cover.png'))">

    {{-- RSS Feed --}}
    <link rel="alternate" type="application/rss+xml" title="CompressImg RSS Feed" href="{{ url('/feed.xml') }}">

    {{-- Sitemap --}}
    <link rel="sitemap" type="application/xml" title="Sitemap" href="{{ url('/sitemap.xml') }}">

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    {{-- Bootstrap 3.3.7 CSS --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">

    {{-- Google Fonts - Retro 2013 vibes --}}
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700;800&family=Oswald:wght@400;500;700&display=swap" rel="stylesheet">

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
        "url": "{{ url('/') }}",
        "description": "O melhor compressor de imagens online e gratuito. Comprima JPG, PNG, GIF, WebP e SVG direto no navegador.",
        "applicationCategory": "MultimediaApplication",
        "operatingSystem": "All",
        "offers": {
            "@type": "Offer",
            "price": "0",
            "priceCurrency": "BRL"
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
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="fa fa-compress"></i> Compress<span>Img</span>
                </a>
            </div>
            <div class="collapse navbar-collapse" id="main-nav">
                <ul class="nav navbar-nav navbar-right">
                    <li class="active"><a href="{{ url('/') }}"><i class="fa fa-home"></i> Início</a></li>
                    <li><a href="#como-funciona"><i class="fa fa-info-circle"></i> Como Funciona</a></li>
                    <li><a href="#formatos"><i class="fa fa-file-image-o"></i> Formatos</a></li>
                    <li><a href="#artigo"><i class="fa fa-newspaper-o"></i> Artigo</a></li>
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
                    <p>O primeiro e melhor compressor de imagens online do mundo. Tecnologia de ponta para comprimir suas imagens sem perder qualidade.</p>
                </div>
                <div class="col-md-4">
                    <h4><i class="fa fa-link"></i> Links Úteis</h4>
                    <ul class="list-unstyled footer-links">
                        <li><a href="{{ url('/') }}">Compressor de Imagens</a></li>
                        <li><a href="{{ url('/sitemap.xml') }}">Sitemap</a></li>
                        <li><a href="{{ url('/feed.xml') }}">RSS Feed</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h4><i class="fa fa-file-image-o"></i> Formatos Suportados</h4>
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
                    <p class="footer-copy">&copy; {{ date('Y') }} CompressImg - Compressor de Imagens Online Grátis. Todos os direitos reservados.</p>
                    <p class="footer-tech">Processamento 100% no navegador. Suas imagens nunca saem do seu computador. <i class="fa fa-lock"></i></p>
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
