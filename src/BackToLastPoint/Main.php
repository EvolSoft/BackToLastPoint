<?php

/*
 * BackToLastPoint (v1.0) by EvolSoft
 * Developer: EvolSoft
 * Website: http://www.evolsoft.tk
 * Date: 14/02/2015 02:20 PM (UTC)
 * Copyright & License: (C) 2015 EvolSoft
 * Licensed under MIT (https://github.com/EvolSoft/BackToLastPoint/blob/master/LICENSE)
 */

namespace BackToLastPoint;

use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

class Main extends PluginBase{

	//About Plugin Const
	const PRODUCER = "EvolSoft";
	const VERSION = "1.0";
	const MAIN_WEBSITE = "http://www.evolsoft.tk";
	//Other Const
	//Prefix
	const PREFIX = "&8[&cBackToLastPoint&8] ";

	public $cfg;

	public function translateColors($symbol, $message){

		$message = str_replace($symbol."0", TextFormat::BLACK, $message);
		$message = str_replace($symbol."1", TextFormat::DARK_BLUE, $message);
		$message = str_replace($symbol."2", TextFormat::DARK_GREEN, $message);
		$message = str_replace($symbol."3", TextFormat::DARK_AQUA, $message);
		$message = str_replace($symbol."4", TextFormat::DARK_RED, $message);
		$message = str_replace($symbol."5", TextFormat::DARK_PURPLE, $message);
		$message = str_replace($symbol."6", TextFormat::GOLD, $message);
		$message = str_replace($symbol."7", TextFormat::GRAY, $message);
		$message = str_replace($symbol."8", TextFormat::DARK_GRAY, $message);
		$message = str_replace($symbol."9", TextFormat::BLUE, $message);
		$message = str_replace($symbol."a", TextFormat::GREEN, $message);
		$message = str_replace($symbol."b", TextFormat::AQUA, $message);
		$message = str_replace($symbol."c", TextFormat::RED, $message);
		$message = str_replace($symbol."d", TextFormat::LIGHT_PURPLE, $message);
		$message = str_replace($symbol."e", TextFormat::YELLOW, $message);
		$message = str_replace($symbol."f", TextFormat::WHITE, $message);

		$message = str_replace($symbol."k", TextFormat::OBFUSCATED, $message);
		$message = str_replace($symbol."l", TextFormat::BOLD, $message);
		$message = str_replace($symbol."m", TextFormat::STRIKETHROUGH, $message);
		$message = str_replace($symbol."n", TextFormat::UNDERLINE, $message);
		$message = str_replace($symbol."o", TextFormat::ITALIC, $message);
		$message = str_replace($symbol."r", TextFormat::RESET, $message);

		return $message;
	}

	public function onEnable(){
		@mkdir($this->getDataFolder());
		@mkdir($this->getDataFolder() . "/players");
		$this->saveDefaultConfig();
		$this->cfg = $this->getConfig()->getAll();
		$this->getCommand("backtolastpoint")->setExecutor(new Commands\Commands($this));
		$this->getCommand("lastpoint")->setExecutor(new Commands\LastPoint($this));
		$this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
	}
	
	public function saveLastPoint(Player $player, $x, $y, $z, $yaw, $pitch){
		$tmp = new Config($this->getDataFolder() . "players/" . strtolower($player->getName() . ".yml"), Config::YAML);
		$tmp->set("X", $x);
		$tmp->set("Y", $y);
		$tmp->set("Z", $z);
		$tmp->set("Yaw", $yaw);
		$tmp->set("Pitch", $pitch);
		$tmp->save();
	}
	
	public function getLastPoint(Player $player){
		if($this->pointExists($player)){
			$tmp = new Config($this->getDataFolder() . "players/" . strtolower($player->getName() . ".yml"), Config::YAML);
			$data = array();
			$data["X"] = $tmp->get("X");
			$data["Y"] = $tmp->get("Y");
			$data["Z"] = $tmp->get("X");
			$data["Yaw"] = $tmp->get("Yaw");			
			$data["Pitch"] = $tmp->get("Pitch");
			return $data;
		}else{
			return false;
		}
	}
	
	public function pointExists(Player $player){
		return file_exists($this->getDataFolder() . "players/" . strtolower($player->getName() . ".yml"));
	}
}
