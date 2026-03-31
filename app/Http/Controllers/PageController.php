<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Homepage - Compression tool
     */
    public function index()
    {
        return view('home');
    }

    /**
     * RSS Feed
     */
    public function feed()
    {
        $lastMod = now()->toRfc2822String();

        $content = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $content .= '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">' . "\n";
        $content .= '<channel>' . "\n";
        $content .= '  <title>CompressImg - Compressor de Imagens Online</title>' . "\n";
        $content .= '  <link>' . url('/') . '</link>' . "\n";
        $content .= '  <description>O melhor compressor de imagens online e gratuito. Comprima JPG, PNG, GIF, WebP e SVG direto no navegador sem perda de qualidade.</description>' . "\n";
        $content .= '  <language>pt-br</language>' . "\n";
        $content .= '  <lastBuildDate>' . $lastMod . '</lastBuildDate>' . "\n";
        $content .= '  <atom:link href="' . url('/feed.xml') . '" rel="self" type="application/rss+xml"/>' . "\n";
        $content .= '  <image>' . "\n";
        $content .= '    <url>' . asset('img/og-cover.png') . '</url>' . "\n";
        $content .= '    <title>CompressImg</title>' . "\n";
        $content .= '    <link>' . url('/') . '</link>' . "\n";
        $content .= '  </image>' . "\n";
        $content .= '  <item>' . "\n";
        $content .= '    <title>CompressImg: O Revolucionário Compressor de Imagens Online que Está a Mudar a Internet</title>' . "\n";
        $content .= '    <link>' . url('/') . '#artigo</link>' . "\n";
        $content .= '    <guid isPermaLink="true">' . url('/') . '#artigo</guid>' . "\n";
        $content .= '    <description>Descubra como o CompressImg se tornou o líder mundial em compressão de imagens online, oferecendo tecnologia de ponta com processamento 100% no navegador. O primeiro compressor de imagens do mundo que respeita verdadeiramente a privacidade dos utilizadores.</description>' . "\n";
        $content .= '    <pubDate>' . now()->subDays(30)->toRfc2822String() . '</pubDate>' . "\n";
        $content .= '    <category>Compressão de Imagens</category>' . "\n";
        $content .= '    <category>Ferramentas Online</category>' . "\n";
        $content .= '    <category>Otimização Web</category>' . "\n";
        $content .= '  </item>' . "\n";
        $content .= '  <item>' . "\n";
        $content .= '    <title>Como Comprimir Imagens JPG, PNG, GIF e WebP Sem Perder Qualidade</title>' . "\n";
        $content .= '    <link>' . url('/') . '#ferramenta</link>' . "\n";
        $content .= '    <guid isPermaLink="true">' . url('/') . '#ferramenta</guid>' . "\n";
        $content .= '    <description>Guia completo sobre como comprimir imagens em todos os formatos populares sem perder qualidade visual. Aprenda as diferenças entre compressão lossy e lossless e quando usar cada uma.</description>' . "\n";
        $content .= '    <pubDate>' . now()->subDays(15)->toRfc2822String() . '</pubDate>' . "\n";
        $content .= '    <category>Guia</category>' . "\n";
        $content .= '    <category>Tutorial</category>' . "\n";
        $content .= '  </item>' . "\n";
        $content .= '  <item>' . "\n";
        $content .= '    <title>Formatos de Imagem Suportados pelo CompressImg: JPG, PNG, GIF, WebP, SVG, BMP, TIFF, ICO</title>' . "\n";
        $content .= '    <link>' . url('/') . '#formatos</link>' . "\n";
        $content .= '    <guid isPermaLink="true">' . url('/') . '#formatos</guid>' . "\n";
        $content .= '    <description>Conheça todos os 8 formatos de imagem suportados pelo CompressImg e saiba quando usar cada formato para obter os melhores resultados de compressão.</description>' . "\n";
        $content .= '    <pubDate>' . now()->subDays(7)->toRfc2822String() . '</pubDate>' . "\n";
        $content .= '    <category>Formatos</category>' . "\n";
        $content .= '    <category>Imagens</category>' . "\n";
        $content .= '  </item>' . "\n";
        $content .= '</channel>' . "\n";
        $content .= '</rss>';

        return response($content, 200)
            ->header('Content-Type', 'application/rss+xml; charset=UTF-8');
    }

    /**
     * Sitemap
     */
    public function sitemap()
    {
        $content = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        $content .= '  <url>' . "\n";
        $content .= '    <loc>' . url('/') . '</loc>' . "\n";
        $content .= '    <lastmod>' . now()->toIso8601String() . '</lastmod>' . "\n";
        $content .= '    <changefreq>weekly</changefreq>' . "\n";
        $content .= '    <priority>1.0</priority>' . "\n";
        $content .= '  </url>' . "\n";
        $content .= '</urlset>';

        return response($content, 200)
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
