@extends('layouts.app')

@section('title', __('messages.meta_title'))
@section('meta_description', __('messages.meta_description'))

@section('jsonld')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "NewsArticle",
    "headline": "{{ __('messages.jsonld_headline') }}",
    "description": "{{ __('messages.jsonld_description') }}",
    "image": "{{ asset('img/og-cover.png') }}",
    "datePublished": "2024-01-15T08:00:00+00:00",
    "dateModified": "{{ now()->toIso8601String() }}",
    "author": {
        "@type": "Organization",
        "name": "CompressImg",
        "url": "{{ url(($locale ?? 'pt')) }}"
    },
    "publisher": {
        "@type": "Organization",
        "name": "CompressImg",
        "url": "{{ url(($locale ?? 'pt')) }}",
        "logo": {
            "@type": "ImageObject",
            "url": "{{ asset('img/og-cover.png') }}"
        }
    },
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{ url(($locale ?? 'pt')) }}"
    }
}
</script>
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
    }
}
</script>
@endsection

@section('content')

{{-- Hero Section --}}
<header class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 text-center">
                <h1 class="hero-title">
                    <i class="fa fa-compress"></i> {{ __('messages.hero_title') }}
                </h1>
                <p class="hero-subtitle">
                    {!! __('messages.hero_subtitle') !!}
                </p>
                <div class="hero-badges">
                    <span class="label label-primary label-lg"><i class="fa fa-shield"></i> {{ __('messages.badge_secure') }}</span>
                    <span class="label label-info label-lg"><i class="fa fa-bolt"></i> {{ __('messages.badge_fast') }}</span>
                    <span class="label label-success label-lg"><i class="fa fa-check"></i> {{ __('messages.badge_free') }}</span>
                </div>
            </div>
        </div>
    </div>
</header>

