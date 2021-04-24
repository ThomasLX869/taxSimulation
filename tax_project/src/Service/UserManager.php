<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManager
{
    private $em;
    private $encoder;

    public function __construct(EntityManagerInterface $em,UserPasswordEncoderInterface $encoder)
    {
        $this->em = $em;
        $this->encoder = $encoder;
    }

    public function addAnUserWithManagerRole(User $user)
    {
        $user->setPassword($this->encoder->encodePassword($user, $user->getPassword()));
        //TODO check user data, mail is really unique ? Password is valid as symfony securities rules ? It's really a mail ?
        $this->em->persist($user);
        $this->em->flush();
    }
}
