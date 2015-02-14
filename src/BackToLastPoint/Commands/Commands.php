<?php

/*
 * BackToLastPoint (v1.0) by EvolSoft
 * Developer: EvolSoft
 * Website: http://www.evolsoft.tk
 * Date: 14/02/2015 02:26 PM (UTC)
 * Copyright & License: (C) 2015 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/BackToLastPoint/blob/master/LICENSE)
 */

namespace BackToLastPoint\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\permission\Permission;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

use BackToLastPoint\Main;

class Commands extends PluginBase implements CommandExecutor{
	
	public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }
    
    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args) {
    	$fcmd = strtolower($cmd->getName());
    	switch($fcmd){
    			case "backtolastpoint":
    				if(isset($args[0])){
    			   		$args[0] = strtolower($args[0]);
    			   		if($args[0]=="reload"){
    			   			if($sender->hasPermission("backtolastpoint.reload")) {
    			   				$this->plugin->reloadConfig();
    			   				$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&aConfiguration Reloaded."));
    			   				return true;
    			   			}
    			   			else{
    			   				$sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
    			   				return true;
    			   			}
    			   		}
    			   		elseif($args[0]=="info"){
    			   			if($sender->hasPermission("backtolastpoint.info")) {
    			   				$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&aBackToLastPoint &7v" . Main::VERSION . " &adeveloped by&7 " . Main::PRODUCER));
    			   				$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&aWebsite &7" . Main::MAIN_WEBSITE));
    			   				return true;
    			   			}
    			   			else{
    			   				$sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
    			   				return true;
    			   			}
    			   		}else{
    			   			if($sender->hasPermission("backtolastpoint")){
    			   				$sender->sendMessage($this->plugin->translateColors("&", Main::PREFIX . "&cSubcommand &9" . $args[0] . "&c not found. Use &9/btlp &cto show available commands"));
    			   				break;
    			   			}
    			   			else{
    			   				$sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
    			   				break;
    			   			}
    			   			return true;
    			   		}
    			   	}
    			   	else{
    			   		if($sender->hasPermission("backtolastpoint")){
    			   			$sender->sendMessage($this->plugin->translateColors("&", "&a-> &7Available Commands &a<-"));
    			   			$sender->sendMessage($this->plugin->translateColors("&", "&a/bc info &7-> &aShow info about this plugin"));
    			   			$sender->sendMessage($this->plugin->translateColors("&", "&a/bc reload &7-> &aReload the config"));
    			   			$sender->sendMessage($this->plugin->translateColors("&", "&a/lastpoint &7or &a/back &7-> &aTeleport back to last point"));
    			   			break;
    			   		}else{
    			   			$sender->sendMessage($this->plugin->translateColors("&", "&cYou don't have permissions to use this command"));
    			   			break;
    			   			}
    			   		return true;
    			   	}
    		}
    	return true;
    }
    
}
    ?>
