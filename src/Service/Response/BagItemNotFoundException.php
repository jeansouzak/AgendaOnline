<?php
/**
 * Created by PhpStorm.
 * User: jean.souza
 * Date: 07/04/17
 * Time: 02:59
 */

namespace Domain\Service\Response;


use Exception;

class BagItemNotFoundException extends \Exception
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct('Item alias not found on Bag.', $code, $previous);
    }

}