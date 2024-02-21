<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use App\Entity\User;
use App\Entity\AccessToken;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Api\IriConverterInterface;

class AccessController extends AbstractController
{

    #[Route(path: '/login', name: 'app_login')]
    public function login(): Response
    {
        return $this->render('authentication/login.html.twig');
    }

    #[Route(
        path: '/login_json',
        name: 'json_app_login',
        methods: ['POST'],
    )]
    public function loginJson(#[CurrentUser] ?User $user, EntityManagerInterface $entityManager,IriConverterInterface $iriConverter, Request $request): Response
    {
        $userIp = $request->getClientIp();

        if ($user === null) {
            return $this->json(
                [
                    'message' => 'missing credentials',
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }
        $authenticationToken = (new AccessToken())
        ->setOwnedBy($user)
        ->setUserAddress($userIp)
        //TODO: ADD remember me boolean and null as expiration
        ->setExpiresAt(new \DateTimeImmutable('+1 day'));

        $entityManager->persist($authenticationToken);
        $entityManager->flush();

        return $this->json([
            'token' => $authenticationToken->getToken(),
            'login' => $user->getUserIdentifier(),
            'IRS' => $iriConverter->getIriFromResource($user),
        ]);
    }
}
