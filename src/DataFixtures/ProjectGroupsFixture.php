<?php

namespace App\DataFixtures;

use App\Entity\ProjectsGroup;
use App\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class ProjectGroupsFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $projectGroup = new ProjectsGroup();
            $projectGroup->setName('Project Group ' . $i);
            $manager->persist($projectGroup);
            $projects_amount = random_int(1, 4);
            for ($j = 0; $j < $projects_amount; $j++) {
                $project = new Project();
                $project->setName('Project ' . $j);
                $projectGroup->addProject($project);
                $manager->persist($project);
            }
        }


        $manager->flush();
    }
}
