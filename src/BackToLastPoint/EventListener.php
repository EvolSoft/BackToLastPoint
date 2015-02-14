<?php

/*
 * BackToLastPoint (v1.0) by EvolSoft
 * Developer: EvolSoft
 * Website: http://www.evolsoft.tk
 * Date: 14/02/2015 02:26 PM (UTC)
 * Copyright & License: (C) 2015 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/BackToLastPoint/blob/master/LICENSE)
 */

namespace BackToLastPoint;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class EventListener extends PluginBase implements Listener{
	
	public function __construct(Main $plugin){
		$this->plugin = $plugin;
	}
	
	public function onPlayerQuit(PlayerQuitEvent $event){
		$cfg = $this->plugin->getConfig()->getAll();
		$player = $event->getPlayer();
		//Check if onleave position saving is enabled
		if($cfg["save-position-onleave"] == true){
			$x = $player->x;
			$y = $player->y;
			$z = $player->z;
			$yaw = $player->yaw;
			$pitch = $player->pitch;
			$this->plugin->saveLastPoint($player, $x, $y, $z, $yaw, $pitch);
		}
	}
	
	public function onPlayerDeath(PlayerDeathEvent $event){
		$cfg = $this->plugin->getConfig()->getAll();
		//Save death point
		$player = $event->getEntity();
		//Check if entity is a player
		if($player instanceof Player){
			$x = $player->x;
			$y = $player->y;
			$z = $player->z;
			$yaw = $player->yaw;
			$pitch = $player->pitch;
			$this->plugin->saveLastPoint($player, $x, $y, $z, $yaw, $pitch);
		}
	}
	
	public function onPlayerRespawn(PlayerRespawnEvent $event){
		$cfg = $this->plugin->getConfig()->getAll();
		//Save death point
		$player = $event->getPlayer();
		$x = $player->x;
		$y = $player->y;
		$z = $player->z;
		$yaw = $player->yaw;
		$pitch = $player->pitch;
		$this->plugin->saveLastPoint($player, $x, $y, $z, $yaw, $pitch);
		//Teleport to point
		$lastpoint = $this->plugin->getLastPoint($player);
		//Check if the lastpoint exists
		if($lastpoint != false){
			//Check if teleport message is enabled
			if($cfg["show-message-onteleport"] == true){
				if($cfg["show-prefix"] == true){
					$player->sendMessage($this->plugin->translateColors("&", Main::PREFIX . $cfg["teleport-message"]));
				}else{
					$player->sendMessage($this->plugin->translateColors("&", $cfg["teleport-message"]));
				}
			}
			$event->setRespawnPosition(new Position($lastpoint["X"], $lastpoint["Y"], $lastpoint["Z"]), $lastpoint["Yaw"], $lastpoint["Pitch"]);
		}
	}
	
}
