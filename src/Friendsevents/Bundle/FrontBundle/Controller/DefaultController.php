<?php

namespace Friendsevents\Bundle\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('FriendseventsFrontBundle:Default:index.html.twig', array('name' => $name));
    }
}
