<?php
// src/Controller/ApiController.php
namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/api/users', name: 'get_users', methods: ['GET'])]
    public function getUsers(UserRepository $userRepository): JsonResponse
    {
        $users = $userRepository->findAll();

        $data = [];
        foreach ($users as $user) {
            $addresses = [];
            foreach ($user->getAddresses() as $address) {
                $services = [];
                foreach ($address->getServices() as $service) {
                    $services[] = [
                        'internet' => $service->getInternet(),
                        'tv' => $service->getTv(),
                        'ip' => $service->getIp(),
                    ];
                }

                $addresses[] = [
                    'address' => $address->getAddress(),
                    'status' => $address->getStatus(),
                    'tariff' => $address->getTariff(),
                    'balance' => $address->getBalance(),
                    'services' => $services,
                ];
            }

            $data[] = [
                'username' => $user->getUsername(),
                'password' => $user->getPassword(),
                'phone' => $user->getPhone(),
                'email' => $user->getEmail(),
                'language' => $user->getLanguage(),
                'theme' => $user->getTheme(),
                'deviceId' => $user->getDeviceId(),
                'addresses' => $addresses,
            ];
        }

        return $this->json($data);
    }

    #[Route('/api/users/{id}', name: 'get_user', methods: ['GET'])]
    public function getUserById(int $id, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->find($id);

        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }

        $addresses = [];
        foreach ($user->getAddresses() as $address) {
            $services = [];
            foreach ($address->getServices() as $service) {
                $services[] = [
                    'internet' => $service->getInternet(),
                    'tv' => $service->getTv(),
                    'ip' => $service->getIp(),
                ];
            }

            $addresses[] = [
                'address' => $address->getAddress(),
                'status' => $address->getStatus(),
                'tariff' => $address->getTariff(),
                'balance' => $address->getBalance(),
                'services' => $services,
            ];
        }

        return $this->json([
            'username' => $user->getUsername(),
            'password' => $user->getPassword(),
            'phone' => $user->getPhone(),
            'email' => $user->getEmail(),
            'language' => $user->getLanguage(),
            'theme' => $user->getTheme(),
            'deviceId' => $user->getDeviceId(),
            'addresses' => $addresses,
        ]);
    }
}
