<?php

namespace Domain\Service\Response;


class ServiceResponse implements ServiceResponseInterface
{
    private $message;
    private $status;
    private $bag;

    public function __construct($message = 'Ok', $status = 1, $bag = [])
    {
        $this->message = $message;
        $this->status = $status;
        $this->bag = $bag;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return array
     */
    public function getBag()
    {
        return $this->bag;
    }

    /**
     * @param array $bag
     */
    public function setBag(array $bag)
    {
        $this->bag = $bag;
    }

    public function getBagItem($alias)
    {
        if (!array_key_exists($alias, $this->bag)) {
            throw new BagItemNotFoundException;
        }
        return $this->bag[$alias];
    }


}