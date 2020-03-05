<?php

namespace App\DataFixtures;

use App\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProjectFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $project = new Project();
        $project->setName("test01");
        $project->setDescription("testDescription01");
        $project->setEstimatedDuration(1);
        $project->setType("SEWING");
        $manager->persist($project);

        $manager->flush();
    }
}
