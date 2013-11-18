<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 15.11.13
 * Time: 18:28
 */

namespace Spb\RestBundle\Controller;


use Spb\RestBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class UsersController extends Controller
{

    public function getUsersAction()
    {
        /**
         * @return array
         * @View:()
         */
        $users = $this->getDoctrine()->getRepository('SpbRestBundle:User')
            ->findAll();

        return array('users' => $users);
    }

    /**
     * @param User $user
     * @return array
     * @View
     * @ParamConverter ("user", class="RestApiBundle:Users")
     */
    public function getUserAction(User $user)
    {
        return array('user' => $user);
    }
} 