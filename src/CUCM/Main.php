<?php

namespace CUCM;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener {

    public function onEnable()
    {
        $this->saveResource("config.yml");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onCmd(PlayerCommandPreprocessEvent $event) {
        $cfg = new Config($this->getDataFolder() . "config.yml", 2);
        $player = $event->getPlayer();
        $msg = explode(" ", $event->getMessage());
        if ($event->getMessage()[0] == '/') {
            $command = substr($msg[0], 1);

            if (($cmd = Server::getInstance()->getCommandMap()->getCommand($command)) == null) {
                $event->setCancelled();
                $player->sendMessage($cfg->get("Message"));         
            }
        } else if ($event->getMessage()[0] == '.' && $event->getMessage()[1] == '/') {
            $command = substr($msg[0], 2);

            if (($cmd = Server::getInstance()->getCommandMap()->getCommand($command)) == null) {
                $event->setCancelled();
                $player->sendMessage($cfg->get("Message"));     
            }
        } else {
            return;
        }
    }
}
