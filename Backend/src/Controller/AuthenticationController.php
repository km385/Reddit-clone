<?php

namespace App\Controller;

use ApiPlatform\Api\IriConverterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use App\Entity\User;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthenticationController extends AbstractController
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
    public function loginJson(IriConverterInterface $ireConverter, #[CurrentUser] ?User $user): Response
    {
        if ($user === null) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        // return new Response(null, 204, [
        //     'Location' => $ireConverter->getIriFromResource($user),
        // ]);
        return $this->json([
            'user' => $ireConverter->getIriFromResource($user),
        ]);
        // $token = "...";
        // return $this->json([
        //     'user' => $user->getId(),
        //     'token' => $token,
        // ]);
    }
}
