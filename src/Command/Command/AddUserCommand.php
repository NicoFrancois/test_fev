<?php

namespace App\Command\Command;

use DateTime;

class AddUserCommand
{
    /** @var int */
    public $id;

    /** @var string */
    public $firstName;

    /** @var string */
    public $lastName;

    /** @var DateTime */
    public $birthDate;
}