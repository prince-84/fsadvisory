<!-- Search Engine Verifications (Google Search Console, Bing Webmaster, Yandex) -->
<meta name="google-site-verification" content="Pm7-Vgw4thZ8OH-WltmZSRwDdqxp9q4Xn5mMU_06tRg" />
<meta name="msvalidate.01" content="E65C761395C7D12E4A6CFCB1B51CD0E8" />
<meta name="yandex-verification" content="433a6fd3c0ac4850" />

<!-- Google tag (gtag.js) / Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-N3YF0EL0QY"></script>
<script async src="https://www.googletagmanager.com/gtm.js?id=G-N3YF0EL0QY"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-N3YF0EL0QY');
</script>

@if($customHeaderScripts = (site_setting('seo_header_scripts') ?: site_setting('header_scripts')))
{!! $customHeaderScripts !!}
@endif

