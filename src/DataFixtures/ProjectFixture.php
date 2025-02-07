<?php

namespace App\DataFixtures;

use App\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProjectFixture extends Fixture
{
    const PROJECT_REFERENCE_PREFIX = 'project_';

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $project = new Project();
            $project->setName('Project ' . $i);
            $manager->persist($project);
            $this->addReference(self::PROJECT_REFERENCE_PREFIX . $i, $project);
        }

        $manager->flush();
    }
}
