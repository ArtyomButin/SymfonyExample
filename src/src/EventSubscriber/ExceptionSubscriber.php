<?php

namespace App\EventSubscriber;

use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * @return \array[][]
     */
    public static function getSubscribedEvents(): array
    {
        // вернуть подписанные события, их методы и приоритеты
        return array(
            KernelEvents::EXCEPTION => array(
                array('processException', 10),
                array('logException', 0),
                array('notifyException', -10),
            )
        );
    }

    public function processException(ExceptionEvent $event)
    {
    }

    public function logException(ExceptionEvent $event)
    {
    }

    public function notifyException(ExceptionEvent $event)
    {
    }
}
