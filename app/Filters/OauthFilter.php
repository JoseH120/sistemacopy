<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

use App\Libraries\Oauth;
use OAuth2\Request;
use OAuth2\Response;


class OauthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $ouath = new Oauth();
        $request = Request::createFromGlobals();
        $response = new Response();
        if (!$ouath->server->verifyResourceRequest($request)) {
            $ouath->server->getResponse()->send();
            die();
        }
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
