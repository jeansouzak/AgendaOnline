<?php

namespace Infrastructure\Pdo\Repository;


use Domain\Entity\Contact;
use Domain\Entity\User;
use Domain\Repository\ContactRepositoryInterface;
use Infrastructure\Pdo\Connection\Db;

class ContactRepository implements ContactRepositoryInterface
{
    private $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    public function findContactsByUserID($userID)
    {
        $stmt = $this->db->prepare('SELECT id, user_id as user, name, email, number, born_day as bornDay, born_month as bornMonth
                                    FROM contact WHERE user_id = :id ORDER BY name');
        $stmt->execute([
            'id' => $userID
        ]);

        $contacts = [];
        while ($contact = $stmt->fetchObject(Contact::class)) {
            $contacts[] = $contact;
        }
        return $contacts;

    }

    public function update(Contact $contact)
    {
        $stmt = $this->db->prepare('UPDATE contact SET name = :name, email = :email, number = :number,
                                            born_day = :bornDay, born_month = :bornMonth WHERE id = :id');

        $name = $contact->getName();
        $email = $contact->getEmail();
        $number = $contact->getNumber();
        $contactID = $contact->getId();
        $bornDay = $contact->getBornDay();
        $bornMonth = $contact->getBornMonth();

        $stmt->bindParam('name', $name, \PDO::PARAM_STR);
        $stmt->bindParam('email', $email, \PDO::PARAM_STR);
        $stmt->bindParam('number', $number, \PDO::PARAM_STR);
        $stmt->bindParam('id', $contactID, \PDO::PARAM_INT);
        $stmt->bindParam('bornDay', $bornDay, \PDO::PARAM_INT);
        $stmt->bindParam('bornMonth', $bornMonth, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function save(Contact $contact)
    {
        $stmt = $this->db->prepare('INSERT INTO contact(name, email, number, user_id, born_day, born_month)
        VALUES (:name, :email, :number, :user, :bornDay, :bornMonth)');

        $name = $contact->getName();
        $email = $contact->getEmail();
        $number = $contact->getNumber();
        $userID = $contact->getUser()->getId();
        $bornDay = $contact->getBornDay();
        $bornMonth = $contact->getBornMonth();

        $stmt->bindParam('name', $name, \PDO::PARAM_STR);
        $stmt->bindParam('email', $email, \PDO::PARAM_STR);
        $stmt->bindParam('number', $number, \PDO::PARAM_STR);
        $stmt->bindParam('user', $userID, \PDO::PARAM_INT);
        $stmt->bindParam('bornDay', $bornDay, \PDO::PARAM_INT);
        $stmt->bindParam('bornMonth', $bornMonth, \PDO::PARAM_INT);


        return $stmt->execute();

    }


    public function delete(Contact $contact)
    {
        $stmt = $this->db->prepare('DELETE FROM contact WHERE id = :id');
        $contactID = $contact->getId();
        $stmt->bindParam('id', $contactID, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function findContactByID($contactID)
    {
        $stmt = $this->db->prepare('SELECT id, user_id as user, name, email, number, born_day as bornDay, born_month as bornMonth
                                    FROM contact WHERE id = :id');
        $stmt->execute([
            'id' => $contactID
        ]);

        return $stmt->fetchObject(Contact::class);
    }

    public function findContactByNumber($phoneNumber, $userID, $excludeID = null)
    {
        if ($excludeID) {
            $stmt = $this->db->prepare('SELECT id, user_id as user, name, email, number, born_day as bornDay, born_month as bornMonth
                                    FROM contact WHERE user_id = :id AND number = :nb AND id <> :excludeID');
            $stmt->bindParam('excludeID', $excludeID, \PDO::PARAM_INT);
        } else {
            $stmt = $this->db->prepare('SELECT id, user_id as user, name, email, number, born_day as bornDay, born_month as bornMonth
                                    FROM contact WHERE user_id = :id AND number = :nb');
        }
        $stmt->bindParam('id', $userID, \PDO::PARAM_INT);
        $stmt->bindParam('nb', $phoneNumber, \PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchObject(Contact::class);
    }

    public function countContactByUserID($userID)
    {
        $stmt = $this->db->prepare('SELECT count(*)
                                    FROM contact WHERE user_id = :id');
        $stmt->execute([
            'id' => $userID
        ]);

        return $stmt->fetchColumn();
    }


}