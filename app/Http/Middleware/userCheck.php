<?php

namespace App\Http\Middleware;

use App\Http\Controllers\LoginController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserCheck

{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $validPagesForUser = $this->getValidPagesForUser($request);

        $this->checkPageSender($request, $validPagesForUser);

        return $next($request);
    }

    public function checkPageSender($request, $validPagesForUser)
    {

        $fullUrl = $request->headers->get('referer');
        
        $path = parse_url($fullUrl, PHP_URL_PATH);

        $segments = explode('/', trim($path, '/'));
       
        $page = isset($segments[1]) ? $segments[1] : $segments[0];  

        if (!in_array($page, $validPagesForUser)) {
            throw new HttpException(401, 'Não autorizado.');
        }
    }

    public function getValidPagesForUser() 
    {
        $loginController = new LoginController();

        $userInfo = $loginController->userAndPages();

        return $userInfo['pages'];
    }
}
