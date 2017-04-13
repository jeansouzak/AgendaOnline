<?php
/**
 * User: jean.souza
 * Date: 06/04/17
 * Time: 16:34
 */

namespace Application\Controller;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ApplicationController
{
    public function index(ServerRequestInterface $request, ResponseInterface $response)
    {
        $response->getBody()->write($this->renderView('index.php'));
        return $response;
    }

    /**
     * @param $viewName string with name of view
     * @param array $params parameters to send to view
     * @return string html response
     */
    public function renderView($viewName, array $params = [])
    {

        $loader = new \Twig_Loader_Filesystem(ROOT_DIR . '/application/resources/view/');
        $twig = new \Twig_Environment($loader);
        $twig->addFunction(new \Twig_SimpleFunction('asset', function ($asset) {
            return sprintf('/application/resources/%s', ltrim($asset, '/'));
        }));

        return $twig->render($viewName, $params);
    }


}