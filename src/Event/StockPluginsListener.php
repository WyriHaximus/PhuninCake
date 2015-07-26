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

class StockPluginsListener implements EventListenerInterface
{

    public function implementedEvents() {
        return [
            'PhuninCake.Node.start' => 'start',
        ];
    }

    public function start($event) {
        $event->data['node']->addPlugin(new Plugins\Plugins());
        $event->data['node']->addPlugin(new Plugins\PluginsCategories());
        $event->data['node']->addPlugin(new Plugins\MemoryUsage());
        $event->data['node']->addPlugin(new Plugins\Uptime());
    }
}
