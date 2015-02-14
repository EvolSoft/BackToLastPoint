<?php

/*
 * BackToLastPoint (v1.0) by EvolSoft
 * Developer: EvolSoft
 * Website: http://www.evolsoft.tk
 * Date: 14/02/2015 02:27 PM (UTC)
 * Copyright & License: (C) 2015 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/BackToLastPoint/blob/master/LICENSE)
 */

namespace BackToLastPoint\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\level\Position;
use pocketmine\permission\Permission;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

use BackToLastPoint\Main;

class LastPoint extends PluginBase implements CommandExecutor{
	
	public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }
    
    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args) {
    	$fcmd = strtolower($cmd->getName());
    	switch($fcmd){
    			case "lastpoint":
    				$cfg = $this->plugin->getConfig()->getAll();
    				if($sender instanceof Player){
    					if($sender->hasPermission("backtolastpoint.lastpoint")){
    						//Teleport to point
    						$lastpoint = $this->plugin->getLastPoint($sender);
    						//Check if the lastpoint exists
    						if($lastpoint != false){
    							//Check if teleport message is enabled
    							if($cfg["show-message-onteleport"] == true){
    								if($cfg["show-prefix"] == true){
    									$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . $cfg["teleport-message"]));
    								}else{
    									$sender->sendMessage($this->plugin->translateColors("&", $cfg["teleport-message"]));
    								}
    							}
    							$sender->teleport(new Position($lastpoint["X"], $lastpoint["Y"], $lastpoint["Z"]), $lastpoint["Yaw"], $lastpoint["Pitch"]);
    						}
    					}else{
    						$sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
    						return true;
    					}
    				}else{
    					$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&cYou can only perform this command as a player"));
    				}
				break;
    		}
    	return true;
    }
    
}
    ?>
