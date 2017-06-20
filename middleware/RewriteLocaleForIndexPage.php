<?php
namespace Vannut\TransEXT\Middleware;

use Closure;
use RainLab\Translate\Classes\Translator;

/*
 | Normal behaviour of the rainlab.translate plugin when requested the domain.ext/
 | route would be to display it in the last choosen Locale. Even if
 | it's not the default locale.
 |
 | This middleware checks if the requested page is the root of the domain name.
 | If so, the default locale will be restored, resulting in the display of the 'default'
 | startpage instead of the alternative-locale startpage.
 |
 | The alternative locale startage would be under domain.ext/en/
 |
 */
class RewriteLocaleForIndexPage
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if ($request->path() === '/') {
            $trans = Translator::instance();
            $default = $trans->getDefaultLocale();
            $trans->setLocale($default);
        };

        return $next($request);
    }

}
