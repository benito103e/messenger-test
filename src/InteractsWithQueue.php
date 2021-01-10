<?php

namespace Zenstruck\Messenger\Test;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Messenger\Test\Transport\TestTransport;
use Zenstruck\Messenger\Test\Transport\TestTransportFactory;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
trait InteractsWithQueue
{
    final public function queue(?string $name = null): TestTransport
    {
        if (!$this instanceof KernelTestCase) {
            throw new \LogicException('The %s trait can only be used with %s.', __TRAIT__, KernelTestCase::class);
        }

        if (!self::$container) {
            throw new \LogicException('The kernel must be booted before accessing the messenger queue.');
        }

        if (!self::$container->has(TestTransportFactory::class)) {
            throw new \LogicException('Cannot access queue transport - is ZenstruckMessengerTestBundle enabled in your test environment?');
        }

        return self::$container->get(TestTransportFactory::class)->get($name);
    }
}
