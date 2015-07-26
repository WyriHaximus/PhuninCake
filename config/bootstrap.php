<?php

/*
 * This file is part of PhuninCake.
 *
 ** (c) 2013 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Cake\Core\Configure;
use Cake\Event\EventManager;
use WyriHaximus\PhuninCake\Event\StockPluginsListener;

Configure::write('PhuninCake', array(
    'Node' => array(
        'connection' => array(
            'address' => '0.0.0.0',
            'port' => 14001,
        ),
        'killConnection' => 'tcp://127.0.0.1:15001',
    ),
));

EventManager::instance()->on(new StockPluginsListener());
