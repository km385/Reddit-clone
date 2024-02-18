<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use App\Entity\User;
use App\Entity\AccessToken;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class AccessController extends AbstractController
{
    //TODO: remove
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('authentication/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(
        path: '/login_json',
        name: 'json_app_login',
        methods: ['POST'],
    )]
    public function loginJson(#[CurrentUser] ?User $user, EntityManagerInterface $entityManager, Request $request): Response
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
        ->setExpiresAt(new \DateTimeImmutable('+6 hour'));

        $entityManager->persist($authenticationToken);
        $entityManager->flush();

        return $this->json([
            'token' => $authenticationToken->getToken(),
            'user' => $user->getUserIdentifier(),
        ]);
    }
}
