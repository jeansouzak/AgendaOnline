<?php
/**
 * Created by PhpStorm.
 * User: jean.souza
 * Date: 07/04/17
 * Time: 02:13
 */

namespace Domain\Repository;


use Domain\Entity\Contact;
use Domain\Entity\User;

interface ContactRepositoryInterface
{

    /**
     * @param int $userID
     * @return []
     */
    public function findContactsByUserID($userID);

    /**
     * @param Contact $contact
     * @return bool
     */
    public function update(Contact $contact);

    /**
     * @param Contact $contact
     * @return bool
     */
    public function save(Contact $contact);

    /**
     * @param Contact $contact
     * @return bool
     */
    public function delete(Contact $contact);

    /**
     * @param $contactID
     * @return Contact
     */
    public function findContactByID($contactID);

    /**
     * @param string $phoneNumber
     * @param int $userID id online user
     * @param int $excludeID id to ignore on query
     * @return Contact
     */
    public function findContactByNumber($phoneNumber, $userID, $excludeID = null);


    /**
     * @param $userID
     * @return int
     */
    public function countContactByUserID($userID);

}