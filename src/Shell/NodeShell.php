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
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Event\EventManager;
use PipingBag\Di\PipingBag;
use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;
use React\Socket\Server;
use WyriHaximus\PhuninNode\Configuration;
use WyriHaximus\PhuninNode\Node;

class NodeShell extends Shell
{
    /**
     * @var LoopInterface
     */
    private $loop;

    /**
     * @var Node
     */
    private $node;
    
    public function start()
    {
        $this->loop = \WyriHaximus\PhuninCake\loopResolver();

        $socket = new Server($this->loop);
        $socket->listen(Configure::read('WyriHaximus.PhuninCake.Node.connection.port'), Configure::read('WyriHaximus.PhuninCake.Node.connection.address'));

        $config = new Configuration();
        if (Configure::check('WyriHaximus.PhuninCake.Node.name')) {
            $config->setPair('hostname', Configure::read('WyriHaximus.PhuninCake.Node.name'));
        }

        $this->node = new Node($this->loop, $socket, $config);
        
        EventManager::instance()->dispatch(new Event('WyriHaximus.PhuninCake.Node.start', $this, [
            'loop' => $this->loop,
            'node' => $this->node,
        ]));

        $this->loop->run();
    }
}