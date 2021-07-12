<?php

namespace refaltor\vote\async;

use pocketmine\item\Item;
use pocketmine\plugin\Plugin;
use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;
use pocketmine\utils\Internet;

class voteAsync extends AsyncTask
{

    private string $player;
    private Plugin $plugin;


    public function __construct(string $player, Plugin $plugin)
    {
        $this->plugin = $plugin;
        $this->player = $player;
    }

    public function onRun(): void{
        $key = $this->plugin->getConfig()->get('API_KEY');
        $checking = Internet::getURL("https://minecraftpocket-servers.com/api/?object=votes&element=claim&key=$key&username=" . str_replace(" ", "+", $this->player));
        if($checking === "1") Internet::getURL("https://minecraftpocket-servers.com/api/?action=post&object=votes&element=claim&key=$key&username=" . str_replace(" ", "+", $this->player));
        $this->setResult($checking);
    }

    public function onCompletion(Server $server): void{

        $checking = $this->getResult();
        $player = $server->getPlayer($this->player);
        if($player === null) return;
        switch($checking){
            case "0":
                $message = $this->plugin->getConfig()->get("message_has_not_voted");
                if ($message['enable']) $player->sendMessage($message['message']);
                break;
            case "1":
                $message = $this->plugin->getConfig()->get("message_player");
                if ($message['enable']) $player->sendMessage($message['message']);

                $type = $this->plugin->getConfig()->get("reward_type");
                switch (strtolower($type)){
                    case 'items':
                        $array = $this->plugin->getConfig()->get("rewards_items");
                        foreach ($array as $string){
                            $item = explode("#", $string);
                            $item = Item::get($item[0], $item[1], $item[2])->setCustomName($item[3]);
                            if ($player->getInventory()->canAddItem($item)){
                                $player->getInventory()->addItem($item);
                            }else $player->getLevel()->dropItem($player, $item);
                        }
                        break;
                    case 'commands':
                        $array = $this->plugin->getConfig()->get("rewards_commands");
                        foreach ($array as $cmd){
                            $server->dispatchCommand($player, $cmd);
                        }
                        break;
                    default:
                        $server->getLogger()->critical("ERROR REWARD");
                        break;
                }

                $message = $this->plugin->getConfig()->get("message_everyone");
                if ($message['enable']) Server::getInstance()->broadcastMessage(str_replace("{player}", $player->getName(), $message['message']));
                break;
            default:
                $message = $this->plugin->getConfig()->get("message_has_already_voted");
                if ($message['enable']) $player->sendMessage($message['message']);
        }
    }
}
