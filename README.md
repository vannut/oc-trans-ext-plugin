
> This plugin is **abondonned**, as most of the functions are included in RainLab.Translate


# Translate Extension

The Rainlab.Translate plugin is awesome. Period.

For a project we wanted to have a distinct url-structure with for non-standard locales a prefix in the url. The Rainlab.Translate plugin provides the higher-level support for this, we developed some sweet around it to make it work like we want to:

+ domain.ext/ => default locale homepage
+ domain.ext/en/ => en-locale homepage.
+ etc

What does it add:

## Middleware
This middleware checks wether the root of a domain name is requested. Normal behaviour of the Rainlab.Translate is to show the localized homepage when requesting `domain.ext/`. The middleware checks the requested path. If its the root it sets the default locale and continues. Done.

## rel="alternate" hreflang
To server your potential clients the proper language-variant of your website, Google uses the rel="alternate" hreflang element to index your website. See [Google's help page](https://support.google.com/webmasters/answer/189077) for more information.
You'll get a new component which you'll need to place inside your `<head>` section of your page, eg in your layout file or head-partial.
The component will retrieve all the different (enabled) locale-specific URL's of the current page and
list an element for each one of them. Eg:
```
<link rel="alternate" hreflang="nl" href="https://example.com/mijn-gave-pagina" />
<link rel="alternate" hreflang="en" href="https://example.com/en/my-fancy-page" />
```
The component will automatically prefix the url with the locale by means of the twig function (described somewhere else in this documentation). The only thing you'll need to make sure is to specify an URL in the static page or CMS page.
Ow didn't I mention that before, the component works both with CMS pages and Static Pages 😄

## Route to switch locale
The Translate plugin gives you some means to switch to a different locale, but we needed a 'solid' url to switch to a different url.  
The `/switch_locale/{locale}/{$uri?}` route will test your given locale; if valid it assesses it to be needing a prefix or not. If not valid, it wil redirect to the default locale.
You can provide a base64 encode url as a second parameter to which the user will be redirected.
If not present the default `/` or `/locale/` will be used for resp. the default and alternate locales.

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

## Update: advanced localeswitcher
This component can be placed on a page/layout/partial and displays a dropdown menu with theenabled locales. Switching locale will try to load the same page in the newly selected locale,
and redirects to it.
(Dont forget to use `{% scripts %}` in your layouts as the dropdown uses plain-javasscript to redirect)

## TODO:
* After switching locale by means of the route, look for the referer and redirect to the locale-spcific page (if available) instead of the root-page.
