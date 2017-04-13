<?php
/**
 * User: jean.souza
 * Date: 06/04/17
 * Time: 18:51
 */

namespace Application\Controller\Api;


use Domain\Factory\ContactFactory;
use Domain\Factory\ContactServiceFactory;
use Domain\Service\Response\ServiceResponseStatus;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class ContactController
{


    public function index(ServerRequestInterface $request, ResponseInterface $response)
    {
        $contactService = ContactServiceFactory::getInstance();
        $serviceResponse = $contactService->getContacts();
        $contacts = $serviceResponse->getBagItem('contacts');


        return new JsonResponse(array_map(function ($contact) {
            return $contact->toArray();
        }, $contacts));

    }


    public function save(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {
            $contactData = $request->getParsedBody();

            $contact = ContactFactory::createFromArray($contactData);
            $contactService = ContactServiceFactory::getInstance();
            $serviceResponse = $contactService->save($contact);

            return new JsonResponse(
                ['message' => $serviceResponse->getMessage()],
                $serviceResponse->getStatus() == ServiceResponseStatus::$RESPONSE_OK ? 200 : 400
            );
        } catch (\Exception $e) {
            return new JsonResponse(
                ['message' => $e->getMessage()],
                400
            );
        }


    }

    public function update(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {
            $contactData = $request->getParsedBody();

            $contact = ContactFactory::createFromArray($contactData);
            $contactService = ContactServiceFactory::getInstance();
            $serviceResponse = $contactService->update($contact);

            return new JsonResponse(
                ['message' => $serviceResponse->getMessage()],
                $serviceResponse->getStatus() == ServiceResponseStatus::$RESPONSE_OK ? 200 : 400
            );
        } catch (\Exception $e) {
            return new JsonResponse(
                ['message' => $e->getMessage()],
                400
            );
        }


    }

    public function delete(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        if (!array_key_exists('id', $args)) {
            return new JsonResponse(
                ['message' => 'Contact ID not provided.'],
                400
            );
        }
        $contactService = ContactServiceFactory::getInstance();
        $serviceResponse = $contactService->getContactByID($args['id']);

        if ($serviceResponse->getStatus() == ServiceResponseStatus::$RESPONSE_NOK) {
            return new JsonResponse(
                ['message' => $serviceResponse->getMessage()],
                404
            );
        }
        $contact = $serviceResponse->getBagItem('contact');
        $serviceResponse = $contactService->delete($contact);
        return new JsonResponse(
            ['message' => $serviceResponse->getMessage()],
            200
        );

    }


}