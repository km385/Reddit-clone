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
use App\Repository\AccessTokenRepository;

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
    public function loginJson(#[CurrentUser] ?User $user, EntityManagerInterface $entityManager, IriConverterInterface $iriConverter, Request $request): Response
    {
        if (!$user) {
            return $this->json(['message' => 'Invalid credentials.'], Response::HTTP_UNAUTHORIZED);
        }
    
        $requestData = json_decode($request->getContent());
        $rememberMe = isset($requestData->remember_me) && $requestData->remember_me == true ? true : false;

        $authenticationToken = (new AccessToken())
            ->setOwnedBy($user)
            ->setUserAddress($request->getClientIp())
            ->setExpiresAt($rememberMe ? null : new \DateTimeImmutable('+1 day'));
    
        $entityManager->persist($authenticationToken);
        $entityManager->flush();
    
        return $this->json(
            [
                'token' => $authenticationToken->getToken(),
                'login' => $user->getUserIdentifier(),
                'IRS' => $iriConverter->getIriFromResource($user),
            ],
            Response::HTTP_CREATED
        );
    }
    

    #[Route(
        path: '/logout_json',
        name: 'json_app_logout',
        methods: ['POST'],
        format: 'json',
    )]
    public function logout(EntityManagerInterface $entityManager, AccessTokenRepository $repository, Request $request): Response
    {
        $requestData = $request->headers->get('Authorization');
        $token = str_replace('Bearer ', '', $requestData);
        $accessTokens = $repository->findBy(['token' => $token]);
        $accessToken = $accessTokens[0];

        $requestData = json_decode($request->getContent());
        if(isset($requestData->logout_all) && $requestData->logout_all == true){
            $tokensWithSameOwner = $repository->findBy(['ownedBy' => $accessToken->getOwnedBy()]);
            foreach ($tokensWithSameOwner as $token) {
                $entityManager->remove($token);
            }
            $entityManager->flush();
        } else {
            $entityManager->remove($accessToken);
            $entityManager->flush();
        }

        return $this->json(['message' => 'Successfully logged out'], Response::HTTP_NO_CONTENT);
    }
}
