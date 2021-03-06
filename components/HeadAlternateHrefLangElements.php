<?php

namespace Vannut\TransEXT\Components;

use Cms\Classes\ComponentBase;
use RainLab\Translate\Classes\Translator;
use RainLab\Translate\Models\Locale as LocaleModel;
use October\Rain\Router\Router as RainRouter;

class HeadAlternateHrefLangElements extends ComponentBase
{


    public function componentDetails()
    {
        return [
            'name' => 'Alternate HREF Lang elements',
            'description' => 'Injects the language alternatives as hreflang elements'
        ];
    }

    public function locales()
    {
        // Available locales
        $locales = collect(LocaleModel::listEnabled());

        // Transform it to contain the new urls
        $locales->transform(function ($item, $key) {
            return $this->retrieveLocalizedUrl($key);
        });

        return $locales->toArray();
    }

    private function retrieveLocalizedUrl($locale)
    {
        $page = $this->getPage();
        /*
         * Static Page
         */
        if (isset($page->apiBag['staticPage'])) {
            $staticPage = $page->apiBag['staticPage'];
            $staticPage->rewriteTranslatablePageUrl($locale);
            $localeUrl = array_get($staticPage->attributes, 'viewBag.url');
        }
        /*
         * CMS Page
         */
        else {
            $page->rewriteTranslatablePageUrl($locale);
            $router = new RainRouter;
            $params = $this->getRouter()->getParameters();
            $localeUrl = $router->urlFromPattern($page->url, $params);
        }

        return $localeUrl;
    }

}
