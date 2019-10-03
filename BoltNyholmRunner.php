<?php

declare(strict_types=1);

namespace Lit\Runner\NyholmSapi;

use Lit\Bolt\BoltContainerConfiguration;
use Nyholm\Psr7Server\ServerRequestCreatorInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function Http\Response\send;

/**
 * nyholm runner
 */
class BoltNyholmRunner
{
    /**
     * @var RequestHandlerInterface
     */
    protected $handler;
    /**
     * @var ServerRequestCreatorInterface
     */
    protected $serverRequestCreator;

    /**
     * BoltNyholmRunner constructor.
     *
     * @param ServerRequestCreatorInterface $serverRequestCreator
     * @param RequestHandlerInterface       $handler
     */
    public function __construct(ServerRequestCreatorInterface $serverRequestCreator, RequestHandlerInterface $handler)
    {
        $this->handler = $handler;
        $this->serverRequestCreator = $serverRequestCreator;
    }

    /**
     * run a bolt app with nyholm.
     *
     * @param array $config The application configuration.
     * @return void
     */
    public static function run($config = [])
    {
        $container = $config instanceof ContainerInterface
            ? $config
            : BoltContainerConfiguration::createContainer($config + BoltNyholmConfiguration::default());

        /** @var static $runner */
        $runner = $container->get(static::class);
        $runner->runApp();
    }

    protected function runApp()
    {
        $request = $this->serverRequestCreator->fromGlobals();
        $response = $this->handler->handle($request);
        send($response);
    }
}
