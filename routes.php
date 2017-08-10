<?php

use RainLab\Translate\Classes\Translator;
use RainLab\Translate\Models\Locale;

Route::get('/switch_locale/{locale}/{uri?}', function ($locale, $uri = '/') {

    $locale = strtolower($locale);
    $trans = Translator::instance();
    $default = $trans->getDefaultLocale();

    if (Locale::isValid($locale)) {
        $trans->setLocale($locale);

    } else {
        $trans->setLocale($default);
    }

    $uri = base64_decode($uri);



    if (filter_var($uri, FILTER_VALIDATE_URL)) {
        return redirect()->to($uri);
    } else {
        if ($locale !== $default) {
            // redirecten naar /locale/'
            return redirect()->to('/'.$locale);
        } else {
            return redirect()->to('/');
        }
    }


});
