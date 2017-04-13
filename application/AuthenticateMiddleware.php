<?php

namespace Application;


use Domain\Service\AuthenticateService;
use League\Route\Http\Exception\UnauthorizedException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AuthenticateMiddleware
{

    public function checkAuthenticate(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $authenticateService = new AuthenticateService();
        if (!$authenticateService->getUserSession()) {
            throw new UnauthorizedException;
        }
        return $next($request, $response);
    }

}