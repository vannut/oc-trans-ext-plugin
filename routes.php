<?php

use RainLab\Translate\Classes\Translator;
use RainLab\Translate\Models\Locale;

Route::get('/switch_locale/{locale}', function ($locale) {

    $locale = strtolower($locale);
    $trans = Translator::instance();
    $default = $trans->getDefaultLocale();

    if (Locale::isValid($locale)) {
        $trans->setLocale($locale);
        if ($locale !== $default) {
            // redirecten naar /locale/'
            return redirect()->to('/'.$locale);
        }
    } else {
        $trans->setLocale($default);
    }

    // redirecten naar '/';
    return redirect()->to('/');

});
