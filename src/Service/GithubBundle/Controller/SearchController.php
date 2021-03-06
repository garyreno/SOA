<?php

namespace Service\GithubBundle\Controller;

use Service\GithubBundle\Libraries\Manager as GithubManager;
use \Library\ManagerBundle\Abstracts\Controller as ControllerAbstract;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends ControllerAbstract
{

    protected function _getManager(Request $request)
    {
        return new GithubManager($request);
    }

}
