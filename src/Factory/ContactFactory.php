<?php

namespace Domain\Factory;


use Domain\Entity\Contact;

class ContactFactory
{
    /**
     * Create a Contact Object from array
     * @param array $params
     * @return Contact
     * @throws \InvalidArgumentException
     */
    public static function createFromArray(array $params)
    {
        if (empty($params['name']) ||
            empty($params['number'])
        ) {
            throw new \InvalidArgumentException('Campo nome e número são obrigatórios.');
        }
        $contact = new Contact();
        $contact->setId(!empty($params['id']) ? $params['id'] : null);
        $contact->setName($params['name']);
        $contact->setNumber($params['number']);
        $contact->setEmail(!empty($params['email']) ? $params['email'] : null);
        $contact->setBornDay(!empty($params['born_day']) ? $params['born_day'] : null);
        $contact->setBornMonth(!empty($params['born_month']) ? $params['born_month'] : null);

        return $contact;
    }

}