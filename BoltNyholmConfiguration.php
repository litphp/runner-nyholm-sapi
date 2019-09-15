<?php

declare(strict_types=1);

namespace Lit\Runner\NyholmSapi;

use Lit\Air\Configurator as C;
use Lit\Bolt\BoltApp;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Http\Message\ResponseFactoryInterface;

class BoltNyholmConfiguration
{
    public static function default()
    {
        return [
            BoltNyholmRunner::class => C::provideParameter([
                C::alias(ServerRequestCreator::class),
                C::alias(BoltApp::class),
            ]),
            ServerRequestCreator::class => C::provideParameter([
                C::produce(Psr17Factory::class),
                C::produce(Psr17Factory::class),
                C::produce(Psr17Factory::class),
                C::produce(Psr17Factory::class),
            ]),
            ResponseFactoryInterface::class => C::produce(Psr17Factory::class),
        ];
    }
}
