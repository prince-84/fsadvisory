<!-- Search Engine Verifications (Google Search Console, Bing Webmaster, Yandex) -->
<meta name="google-site-verification" content="y1noJOhSDc2Z8nuDupa_uCByiBdHsimXEc9FhurNqFc" />
<meta name="msvalidate.01" content="E65C761395C7D12E4A6CFCB1B51CD0E8" />
<meta name="yandex-verification" content="334d714fee991fab" />

<!-- Google Tag Manager / GA4 -->
<script async src="https://www.googletagmanager.com/gtm.js?id=GTM-TC468P78"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
</script>

@if($customHeaderScripts = (site_setting('seo_header_scripts') ?: site_setting('header_scripts')))
{!! $customHeaderScripts !!}
@endif
