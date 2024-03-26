<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Room;
use App\Entity\User;
use App\Entity\Equipment;
use App\Entity\Ergonomy;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Set admin
        $admin = new User();
        $admin->setEmail('admin@admin.fr')
            ->setRoles(['ROLE_ADMIN'])
            ->setName('Admin')
            ->setPassword('$2y$13$wqXiXE8U6QhYtIRJFedLA.MkNVmDzn89jVz5CBYENUOwHfAlyYNG2')
            ->setAddress($faker->address);
        $manager->persist($admin);



        // Set equipments
        $equipments = ['wifi', 'tv', 'climatiseur', 'projecteur', 'fenetre'];
        $equipmentArray = [];
        for ($i = 0; $i < count($equipments); $i++) {
            $equipment = new Equipment();
            $equipment->setName($equipments[$i])
                ->setDescription($faker->text(255))
                ->setQuantity($faker->numberBetween(1, 10))
                ->setIcone('fa fa-' . $equipments[$i]);

            $manager->persist($equipment);
            array_push($equipmentArray, $equipment);
        }

        // Set rooms
        $roomImages = ['salle1.jpg', 'salle2.jpg', 'salle3.jpg', 'salle4.jpg', 'salle5.jpg'];
        for ($i = 0; $i < 20; $i++) {

            $room = new Room();
            $room->setTitle($faker->text(50))
                ->setSurface($faker->randomNumber(3))
                ->setAddress($faker->address)
                ->SetCapacity($faker->randomNumber(4))
                ->setDescription($faker->text(255))
                ->setPrice($faker->numberBetween(150, 1500))
                ->setImageMain($faker->randomElement($roomImages));
            $manager->persist($room);
            $manager->flush();
        }

        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setEmail('user' . $i . '@user.fr')
                ->setRoles(['ROLE_USER'])
                ->setName($faker->Name)
                ->setPhone($faker->phoneNumber)
                ->setPassword('$2y$13$wqXiXE8U6QhYtIRJFedLA.MkNVmDzn89jVz5CBYENUOwHfAlyYNG2')
                ->setAddress($faker->address);
            $manager->persist($user);
            $manager->flush();
        }

        $ergonomics = ['lumiere naturelle', 'lumiere artificielle', 'acces PMR', 'isolation phonique'];
        for ($i = 0; $i <= 4; $i++) {
            $ergonomy = new Ergonomy();
            $ergonomy
                ->setDecription($faker->text(255))
                ->setName($faker->randomElement($ergonomics))
                ->setIcone('fa fa-');
            $manager->persist($ergonomy);
            $manager->flush();
        }
    }
}