<?php

namespace refaltor\vote;

use pocketmine\plugin\PluginBase;
use refaltor\vote\command\vote;

class Main extends PluginBase
{
    private static self $instance;
    
    public function onLoad()
    {
        self::$instance = $this;
    }

    public function onEnable()
    {
        $this->saveResource('config.yml');
        $array = $this->getConfig()->get('command');
        $this->getServer()->getCommandMap()->register($array['usage'], new vote($this));
    }

    public static function getInstance(): self{
        return self::$instance;
    }
}
