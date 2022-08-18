<?php

namespace refaltor\vote\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use refaltor\vote\Main;
use refaltor\vote\async\voteAsync;

class vote extends Command
{
    private $plugin;

    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
        $array = $plugin->getConfig()->get('command');
        parent::__construct($array['usage'], $array['description']);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$sender instanceof Player) return;
        $server = $this->plugin->getServer();
        $server->getAsyncPool()->submitTask(new voteAsync($sender->getName(), $this->plugin->getConfig()->get("API_KEY")));
    }
}
