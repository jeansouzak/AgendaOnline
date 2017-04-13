<?php
/**
 * User: jean.souza
 * Date: 07/04/17
 * Time: 00:43
 */

namespace Domain\Service\Response;


interface ServiceResponseInterface
{

    /**
     * Return message from service
     * @return string
     */
    public function getMessage();

    /**
     * Return status from service
     * @return mixed
     */
    public function getStatus();

    /**
     * Set service message

     */
    public function setMessage($message);

    /**
     * Set service status

     */
    public function setStatus($status);

    /**
     * @return array
     */
    public function getBag();

    /**
     * Find an item on bag
     * @param string $alias
     * @return mixed
     */
    public function getBagItem($alias);

    /**
     * @param array $bag
     */
    public function setBag(array $bag);


}