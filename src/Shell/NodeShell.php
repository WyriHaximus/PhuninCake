<?php

/*
 * This file is part of PhuninCake.
 *
 ** (c) 2013 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WyriHaximus\PhuninCake\Shell;

use Cake\Console\Shell;
use Cake\Event\EventManager;
use WyriHaximus\PhuninCake\Event\ConstructEvent;

class NodeShell extends Shell
{
    public function start()
    {
        $loop = \WyriHaximus\PhuninCake\loopResolver();
        EventManager::instance()->dispatch(ConstructEvent::create($loop));
        $loop->run();
    }
}