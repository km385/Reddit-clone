<?php

namespace App\State;

use App\Entity\Community;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Bundle\SecurityBundle\Security;

final readonly class CommunityCreatorSetter implements ProcessorInterface
{
    public function __construct(
        private ProcessorInterface $processor,
        private Security $security
    ) {
    }
    /**
     * @param Community $data
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Community
    {
        if ($data->getCreator() != null) {
            return $this->processor->process($data, $operation, $uriVariables, $context);
        }

        $data->setCreator($this->security->getUser());

        return $this->processor->process($data, $operation, $uriVariables, $context);
    }
}
