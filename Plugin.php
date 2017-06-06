<?php

namespace Vannut\TransEXT;

class Plugin extends \System\Classes\PluginBase
{

    public function boot()
    {
        $this->app['Illuminate\Contracts\Http\Kernel']
         ->pushMiddleware('Vannut\TransEXT\Middleware\RewriteLocaleForIndexPage');
    }

    /**
     * @var array Plugin dependencies
     */
    // public $require = ['Rainlab.Translate'];

    public function pluginDetails()
    {
        return [
            'name' => 'Translate Extension',
            'description' => 'Adds some logic to translate plugin',
            'author' => 'Richard @ Van Nut',
            'icon' => 'icon-plus'
        ];
    }

    public function registerComponents()
    {
        return [
            'Vannut\TransEXT\Components\HeadAlternateHrefLangElements' => 'alternateHrefLangElements'
        ];
    }


    public function registerMarkupTags()
    {
        return [
            'filters' => [
            ],
            'functions' => [
                'asses_menu_item_url' => [$this, 'twigAssesMenuItemUrl'],
            ]
        ];
    }


    /**
     * Assesses the url, and adds the locale for non-default locales, while
     * it strips the locale for the default locale.
     * @param  String $url
     * @param  String $locale        the current locale
     * @param  String $defaultLocale default locale of the october installation
     * @return String                the correct relative url
     */
    public function twigAssesMenuItemUrl($url, $locale, $defaultLocale)
    {
        $locale = strtolower($locale);
        $defaultLocale = strtolower($defaultLocale);

        if ($locale !== $defaultLocale) {
            // is het switch_locale?
            if (strpos($url, '/switch_locale/') === false) {
                // niet gevonden...
                // dus aanpassen
                $path = parse_url($url, PHP_URL_PATH);
                return '/'
                    .$locale
                    .str_replace('/'.$locale.'/', '/', $path);
            }
        }

        return $url;

    }

}
