<?php

/*
 * This file is part of PhuninCake.
 *
 ** (c) 2013 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

App::uses('CakeEventListener', 'Event');

class PhuninCakeStockPluginsListener implements CakeEventListener {

    public function implementedEvents() {
        return array(
            'PhuninCake.Node.start' => 'start',
        );
    }

    public function start($event) {
        $event->data['node']->addPlugin(new \WyriHaximus\PhuninNode\Plugins\Plugins());
        $event->data['node']->addPlugin(new \WyriHaximus\PhuninNode\Plugins\PluginsCategories());
        $event->data['node']->addPlugin(new \WyriHaximus\PhuninNode\Plugins\MemoryUsage());
        $event->data['node']->addPlugin(new \WyriHaximus\PhuninNode\Plugins\Uptime());
    }
}
