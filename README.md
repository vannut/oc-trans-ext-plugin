# Translate Extension

The Rainlab.Translate plugin is awesome. Period.

For a project we wanted to have a distinct url-structure with for non-standard locales a prefix in the url. The Rainlab.Translate plugin provides the higher-level support for this, we developed some sweet around it to make it work like we want to:

+ domain.ext/ => default locale homepage
+ domain.ext/en/ => en-locale homepage.
+ etc

What does it add:

## Middleware
This middleware checks wether the root of a domain name is requested. Normal behaviour of the Rainlab.Translate is to show the localized homepage when requesting `domain.ext/`. The middleware checks the requested path. If its the root it sets the default locale and continues. Done.

## Route to switch locale
The Translate plugin gives you some means to switch to a different locale, but we needed a 'solid' url to switch to a different url.  
The `/switch_locale/{locale}` route will test your given locale; if valid it assesses it to be needing a prefix or not. If not valid, it wil redirect to the default locale.

## Twig function
The function takes the URL, active locale and the default locale as arguments. If the active locale === the defaultLocale it will strip the locale from the url. If not, the url will be prefixed with the locale.

    <a href="{{ asses_menu_item_url(item.url, locale, defaultLocale) }}">item.label</a>

To retrieve the `locale` and `defaultLocale` you should add the following to your layout in the code section.

```
use RainLab\Translate\Classes\Translator;

function onStart()
{
    $trans = Translator::instance();
    $this['locale'] = $trans->getLocale();
    $this['defaultLocale'] = $trans->getDefaultLocale();
}
```

## TODO:
* create a component to generate hreflang-elements:
```
<link rel="alternate" hreflang="nl" href="http://example.com/page.html" />
<link rel="alternate" hreflang="en" href="http://example.com/en/page.html" />
```
* After switching locale by means of the route, look for the referer and redirect to the locale-spcific page (if available) instead of the root-page.
