<?php

namespace App\DataFixtures;

use App\Entity\ProjectsGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProjectGroupsFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $projectGroup = new ProjectsGroup();
            $projectGroup->setName('Project Group ' . $i);
            $manager->persist($projectGroup);
            $projects_amount = random_int(1, 4);
            for ($j = 0; $j < $projects_amount; $j++) {
                $project = $this->getReference(ProjectFixture::PROJECT_REFERENCE_PREFIX . rand(0, 9));
                $projectGroup->addProject($project);
            }
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [ProjectFixture::class];
    }
}