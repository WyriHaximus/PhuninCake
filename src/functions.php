<?php

namespace WyriHaximus\PhuninCake;

use Cake\Core\Configure;
use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;
use PipingBag\Di\PipingBag;

/**
 * @return LoopInterface
 */
function loopResolver()
{
    if (
        Configure::check('WyriHaximus.PhuninCake.loop') &&
        Configure::read('WyriHaximus.PhuninCake.loop') instanceof LoopInterface
    ) {
        return Configure::read('WyriHaximus.PhuninCake.loop');
    }

    if (class_exists('PipingBag\Di\PipingBag') && Configure::check('WyriHaximus.PhuninCake.pipingbag.loop')) {
        return PipingBag::get(Configure::read('WyriHaximus.PhuninCake.pipingbag.loop'));
    }

    return Factory::create();
}
