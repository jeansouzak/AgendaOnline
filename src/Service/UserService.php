<?php

namespace Domain\Service;


use Domain\Entity\Plan;
use Domain\Entity\User;
use Domain\Factory\PlanServiceFactory;
use Domain\Repository\UserRepositoryInterface;
use Domain\Service\Response\ServiceResponse;
use Domain\Service\Response\ServiceResponseStatus;

class UserService
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Save an User
     * @param User $user
     * @return ServiceResponse
     */
    public function save(User $user)
    {
        $serviceResponse = new ServiceResponse();
        
        if ($this->userRepository->findUserByEmail($user->getEmail())) {
            $serviceResponse->setMessage('Já foi cadastrado um usuário com o mesmo e-mail');
            $serviceResponse->setStatus(ServiceResponseStatus::$RESPONSE_NOK);
            return $serviceResponse;
        }
        $planService = PlanServiceFactory::getInstance();
        $user->setPlan($planService->getDefaultPlan());
        $securityUserService = new SecurityUserService();
        $securityUserService->safeUser($user);
        $this->userRepository->save($user);

        $serviceResponse->setMessage('Usuário cadastrado com sucesso, faça seu login.');
        $serviceResponse->setStatus(ServiceResponseStatus::$RESPONSE_OK);

        return $serviceResponse;

    }



    /**
     * Login an User with email and password
     * @param string $email
     * @param string $password
     * @return ServiceResponse
     */
    public function login($email, $password)
    {
        $serviceResponse = new ServiceResponse();

        if(!($email && $password)) {
            $serviceResponse->setMessage('E-mail e senha devem ser preenchidos');
            $serviceResponse->setStatus(ServiceResponseStatus::$RESPONSE_NOK);
            return $serviceResponse;
        }


        $serviceResponse->setMessage('E-mail ou senha inválidos');
        $serviceResponse->setStatus(ServiceResponseStatus::$RESPONSE_NOK);

        $user = $this->userRepository->findUserByEmail($email);


        $securityUserService = new SecurityUserService();
        if($user && $securityUserService->checkSameHash($password, $user->getPassword())) {
            $serviceResponse->setMessage(null);
            $serviceResponse->setStatus(ServiceResponseStatus::$RESPONSE_OK);

            $authenticateService = new AuthenticateService();
            $authenticateService->authenticate($user);
        }
        return $serviceResponse;
    }

    /**
     * Logoff an User
     */
    public function logout()
    {
        $authenticateService = new AuthenticateService();
        $authenticateService->destroy();
    }




}