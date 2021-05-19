<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use http\Client\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserManager
{
    private $em;
    private $encoder;
    private $validator;

    public function __construct(EntityManagerInterface $em,UserPasswordEncoderInterface $encoder, ValidatorInterface $validator)
    {
        $this->validator = $validator;
        $this->em = $em;
        $this->encoder = $encoder;
    }

    public function addAnUserWithManagerRole(User $user)
    {
        $user->setPassword($this->encoder->encodePassword($user, $user->getPassword()));
        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {

            $errorsString = (string) $errors;

            dump($errorsString);
            return new \Symfony\Component\HttpFoundation\Response($errorsString);
        }

        $this->em->persist($user);
        $this->em->flush();
        dump("The user is valid !");
        return new \Symfony\Component\HttpFoundation\Response('The user is valid !');
    }
}
