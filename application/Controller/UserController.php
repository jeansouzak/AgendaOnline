<?php
/**
 * User: jean.souza
 * Date: 06/04/17
 * Time: 18:51
 */

namespace Application\Controller;


use Domain\Factory\UserFactory;
use Domain\Factory\UserServiceFactory;
use Domain\Service\Response\ServiceResponseStatus;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;

class UserController extends ApplicationController
{


    public function create(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {
            $userData = $request->getParsedBody();
            $user = UserFactory::createFromArray($userData);
            $userService = UserServiceFactory::getInstance();
            $serviceResponse = $userService->save($user);
            $view = $this->renderView('index.php', [
                'message' => $serviceResponse->getMessage(),
                'status' => $serviceResponse->getStatus() == ServiceResponseStatus::$RESPONSE_OK ? 'success' : 'warning'
            ]);
        } catch (\InvalidArgumentException $e) {
            $view = $this->renderView('index.php', [
                'message' => $e->getMessage(),
                'status' => 'warning'
            ]);
        }

        $response->getBody()->write($view);

        return $response;

    }

    public function login(ServerRequestInterface $request, ResponseInterface $response)
    {
        $userData = $request->getParsedBody();
        if (array_key_exists('email', $userData) && array_key_exists('password', $userData)) {
            $userService = UserServiceFactory::getInstance();
            $serviceResponse = $userService->login($userData['email'], $userData['password']);

            if ($serviceResponse->getStatus() !== ServiceResponseStatus::$RESPONSE_OK) {
                $view = $this->renderView('index.php', [
                    'message' => $serviceResponse->getMessage(),
                    'status' => 'warning'
                ]);
                $response->getBody()->write($view);
                return $response;
            }
            return new RedirectResponse('/contact');
        }
    }

    public function destroy(ServerRequestInterface $request, ResponseInterface $response)
    {
        $userService = UserServiceFactory::getInstance();
        $userService->logout();
        return new RedirectResponse('/');
    }

}