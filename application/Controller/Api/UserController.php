<?php
/**
 * User: jean.souza
 * Date: 06/04/17
 * Time: 18:51
 */

namespace Application\Controller\Api;


use Domain\Factory\UserFactory;
use Domain\Factory\UserServiceFactory;
use Domain\Service\Response\ServiceResponseStatus;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\RedirectResponse;

class UserController
{


    public function create(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {
            $userData = $request->getParsedBody();
            $user = UserFactory::createFromArray($userData);
            $userService = UserServiceFactory::getInstance();
            $serviceResponse = $userService->save($user);

            return new JsonResponse(
                ['message' => $serviceResponse->getMessage()],
                $serviceResponse->getStatus() == ServiceResponseStatus::$RESPONSE_OK ? 200 : 400
            );
        } catch (\InvalidArgumentException $e) {
            return new JsonResponse(
                ['message' => $e->getMessage()],
                400
            );
        }

    }

    public function login(ServerRequestInterface $request, ResponseInterface $response)
    {
        $userData = $request->getParsedBody();
        if (array_key_exists('email', $userData) && array_key_exists('password', $userData)) {
            $userService = UserServiceFactory::getInstance();
            $serviceResponse = $userService->login($userData['email'], $userData['password']);

            if ($serviceResponse->getStatus() != ServiceResponseStatus::$RESPONSE_OK) {
                return new JsonResponse(
                    ['message' => $serviceResponse->getMessage()],
                    400
                );
            }
            return new JsonResponse(
                ['message' => 'Logado com sucesso']
            );
        }
        return new JsonResponse(
            ['message' => 'Parametros inválidos'],
            400
        );
    }

    public function destroy(ServerRequestInterface $request, ResponseInterface $response)
    {
        $userService = UserServiceFactory::getInstance();
        $userService->logout();
        return new JsonResponse(
            ['message' => 'Logoff Realizado.']
        );
    }


}