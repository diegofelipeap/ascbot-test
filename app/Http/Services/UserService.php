<?php

namespace App\Http\Services;

use App\Repositories\UserRepository;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUser(array $data)
    {
        return $this->userRepository->create($data);
    }

    public function findUserByEmail(string $email)
    {
        return $this->userRepository->findByEmail($email);
    }

}
