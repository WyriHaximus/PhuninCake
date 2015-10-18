<?php

/**
 * This file is part of PhuninCake.
 *
 ** (c) 2015 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WyriHaximus\PhuninCake\Event;

use Cake\Event\Event;
use React\EventLoop\LoopInterface;
use WyriHaximus\PhuninNode\Node;

class StartEvent extends Event
{
    const EVENT = 'WyriHaximus.PhuninCake.Node.start';

    public static function create(LoopInterface $loop, Node $node)
    {
        return new static(static::EVENT, $node, [
            'loop' => $loop,
            'node' => $node,
        ]);
    }

    /**
     * @return Node
     */
    public function getNode()
    {
        return $this->subject();
    }
}
