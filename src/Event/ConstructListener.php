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
use React\Socket\Server;
use WyriHaximus\PhuninNode\Configuration;
use WyriHaximus\PhuninNode\Node;
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

        $socket = new Server($event->getLoop());
        $socket->listen(Configure::read('WyriHaximus.PhuninCake.Node.connection.port'), Configure::read('WyriHaximus.PhuninCake.Node.connection.address'));

        $config = new Configuration();
        if (Configure::check('WyriHaximus.PhuninCake.Node.name')) {
            $config->setPair('hostname', Configure::read('WyriHaximus.PhuninCake.Node.name'));
        }

        $node = new Node($event->getLoop(), $socket, $config);

        EventManager::instance()->dispatch(StartEvent::create($event->getLoop(), $node));
    }
}
