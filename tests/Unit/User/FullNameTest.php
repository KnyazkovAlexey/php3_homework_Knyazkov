<?php

namespace Tests\Unit\User;

use App\Models\User;
use Tests\TestCase;

class FullNameTest extends TestCase
{
    public function testFull()
    {
        $user = factory(User::class)->make([
            'name'       => 'Иван',
            'patronymic' => 'Иванович',
            'surname'    => 'Иванов',
        ]);

        $this->assertEquals($user->getFullName(), 'Иван Иванович Иванов');
    }

    public function testEmptyPatronymic()
    {
        $user = factory(User::class)->make([
            'name'       => 'Иван',
            'patronymic' => null,
            'surname'    => 'Иванов'
        ]);

        $this->assertEquals($user->getFullName(), 'Иван Иванов');
    }

    public function testEmptyName()
    {
        $user = factory(User::class)->make([
            'name'       => null,
            'patronymic' => 'Иванович',
            'surname'    => 'Иванов',
            'email'      => 'ivanov@test.com',
        ]);

        $this->assertEquals($user->getFullName(), 'ivanov@test.com');
    }

    public function testEmptySurname()
    {
        $user = factory(User::class)->make([
            'name'       => 'Иван',
            'patronymic' => 'Иванович',
            'surname'    => null,
            'email'      => 'ivanov@test.com',
        ]);

        $this->assertEquals($user->getFullName(), 'ivanov@test.com');
    }

    public function testBlank()
    {
        $user = factory(User::class)->make([
            'name'       => null,
            'patronymic' => null,
            'surname'    => null,
            'email'      => null,
        ]);

        $this->assertEquals($user->getFullName(), null);
    }
}
