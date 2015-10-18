<?php

/**
 * This file is part of PhuninCake.
 *
 ** (c) 2015 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WyriHaximus\Ratchet\Event;

use Cake\Event\Event;
use React\EventLoop\LoopInterface;

class ConstructEvent extends Event
{
    const EVENT = 'WyriHaximus.PhuninCake.Node.construct';

    public static function create(LoopInterface $loop)
    {
        return new static(static::EVENT, $loop, []);
    }

    /**
     * @return LoopInterface
     */
    public function getLoop()
    {
        return $this->subject();
    }
}
