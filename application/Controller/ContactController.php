<?php
/**
 * User: jean.souza
 * Date: 06/04/17
 * Time: 18:51
 */

namespace Application\Controller;


use Domain\Factory\ContactFactory;
use Domain\Factory\ContactServiceFactory;
use Domain\Service\Response\ServiceResponseStatus;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;

class ContactController extends ApplicationController
{


    public function index(ServerRequestInterface $request, ResponseInterface $response)
    {
        $contactService = ContactServiceFactory::getInstance();
        $serviceResponse = $contactService->getContacts();
        $contacts = $serviceResponse->getBagItem('contacts');

        $view = $this->renderView('contacts.php', [
            'contacts' => $contacts
        ]);
        $response->getBody()->write($view);

        return $response;
    }

    public function create(ServerRequestInterface $request, ResponseInterface $response)
    {
        $view = $this->renderView('contact-form.php', [
            'method' => 'post'
        ]);
        $response->getBody()->write($view);

        return $response;
    }

    public function edit(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        if (!array_key_exists('id', $args)) {
            throw new \InvalidArgumentException;
        }

        $contactService = ContactServiceFactory::getInstance();
        $serviceResponse = $contactService->getContactByID($args['id']);
        $contact = $serviceResponse->getBagItem('contact');

        $view = $this->renderView('contact-form.php', [
            'method' => 'put',
            'contact' => $contact
        ]);
        $response->getBody()->write($view);

        return $response;
    }

    public function save(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {
            $contactData = $request->getParsedBody();
            $contact = ContactFactory::createFromArray($contactData);
            $contactService = ContactServiceFactory::getInstance();
            $serviceResponse = null;

            if ($contactData['_method'] === 'post') {
                $serviceResponse = $contactService->save($contact);
            } else {
                $serviceResponse = $contactService->update($contact);
            }

            if ($serviceResponse->getStatus() == ServiceResponseStatus::$RESPONSE_NOK) {
                $view = $this->renderView('contact-form.php', [
                    'message' => $serviceResponse->getMessage(),
                    'status' => 'warning',
                    'contact' => $contact,
                    'method' => $request->getMethod()
                ]);
                $response->getBody()->write($view);
                return $response;
            }
        } catch (\InvalidArgumentException $e) {
            $view = $this->renderView('contact-form.php', [
                'message' => $e->getMessage(),
                'status' => 'warning',
                'contact' => $contact,
                'method' => $request->getMethod()
            ]);
            $response->getBody()->write($view);
            return $response;
        }


        return new RedirectResponse('/contact');
    }


    public function delete(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        if (!array_key_exists('id', $args)) {
            throw new \InvalidArgumentException;
        }
        $contactService = ContactServiceFactory::getInstance();
        $serviceResponse = $contactService->getContactByID($args['id']);
        $contact = $serviceResponse->getBagItem('contact');
        if (!$contact) {
            return new RedirectResponse('/contact');
        }
        $contactService->delete($contact);
        return new RedirectResponse('/contact');

    }


}