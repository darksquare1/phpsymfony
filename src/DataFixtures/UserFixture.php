<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $tasks = $manager->getRepository(Task::class)->findAll();

        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setEmail("user{$i}@example.com");
            $user->setUsername("User{$i}");
            $user->setRoles(['ROLE_USER']);
            $hashedPassword = $this->passwordHasher->hashPassword($user, 'password');
            $user->setPassword($hashedPassword);
            $taskAmount = rand(3, 5);
            $userTasks = array_slice($tasks, $i * $taskAmount, $taskAmount);

            foreach ($userTasks as $task) {
                $task->setUser($user);
                $manager->persist($task);
            }

            $manager->persist($user);
        }

        $manager->flush();
    }

}
