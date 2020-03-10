<?php

namespace App\DataFixtures;

use App\Entity\Equipment;
use App\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProjectFixture extends Fixture
{
    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $project = new Project();
        $project->setName("test01");
        $project->setDescription("testDescription01");
        $project->setEstimatedDuration(1);
        $project->setType("SEWING");
        $manager->find(Project::class,1);

        $equipment = new Equipment();
        $equipment->setQuantity("150g");
        $equipment->setType("wool");
        $equipment->setColor("RED");
        $equipment->setQuantity("150g");

        $project->addEquipment($equipment);

        $manager->persist($project);
        $manager->flush();
    }
}
