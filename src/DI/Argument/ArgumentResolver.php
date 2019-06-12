<?php

declare(strict_types=1); // strict mode

namespace AwdStudio\DI\Argument;

final class ArgumentResolver
{

    /**
     * Resolves the particular argument type.
     *
     * @param string $argumentId
     *
     * @return string
     */
    public function resolve(string $argumentId): string
    {
        /** @var \AwdStudio\DI\Argument\Argument $resolverClass */
        foreach ($this->resolversList() as $resolverClass) {
            if ($resolverClass::isAppropriate($argumentId)) {
                /** @var \AwdStudio\DI\Argument\Argument $resolver */
                $resolver = new $resolverClass();

                return $resolver->resolve($argumentId);
            }
        }

        return $argumentId;
    }

    /**
     * Resolvers registry.
     *
     * @return \Generator
     */
    private function resolversList(): \Generator
    {
        yield SkippedArgument::class;
        yield NamedArgument::class;
    }

}
