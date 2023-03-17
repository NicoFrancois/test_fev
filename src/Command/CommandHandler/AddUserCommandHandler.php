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

        $birthDate = ($command->birthDate)->format("Y-m-d");
        $today = date("Y-m-d");
        $age = date_diff(date_create($birthDate), date_create($today));

        if ($age->format('%y') < User::AGE_LIMIT){
            $user->setFirstName($command->firstName);
            $user->setLastName($command->lastName);
            $user->setCreationDate(new \DateTime());
            $user->setBirthDate($command->birthDate);

            $this->repository->save($user);
        } else {
            throw new \Exception('Sorry - age exceeds age limit (150)');
        }
    }
}