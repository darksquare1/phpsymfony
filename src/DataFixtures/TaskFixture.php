<?php

namespace App\DataFixtures;

use App\Entity\Project;
use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TaskFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $projects = $manager->getRepository(Project::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();
        foreach ($projects as $project) {
            for ($i = 0; $i < rand(5, 10); $i++) {
                $task = new Task();
                $task->setName('Task ' . $i);
                $task->setDescription('Task description ' . $i);
                $task->setProject($project);
                $user = $users[array_rand($users)];
                $task->setUser($user);
                $manager->persist($task);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [ProjectFixture::class, UserFixture::class];
    }
}
