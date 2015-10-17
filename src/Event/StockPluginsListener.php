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

use Cake\Event\EventListenerInterface;
use WyriHaximus\PhuninNode\Plugins;
use WyriHaximus\Ratchet\Event\StartEvent;

class StockPluginsListener implements EventListenerInterface
{
    /**
     * @return array
     */
    public function implementedEvents() {
        return [
            StartEvent::EVENT => 'start',
        ];
    }

    /**
     * @param StartEvent $event
     */
    public function start(StartEvent $event) {
        $event->getNode()->addPlugin(new Plugins\Plugins());
        $event->getNode()->addPlugin(new Plugins\PluginsCategories());
        $event->getNode()->addPlugin(new Plugins\MemoryUsage());
        $event->getNode()->addPlugin(new Plugins\Uptime());
    }
}
