<?php

namespace App\State\Persisters;

use App\Entity\Community;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class CommunityStateProcessor implements ProcessorInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')] 
        private ProcessorInterface $processor,
        private Security $security
    ) {
    }
    /**
     * @param Community $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Community
    {
        //Set user from token as creator
        if ($data->getCreator() != null) {
            return $this->processor->process($data, $operation, $uriVariables, $context);
        }
        $data->setCreator($this->security->getUser());

        return $this->processor->process($data, $operation, $uriVariables, $context);
    }
}
