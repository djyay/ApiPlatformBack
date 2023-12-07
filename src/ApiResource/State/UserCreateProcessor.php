<?php

namespace App\ApiResource\State;

use App\ApiResource\DTO\UserDTO;
use App\Dto\UserResetPasswordDto;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCreateProcessor implements ProcessorInterface
{
    public function __construct(UserPasswordHasherInterface $userPasswordHasher, LoggerInterface $logger, EntityManagerInterface $entityManager)
    {
        $this->userPasswordHasher = $userPasswordHasher;
        $this->logger = $logger;
        $this->entityManager = $entityManager;
    }

    /**
     * @param UserResetPasswordDto $data
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = [])
    {

        if($data instanceof UserDTO){
            $user = new User();
            $user->setRoles(['ROLE_USER']);
            $user->setEmail($data->getEmail());
            $user->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user,
                    $data->getPassword()
                )
            );
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            return $user;
         }

        throw new NotFoundHttpException();
    }
}
