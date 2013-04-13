<?php

/*
 * This file is part of PhuninCake.
 *
 ** (c) 2013 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

App::uses('CakeEvent', 'Event');
App::uses('CakeEventManager', 'Event');

use React\EventLoop\Factory as LoopFactory;

class NodeShell extends Shell {
    
    private $loop;
    private $node;
    
    public function __construct($stdout = null, $stderr = null, $stdin = null) {
        parent::__construct($stdout, $stderr, $stdin);
        
        $this->loop = LoopFactory::create();
        
        $this->node = new \PhuninNode\Node($this->loop, Configure::read('PhuninCake.Node.connection.port'), Configure::read('PhuninCake.Node.connection.address'), false);
        $this->node->addPlugin(new \PhuninNode\Plugins\Plugins());
        $this->node->addPlugin(new \PhuninNode\Plugins\PluginsCategories());
        $this->node->addPlugin(new \PhuninNode\Plugins\MemoryUsage());
        
        CakeEventManager::instance()->dispatch(new CakeEvent('PhuninCake.Node.construct', $this, array(
            'loop' => $this->loop,
            'node' => $this->node,
        )));
    }
    
    public function run() {
        $this->loop->run();
    }
    
}