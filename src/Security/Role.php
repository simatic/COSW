<?php

namespace App\Security;

abstract class Role {

    public const USER = "ROLE_USER";
    public const ADMIN = "ROLE_ADMIN";
    public const GUEST = "ROLE_GUEST";
    public const CREATOR = "ROLE_CREATOR";

}