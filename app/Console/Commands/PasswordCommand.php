<?php

namespace App\Console\Commands;

use App\Entity\User\User;
use Illuminate\Console\Command;

class PasswordCommand extends Command
{
    protected $signature = 'user:password {email} {password}';

    protected $description = 'Set password for user';

    public function handle(): bool
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        /** @var User $user */
        if (!$user = User::where('email', $email)->first()) {
            $this->error('Undefined user with email ' . $email);
            return false;
        }

        try {
            $user->setPassword($password);
        } catch (\DomainException $e) {
            $this->error($e->getMessage());
            return false;
        }

        $this->info('Password is successfully changed');
        return true;
    }
}
