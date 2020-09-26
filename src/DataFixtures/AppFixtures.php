<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $tasks = [
            ["title" => "Valider le projet 6", "done" => true],
            ["title" => "Faire un outil de Todo list", "done" => false, "description" => "Faire l'API permettant de faire fonctionner le front que vous avez à disposition"],
            ["title" => "Faire le projet 7", "done" => false],
            ["title" => "Fêter la validation du projet 7", "done" => false, "description" => "Ne pas oublier d'acheter le champagne"],
        ];

        foreach($tasks as $task) {
            $t = new Task();
            $t->setTitle($task['title'])
                ->setDone($task['done'])
                ->setDescription($task['description'] ?? '');

            $manager->persist($t);
        }

        $manager->flush();
    }
}
