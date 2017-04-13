<?php
/**
 * User: jean.souza
 * Date: 07/04/17
 * Time: 02:16
 */

namespace Domain\Service;


use Carbon\Carbon;
use Domain\Entity\Contact;
use Domain\Entity\Enum\ContactNotification;
use Domain\Entity\Enum\PlanType;
use Domain\Repository\ContactRepositoryInterface;
use Domain\Service\Response\ServiceResponse;
use Domain\Service\Response\ServiceResponseStatus;

class ContactService
{

    /**
     * @var ContactRepositoryInterface
     */
    private $contactRepository;

    public function __construct(ContactRepositoryInterface $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    /**
     * Get list of contacts
     * @return ServiceResponse
     */
    public function getContacts()
    {
        $authenticateService = new AuthenticateService();
        $user = $authenticateService->getUserSession();

        $contacts = array_map(function (Contact $contact) {

            if ($contact->getBornDay() && $contact->getBornMonth()) {
                $today = new Carbon();
                $birthday = Carbon::createFromDate($today->year, $contact->getBornMonth(), $contact->getBornDay());
                if ($today->isBirthday($birthday)) {
                    $contact->addNotification(ContactNotification::BIRTHDAY);
                }
            }
            return $contact;
        }, $this->contactRepository->findContactsByUserID($user->getId()));
        $serviceResponse = new ServiceResponse('Ok', ServiceResponseStatus::$RESPONSE_OK, [
            'contacts' => $contacts
        ]);
        return $serviceResponse;
    }


    /**
     * Get a specific Contact by ID
     * @param int $id
     * @return ServiceResponse
     */
    public function getContactByID($id)
    {
        $contact = $this->contactRepository->findContactByID($id);
        if ($contact) {
            $serviceResponse = new ServiceResponse('Ok', ServiceResponseStatus::$RESPONSE_OK, [
                'contact' => $contact
            ]);
        } else {
            $serviceResponse = new ServiceResponse('Contato não encontrado', ServiceResponseStatus::$RESPONSE_NOK);
        }
        return $serviceResponse;
    }

    /**
     * Save a Contact
     * @param Contact $contact
     * @return ServiceResponse
     */
    public function save(Contact $contact)
    {
        $authenticateService = new AuthenticateService();
        $user = $authenticateService->getUserSession();
        if ($user->getPlan()->getId() !== PlanType::UNLIMITED) {
            $totalUserContact = (int)$this->contactRepository->countContactByUserID($user->getId());
            if ($totalUserContact >= $user->getPlan()->getLimit()) {
                $serviceResponse = new ServiceResponse('Você já possui o número máximo de contatos para o plano '
                    . $user->getPlan()->getName() . ' contrate um plano com limite maior.', ServiceResponseStatus::$RESPONSE_NOK);
                return $serviceResponse;
            }
        }
        $findContact = $this->contactRepository->findContactByNumber($contact->getNumber(), $user->getId());
        if ($findContact) {
            $serviceResponse = new ServiceResponse('Você já possui um contato com este número chamado '
                . $findContact->getName(), ServiceResponseStatus::$RESPONSE_NOK);
            return $serviceResponse;
        }
        $contact->setUser($user);
        if (!$this->contactRepository->save($contact)) {
            $serviceResponse = new ServiceResponse('Erro ao salvar contato', ServiceResponseStatus::$RESPONSE_NOK);
            return $serviceResponse;
        }
        $serviceResponse = new ServiceResponse('Contato adicionado na sua lista', ServiceResponseStatus::$RESPONSE_OK);
        return $serviceResponse;
    }


    /**
     * Update a Contact
     * @param Contact $contact
     * @return ServiceResponse
     */
    public function update(Contact $contact)
    {
        $authenticateService = new AuthenticateService();
        $user = $authenticateService->getUserSession();
        $findContact = $this->contactRepository->findContactByNumber($contact->getNumber(), $user->getId(), $contact->getId());
        if ($findContact) {
            $serviceResponse = new ServiceResponse('Você já possui um contato com este número chamado '
                . $findContact->getName(), ServiceResponseStatus::$RESPONSE_NOK);
            return $serviceResponse;
        }
        $this->contactRepository->update($contact);
        $serviceResponse = new ServiceResponse('Contato atualizado', ServiceResponseStatus::$RESPONSE_OK);
        return $serviceResponse;
    }

    /**
     * Remove a Contact
     * @param Contact $contact
     * @return ServiceResponse
     */
    public function delete(Contact $contact)
    {
        $this->contactRepository->delete($contact);
        $serviceResponse = new ServiceResponse('Contato removido com sucesso', ServiceResponseStatus::$RESPONSE_OK);
        return $serviceResponse;
    }

}