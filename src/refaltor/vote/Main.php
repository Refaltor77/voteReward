<?php

namespace refaltor\vote;

use pocketmine\plugin\PluginBase;
use refaltor\vote\command\vote;

class Main extends PluginBase
{
    public function onEnable()
    {
        $this->saveResource('config.yml');
        $array = $this->getConfig()->get('command');
        $this->getServer()->getCommandMap()->register($array['usage'], new vote($this));
    }
}