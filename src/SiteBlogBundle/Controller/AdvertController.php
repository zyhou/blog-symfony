<?php

namespace SiteBlogBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

class AdvertController
{
    public function indexAction()
    {
        return new Response("Hello World !");
    }
}
