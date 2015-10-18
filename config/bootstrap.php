<?php

/*
 * This file is part of PhuninCake.
 *
 ** (c) 2013 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Cake\Event\EventManager;
use WyriHaximus\PhuninCake\Event\ConstructListener;
use WyriHaximus\PhuninCake\Event\StockPluginsListener;

EventManager::instance()->on(new ConstructListener());
EventManager::instance()->on(new StockPluginsListener());
