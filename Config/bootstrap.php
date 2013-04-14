<?php

Configure::write('PhuninCake', array(
    'Node' => array(
        'connection' => array(
            'address' => '0.0.0.0',
            'port' => 14001,
        ),
        'killConnection' => 'tcp://127.0.0.1:15001',
    ),
));