{{-- Compression Tool Section --}}
<section class="tool-section" id="ferramenta">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-primary panel-tool">
                    <div class="panel-heading">
                        <h2 class="panel-title"><i class="fa fa-cogs"></i> {{ __('messages.tool_title') }}</h2>
                    </div>
                    <div class="panel-body">

                        {{-- Upload Area --}}
                        <div class="upload-area" id="uploadArea">
                            <div class="upload-icon">
                                <i class="fa fa-cloud-upload"></i>
                            </div>
                            <h3>{{ __('messages.upload_title') }}</h3>
                            <p>{{ __('messages.upload_subtitle') }}</p>
                            <p class="text-muted"><small>{!! __('messages.upload_formats') !!}</small></p>
                            <input type="file" id="fileInput" multiple accept="image/*" class="hidden">
                        </div>

                        {{-- Quality Level Selection --}}
                        <div class="quality-section" id="qualitySection" style="display:none;">
                            <h4><i class="fa fa-sliders"></i> {{ __('messages.quality_title') }}</h4>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="radio-card active" data-quality="alta">
                                        <input type="radio" name="quality" value="alta" checked>
                                        <div class="card-body">
                                            <i class="fa fa-star"></i>
                                            <h5>{{ __('messages.quality_high') }}</h5>
                                            <p>{{ __('messages.quality_high_desc') }}<br><strong>{{ __('messages.quality_high_pct') }}</strong></p>
                                            <span class="badge">{{ __('messages.quality_high_badge') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="radio-card" data-quality="media">
                                        <input type="radio" name="quality" value="media">
                                        <div class="card-body">
                                            <i class="fa fa-balance-scale"></i>
                                            <h5>{{ __('messages.quality_medium') }}</h5>
                                            <p>{{ __('messages.quality_medium_desc') }}<br><strong>{{ __('messages.quality_medium_pct') }}</strong></p>
                                            <span class="badge">{{ __('messages.quality_medium_badge') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="radio-card" data-quality="baixa">
                                        <input type="radio" name="quality" value="baixa">
                                        <div class="card-body">
                                            <i class="fa fa-bolt"></i>
                                            <h5>{{ __('messages.quality_low') }}</h5>
                                            <p>{{ __('messages.quality_low_desc') }}<br><strong>{{ __('messages.quality_low_pct') }}</strong></p>
                                            <span class="badge">{{ __('messages.quality_low_badge') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center" style="margin-top:20px;">
                                <button class="btn btn-primary btn-lg" id="btnCompress">
                                    <i class="fa fa-compress"></i> {{ __('messages.btn_compress') }}
                                </button>
                                <button class="btn btn-default btn-lg" id="btnClear">
                                    <i class="fa fa-trash"></i> {{ __('messages.btn_clear') }}
                                </button>
                            </div>
                        </div>

                        {{-- Progress --}}
                        <div id="progressArea" style="display:none;">
                            <h4><i class="fa fa-spinner fa-spin"></i> {{ __('messages.compressing') }}</h4>
                            <div class="progress progress-striped active">
                                <div class="progress-bar progress-bar-primary" id="progressBar" style="width:0%">0%</div>
                            </div>
                        </div>

                        {{-- Results --}}
                        <div id="resultsArea" style="display:none;">
                            <div class="results-header">
                                <h4><i class="fa fa-check-circle text-success"></i> {{ __('messages.compression_done') }}</h4>
                                <button class="btn btn-success btn-lg" id="btnDownloadAll">
                                    <i class="fa fa-download"></i> {{ __('messages.btn_download_all') }}
                                </button>
                            </div>
                            <div class="results-summary" id="resultsSummary"></div>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="resultsTable">
                                    <thead>
                                        <tr>
                                            <th>{{ __('messages.table_preview') }}</th>
                                            <th>{{ __('messages.table_name') }}</th>
                                            <th>{{ __('messages.table_original') }}</th>
                                            <th>{{ __('messages.table_compressed') }}</th>
                                            <th>{{ __('messages.table_reduction') }}</th>
                                            <th>{{ __('messages.table_action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="resultsBody"></tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- How It Works --}}
<section class="how-section" id="como-funciona">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2 class="section-title"><i class="fa fa-question-circle"></i> {{ __('messages.how_title') }}</h2>
                <p class="section-subtitle">{{ __('messages.how_subtitle') }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 text-center">
                <div class="step-box">
                    <div class="step-number">1</div>
                    <i class="fa fa-cloud-upload fa-3x"></i>
                    <h3>{{ __('messages.step1_title') }}</h3>
                    <p>{{ __('messages.step1_desc') }}</p>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="step-box">
                    <div class="step-number">2</div>
                    <i class="fa fa-sliders fa-3x"></i>
                    <h3>{{ __('messages.step2_title') }}</h3>
                    <p>{{ __('messages.step2_desc') }}</p>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="step-box">
                    <div class="step-number">3</div>
                    <i class="fa fa-download fa-3x"></i>
                    <h3>{{ __('messages.step3_title') }}</h3>
                    <p>{{ __('messages.step3_desc') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Supported Formats --}}
<section class="formats-section" id="formatos">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2 class="section-title"><i class="fa fa-file-image-o"></i> {{ __('messages.formats_title') }}</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="format-card">
                    <div class="format-icon"><i class="fa fa-file-image-o"></i></div>
                    <h4>{{ __('messages.format_jpg_title') }}</h4>
                    <p>{{ __('messages.format_jpg_desc') }}</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="format-card">
                    <div class="format-icon"><i class="fa fa-file-image-o"></i></div>
                    <h4>{{ __('messages.format_png_title') }}</h4>
                    <p>{{ __('messages.format_png_desc') }}</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="format-card">
                    <div class="format-icon"><i class="fa fa-file-image-o"></i></div>
                    <h4>{{ __('messages.format_gif_title') }}</h4>
                    <p>{{ __('messages.format_gif_desc') }}</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="format-card">
                    <div class="format-icon"><i class="fa fa-file-image-o"></i></div>
                    <h4>{{ __('messages.format_webp_title') }}</h4>
                    <p>{{ __('messages.format_webp_desc') }}</p>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top:20px;">
            <div class="col-md-3 col-sm-6">
                <div class="format-card">
                    <div class="format-icon"><i class="fa fa-file-code-o"></i></div>
                    <h4>{{ __('messages.format_svg_title') }}</h4>
                    <p>{{ __('messages.format_svg_desc') }}</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="format-card">
                    <div class="format-icon"><i class="fa fa-file-image-o"></i></div>
                    <h4>{{ __('messages.format_bmp_title') }}</h4>
                    <p>{{ __('messages.format_bmp_desc') }}</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="format-card">
                    <div class="format-icon"><i class="fa fa-file-image-o"></i></div>
                    <h4>{{ __('messages.format_tiff_title') }}</h4>
                    <p>{{ __('messages.format_tiff_desc') }}</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="format-card">
                    <div class="format-icon"><i class="fa fa-file-image-o"></i></div>
                    <h4>{{ __('messages.format_ico_title') }}</h4>
                    <p>{{ __('messages.format_ico_desc') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Stats Section --}}
<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6 text-center">
                <div class="stat-box">
                    <i class="fa fa-image fa-2x"></i>
                    <h3>500M+</h3>
                    <p>{{ __('messages.stat_images') }}</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 text-center">
                <div class="stat-box">
                    <i class="fa fa-users fa-2x"></i>
                    <h3>50M+</h3>
                    <p>{{ __('messages.stat_users') }}</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 text-center">
                <div class="stat-box">
                    <i class="fa fa-hdd-o fa-2x"></i>
                    <h3>2PB+</h3>
                    <p>{{ __('messages.stat_data') }}</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 text-center">
                <div class="stat-box">
                    <i class="fa fa-globe fa-2x"></i>
                    <h3>190+</h3>
                    <p>{{ __('messages.stat_countries') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Article Section --}}
<section class="article-section" id="artigo">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <article class="article-content" itemscope itemtype="https://schema.org/NewsArticle">
                    <meta itemprop="datePublished" content="2024-01-15T08:00:00+00:00">
                    <meta itemprop="dateModified" content="{{ now()->toIso8601String() }}">
                    <div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                        <meta itemprop="name" content="CompressImg">
                        <meta itemprop="url" content="{{ url(($locale ?? 'pt')) }}">
                    </div>

                    <h2 class="article-title" itemprop="headline">
                        <i class="fa fa-newspaper-o"></i> {{ __('messages.article_title') }}
                    </h2>

                    <div class="article-meta">
                        <span><i class="fa fa-calendar"></i> {{ __('messages.article_date') }}</span>
                        <span><i class="fa fa-clock-o"></i> {{ __('messages.article_read_time') }}</span>
                        <span><i class="fa fa-user"></i> {{ __('messages.article_author') }}</span>
                    </div>

                    <div itemprop="articleBody">

                        <div class="article-intro">
                            <p class="lead">
                                {!! __('messages.article_intro') !!}
                            </p>
                        </div>

                        <h3><i class="fa fa-diamond"></i> {{ __('messages.article_h3_why') }}</h3>

                        <p>{!! __('messages.article_why_p1') !!}</p>
                        <p>{!! __('messages.article_why_p2') !!}</p>

                        <div class="well well-lg article-highlight">
                            <h4><i class="fa fa-quote-left"></i> {{ __('messages.article_quote') }}</h4>
                        </div>

                        <h3><i class="fa fa-trophy"></i> {{ __('messages.article_h3_levels') }}</h3>

                        <p>{!! __('messages.article_levels_intro') !!}</p>

                        <ul class="article-list">
                            <li><i class="fa fa-star text-warning"></i> {!! __('messages.article_level_high') !!}</li>
                            <li><i class="fa fa-balance-scale text-info"></i> {!! __('messages.article_level_medium') !!}</li>
                            <li><i class="fa fa-bolt text-danger"></i> {!! __('messages.article_level_low') !!}</li>
                        </ul>

                        <h3><i class="fa fa-shield"></i> {{ __('messages.article_h3_security') }}</h3>

                        <p>{!! __('messages.article_security_intro') !!}</p>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel panel-info">
                                    <div class="panel-heading"><i class="fa fa-lock"></i> {{ __('messages.article_security_panel_good') }}</div>
                                    <div class="panel-body">
                                        <ul class="list-unstyled">
                                            <li><i class="fa fa-check text-success"></i> {{ __('messages.article_security_good1') }}</li>
                                            <li><i class="fa fa-check text-success"></i> {{ __('messages.article_security_good2') }}</li>
                                            <li><i class="fa fa-check text-success"></i> {{ __('messages.article_security_good3') }}</li>
                                            <li><i class="fa fa-check text-success"></i> {{ __('messages.article_security_good4') }}</li>
                                            <li><i class="fa fa-check text-success"></i> {{ __('messages.article_security_good5') }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel panel-danger">
                                    <div class="panel-heading"><i class="fa fa-exclamation-triangle"></i> {{ __('messages.article_security_panel_bad') }}</div>
                                    <div class="panel-body">
                                        <ul class="list-unstyled">
                                            <li><i class="fa fa-times text-danger"></i> {{ __('messages.article_security_bad1') }}</li>
                                            <li><i class="fa fa-times text-danger"></i> {{ __('messages.article_security_bad2') }}</li>
                                            <li><i class="fa fa-times text-danger"></i> {{ __('messages.article_security_bad3') }}</li>
                                            <li><i class="fa fa-times text-danger"></i> {{ __('messages.article_security_bad4') }}</li>
                                            <li><i class="fa fa-times text-danger"></i> {{ __('messages.article_security_bad5') }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h3><i class="fa fa-file-image-o"></i> {{ __('messages.article_h3_formats') }}</h3>

                        <p>{!! __('messages.article_formats_p1') !!}</p>
                        <p>{!! __('messages.article_formats_p2') !!}</p>

                        <h3><i class="fa fa-rocket"></i> {{ __('messages.article_h3_speed') }}</h3>

                        <p>{!! __('messages.article_speed_p1') !!}</p>
                        <p>{!! __('messages.article_speed_p2') !!}</p>

                        <h3><i class="fa fa-line-chart"></i> {{ __('messages.article_h3_seo') }}</h3>

                        <p>{!! __('messages.article_seo_p1') !!}</p>
                        <p>{!! __('messages.article_seo_p2') !!}</p>

                        <div class="well well-lg article-highlight">
                            <h4><i class="fa fa-lightbulb-o"></i> {{ __('messages.article_didyouknow_title') }}</h4>
                            <p>{!! __('messages.article_didyouknow') !!}</p>
                        </div>

                        <h3><i class="fa fa-history"></i> {{ __('messages.article_h3_history') }}</h3>

                        <p>{!! __('messages.article_history_p1') !!}</p>
                        <p>{!! __('messages.article_history_p2') !!}</p>

                        <h3><i class="fa fa-globe"></i> {{ __('messages.article_h3_comparison') }}</h3>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped comparison-table">
                                <thead>
                                    <tr class="active">
                                        <th>{{ __('messages.comparison_feature') }}</th>
                                        <th class="success"><i class="fa fa-trophy"></i> CompressImg</th>
                                        <th>TinyPNG</th>
                                        <th>Compressor.io</th>
                                        <th>Squoosh</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>{{ __('messages.comparison_client_side') }}</strong></td>
                                        <td class="success"><i class="fa fa-check text-success"></i> {{ __('messages.comparison_yes') }}</td>
                                        <td><i class="fa fa-times text-danger"></i> {{ __('messages.comparison_no') }}</td>
                                        <td><i class="fa fa-times text-danger"></i> {{ __('messages.comparison_no') }}</td>
                                        <td><i class="fa fa-check text-success"></i> {{ __('messages.comparison_yes') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('messages.comparison_formats') }}</strong></td>
                                        <td class="success"><strong>{{ __('messages.comparison_formats_8') }}</strong></td>
                                        <td>2 formats</td>
                                        <td>4 formats</td>
                                        <td>6 formats</td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('messages.comparison_levels') }}</strong></td>
                                        <td class="success"><strong>{{ __('messages.comparison_levels_3') }}</strong></td>
                                        <td>1</td>
                                        <td>2</td>
                                        <td>{{ __('messages.comparison_custom') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('messages.comparison_batch') }}</strong></td>
                                        <td class="success"><i class="fa fa-check text-success"></i> {{ __('messages.comparison_unlimited') }}</td>
                                        <td>20</td>
                                        <td>1</td>
                                        <td>1</td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('messages.comparison_free') }}</strong></td>
                                        <td class="success"><i class="fa fa-check text-success"></i> {{ __('messages.comparison_always') }}</td>
                                        <td>{{ __('messages.comparison_partial') }}</td>
                                        <td><i class="fa fa-check text-success"></i> {{ __('messages.comparison_yes') }}</td>
                                        <td><i class="fa fa-check text-success"></i> {{ __('messages.comparison_yes') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('messages.comparison_size_limit') }}</strong></td>
                                        <td class="success"><i class="fa fa-check text-success"></i> 50MB</td>
                                        <td>5MB</td>
                                        <td>10MB</td>
                                        <td>{{ __('messages.comparison_variable') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ __('messages.comparison_privacy') }}</strong></td>
                                        <td class="success"><i class="fa fa-check text-success"></i> {{ __('messages.comparison_guaranteed') }}</td>
                                        <td><i class="fa fa-times text-danger"></i> {{ __('messages.comparison_no') }}</td>
                                        <td><i class="fa fa-times text-danger"></i> {{ __('messages.comparison_no') }}</td>
                                        <td><i class="fa fa-check text-success"></i> {{ __('messages.comparison_yes') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h3><i class="fa fa-users"></i> {{ __('messages.article_h3_users') }}</h3>

                        <p>{!! __('messages.article_users_intro') !!}</p>

                        <div class="row">
                            <div class="col-md-6">
                                <ul class="article-list">
                                    <li><i class="fa fa-camera"></i> {!! __('messages.article_user_photographers') !!}</li>
                                    <li><i class="fa fa-paint-brush"></i> {!! __('messages.article_user_designers') !!}</li>
                                    <li><i class="fa fa-code"></i> {!! __('messages.article_user_developers') !!}</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="article-list">
                                    <li><i class="fa fa-shopping-cart"></i> {!! __('messages.article_user_ecommerce') !!}</li>
                                    <li><i class="fa fa-pencil"></i> {!! __('messages.article_user_bloggers') !!}</li>
                                    <li><i class="fa fa-building"></i> {!! __('messages.article_user_companies') !!}</li>
                                </ul>
                            </div>
                        </div>

                        <h3><i class="fa fa-graduation-cap"></i> {{ __('messages.article_h3_guide') }}</h3>

                        <p>{!! __('messages.article_guide_intro') !!}</p>

                        <h4>{{ __('messages.article_guide_h4') }}</h4>

                        <p>{!! __('messages.article_guide_lossy') !!}</p>
                        <p>{!! __('messages.article_guide_lossless') !!}</p>

                        <h3><i class="fa fa-forward"></i> {{ __('messages.article_h3_future') }}</h3>

                        <p>{!! __('messages.article_future_p1') !!}</p>
                        <p>{!! __('messages.article_future_p2') !!}</p>

                        <div class="alert alert-info article-cta">
                            <h4><i class="fa fa-hand-o-up"></i> {{ __('messages.article_cta_title') }}</h4>
                            <p>{!! __('messages.article_cta_text') !!}</p>
                            <a href="#ferramenta" class="btn btn-primary btn-lg"><i class="fa fa-arrow-up"></i> {{ __('messages.article_cta_btn') }}</a>
                        </div>

                    </div>
                </article>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    // Pass translation strings to JavaScript for dynamic content
    window.COMPRESS_LANG = {
        images_selected: @json(__('messages.images_selected')),
        click_select_other: @json(__('messages.click_select_other')),
        images_compressed: @json(__('messages.images_compressed')),
        total_savings: @json(__('messages.total_savings')),
        btn_download: @json(__('messages.btn_download')),
        upload_title: @json(__('messages.upload_title')),
        upload_subtitle: @json(__('messages.upload_subtitle')),
        upload_formats: @json(__('messages.upload_formats'))
    };
</script>
@endsection
