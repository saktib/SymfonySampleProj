<?php

namespace AppBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * The create.account event is dispatched each time an order is created with order amount greater than 100
 */
class CreateAccountsEvent extends Event
{
    const NAME = 'create.account';

    protected $account;

    public function __construct()
    {
        $this->createAccount();
    }

    public function createAccount()
    {
        echo  "Creating accounts entry";
    }
}