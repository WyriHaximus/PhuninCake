<?php

App::uses('CakeEvent', 'Event');
App::uses('CakeEventManager', 'Event');
App::uses('Security', 'Utility');

use React\EventLoop\Factory as LoopFactory;

class NodeShell extends Shell {
    
    private $loop;
    private $node;
    
    public function run() {
        $this->loop = LoopFactory::create();
        
        $this->runSetupNode();
        
        CakeEventManager::instance()->dispatch(new CakeEvent('PhuninCake.Node.run', $this, array(
            'loop' => $this->loop,
            'node' => $this->node,
        )));
        
        $this->runSetupKillSwitch();
        
        $this->loop->run();
    }
    
    private function runSetupNode() {
        $this->node = new \PhuninNode\Node($this->loop, Configure::read('PhuninCake.Node.connection.port'), Configure::read('PhuninCake.Node.connection.address'), false);
        $this->node->addPlugin(new \PhuninNode\Plugins\Plugins());
        $this->node->addPlugin(new \PhuninNode\Plugins\PluginsCategories());
        $this->node->addPlugin(new \PhuninNode\Plugins\MemoryUsage());
        $this->node->addPlugin(new \PhuninNode\Plugins\Uptime());
    }
    
    private function runSetupKillSwitch() {
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
    }
    
}