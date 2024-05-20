<?php

namespace App\Guard;

use App\Entity\User;
use App\Exception\Request\ForbiddenRequestException;

class UserResourceGuard 
{
    public static function RequestUserResourceAccess(User $requester, int $requestedId): void
    {   
        $requesterId = $requester->getId();
        
        if ($requesterId !== $requestedId) {
            throw new ForbiddenRequestException();
        }
    }
}