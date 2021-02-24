<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Soutenance;
use App\Entity\Commentaire;
use Faker\Provider\en_US\Person;

class SoutenanceFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
        for($i = 1; $i<=10;$i++){
            $soutenance = new Soutenance();
            $commentaire = new Commentaire();
           $commentaire->setAuteur($faker->name)->setContenu($faker->text)->setNote(17)->setSoutenance($soutenance);
            $soutenance->setTitre("Soutenance n°$i")
                        ->setImage("https://i.picsum.photos/id/1002/200/300.jpg?hmac=QAnT71VGihaxEf_iyet9i7yb3JvYTzeojsx-djd3Aos")
                        ->setDescription($faker->paragraph())
                        ->setDateSoutenance(new \DateTime())
                        ->setNote($faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 20))->addCommentaire($commentaire);
                        $manager->persist($commentaire);
                        $manager->persist($soutenance);
        }

        $manager->flush();
    }
}
