<?php

/*
 * This file is part of PhuninCake.
 *
 ** (c) 2013 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WyriHaximus\PhuninCake\Event;

use Cake\Core\Configure;
use Cake\Event\EventListenerInterface;
use Cake\Event\EventManager;
use WyriHaximus\PhuninNode\Configuration;
use WyriHaximus\PhuninNode\Factory as NodeFactory;
use WyriHaximus\PhuninNode\Plugins;

class ConstructListener implements EventListenerInterface
{
    /**
     * @return array
     */
    public function implementedEvents()
    {
        return [
            ConstructEvent::EVENT => 'construct',
        ];
    }

    /**
     * @param ConstructEvent $event
     */
    public function construct(ConstructEvent $event)
    {

        $config = new Configuration();
        if (Configure::check('WyriHaximus.PhuninCake.Node.name')) {
            $config->setPair('hostname', Configure::read('WyriHaximus.PhuninCake.Node.name'));
        }

        $node = NodeFactory::create(
            $event->getLoop(),
            Configure::read('WyriHaximus.PhuninCake.Node.connection.address'),
            Configure::read('WyriHaximus.PhuninCake.Node.connection.port'),
            $config
        );

        EventManager::instance()->dispatch(StartEvent::create($event->getLoop(), $node));
    }
}
