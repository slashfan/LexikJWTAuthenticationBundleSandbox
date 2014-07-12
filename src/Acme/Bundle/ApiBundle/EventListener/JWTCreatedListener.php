<?php

namespace Acme\Bundle\ApiBundle\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

/**
 * JWTCreatedListener
 *
 * @author Nicolas Cabot <n.cabot@lexik.fr>
 */
class JWTCreatedListener
{
    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        if (!($request = $event->getRequest())) {
            return;
        }

        $payload       = $event->getData();
        $payload['ip'] = $request->getClientIp();

        $event->setData($payload);
    }
}
