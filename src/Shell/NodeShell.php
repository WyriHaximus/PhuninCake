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
use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;
use React\Socket\Server;
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
    
    public function start() {
        $this->loop = Factory::create();

        $socket = new Server($this->loop);
        $socket->listen(Configure::read('WyriHaximus.PhuninCake.Node.connection.port'), Configure::read('WyriHaximus.PhuninCake.Node.connection.address'));

        $this->node = new Node($this->loop, $socket);
        
        EventManager::instance()->dispatch(new Event('WyriHaximus.PhuninCake.Node.start', $this, array(
            'loop' => $this->loop,
            'node' => $this->node,
        )));
        
        //$this->runSetupKillSwitch();
        
        $this->loop->run();
    }
    
    /*private function runSetupKillSwitch() {
        $loop = $this->loop;
        $context = new React\ZMQ\Context($this->loop);
        $socket = $context->getSocket(ZMQ::SOCKET_PULL);
        $socket->bind(Configure::read('PhuninCake.Node.killConnection'));
        $socket->on('message', function($command) use ($loop) {
            if (Security::hash($command, 'sha256', true) == Security::hash($this->getKillCommand(), 'sha256', true)) {
                $loop->stop();
            }
        });
    }
    
    public function stop() {
        $zmq = new ZMQContext(1);
        $nodeConnection = $zmq->getSocket(ZMQ::SOCKET_PUSH, 'xyz');
        $nodeConnection->connect(Configure::read('PhuninCake.Node.killConnection'));
        $nodeConnection->send($this->getKillCommand());
    }
    
    private function getKillCommand() {
        $killCommand = array(
            'configHash' => Security::hash(serialize(Configure::read('PhuninCake.Node')), 'sha256', true),
        );
        
        return serialize($killCommand);
    }*/
}