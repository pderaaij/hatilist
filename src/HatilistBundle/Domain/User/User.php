<?php
declare(strict_types=1);

namespace HatilistBundle\Domain\User;

use FOS\UserBundle\Model\User as BaseUser;

class User extends BaseUser
{

    protected $id;

    public function __construct()
    {
        parent::__construct();
    }
}