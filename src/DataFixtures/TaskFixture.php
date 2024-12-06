<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TaskFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $task = new Task();
            $task->setName('Task ' . $i);
            $task->setDescription('Task description ' . $i);
            $project = $this->getReference(ProjectFixture::PROJECT_REFERENCE_PREFIX . $i);
            $project->addTask($task);
            $manager->persist($task);
        }

        $manager->flush();
    }
}
