<?php

namespace App\DTO\Interface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

interface RequestDTOInterface {
    public function createFromRequest(Request $request, ValidatorInterface $validator): RequestDTOInterface;
}