<?php
namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Address;
use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        // Створюємо послуги
        $service1 = new Service();
        $service1->setInternet("Unlim 1000");
        $service1->setTv("omega 60");
        $service1->setIp("10.10.10.10");

        $service2 = new Service();
        $service2->setInternet("Unlim 500");
        $service2->setTv("omega 30");
        $service2->setIp("10.10.10.11");

        $manager->persist($service1);
        $manager->persist($service2);

        // Створюємо першого користувача
        $user1 = new User();
        $user1->setUsername('domo00000');
        $hashedPassword1 = $this->passwordHasher->hashPassword($user1, '1');
        $user1->setPassword($hashedPassword1);
        $user1->setPhone('000000000');
        $user1->setEmail('test1@test.ua');
        $user1->setLanguage('uk');
        $user1->setTheme('light');
        $user1->setDeviceId('');

        // Створюємо адреси для першого користувача
        $address1_1 = new Address();
        $address1_1->setAddress("34 кв. Академіка Ломоносова, 36");
        $address1_1->setStatus("active");
        $address1_1->setTariff("Unlim 1000");
        $address1_1->setBalance(230);
        $address1_1->addService($service1);  // Додаємо послугу до адреси
        $address1_1->setUser($user1);  // Додаємо зв'язок з користувачем

        $address1_2 = new Address();
        $address1_2->setAddress("25 кв. Богдана Хмельницького, 12");
        $address1_2->setStatus("disable");
        $address1_2->setTariff("Unlim 1000");
        $address1_2->setBalance(-1);
        $address1_2->addService($service2);  // Додаємо послугу до адреси
        $address1_2->setUser($user1);  // Додаємо зв'язок з користувачем

        $user1->addAddress($address1_1);
        $user1->addAddress($address1_2);

        $manager->persist($user1);

        // Створюємо другого користувача
        $user2 = new User();
        $user2->setUsername('john_doe');
        $hashedPassword2 = $this->passwordHasher->hashPassword($user2, '2');
        $user2->setPassword($hashedPassword2);
        $user2->setPhone('111111111');
        $user2->setEmail('test2@test.ua');
        $user2->setLanguage('en');
        $user2->setTheme('dark');
        $user2->setDeviceId('');

        // Створюємо адреси для другого користувача
        $address2_1 = new Address();
        $address2_1->setAddress("100 вул. Петра Сагайдачного, 5");
        $address2_1->setStatus("active");
        $address2_1->setTariff("Unlim 1000");
        $address2_1->setBalance(150);
        $address2_1->addService($service1);  // Додаємо послугу до адреси
        $address2_1->setUser($user2);  // Додаємо зв'язок з користувачем

        $address2_2 = new Address();
        $address2_2->setAddress("200 вул. Лесі Українки, 15");
        $address2_2->setStatus("active");
        $address2_2->setTariff("Unlim 500");
        $address2_2->setBalance(50);
        $address2_2->addService($service2);  // Додаємо послугу до адреси
        $address2_2->setUser($user2);  // Додаємо зв'язок з користувачем

        $user2->addAddress($address2_1);
        $user2->addAddress($address2_2);

        $manager->persist($user2);

        // Завершуємо збереження користувачів і їх адрес
        $manager->flush();
    }
}
