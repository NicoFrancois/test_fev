<?php

namespace App\Command\CommandHandler;

use App\Command\Command\AddUserCommand;
use App\Entity\User;
use App\Repository\UserRepository;
use DateTime;

class AddUserCommandHandler
{
    /** @var UserRepository $repository */
    private $repository;

    /**
     * AddUserCommandHandler constructor.
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param AddUserCommand $command
     * @throws \Exception
     */
    public function handle(AddUserCommand $command)
    {
        $user = new User();

        $ageYear = explode('/', $command->birthDate->format('Y'));
        $now = explode('/', date('Y'));

        if (($now[0] - $ageYear[0]) > 150){
            throw new \Exception('Error - age exceeds age limit (150)');
        } else {
            $user->setFirstName($command->firstName);
            $user->setLastName($command->lastName);
            $user->setCreationDate(new \DateTime());
            $user->setBirthDate($command->birthDate);

            $this->repository->save($user);
        }
    }
}