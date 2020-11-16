<?php

declare(strict_types=1);

namespace Britt;

# Sounds Class
use pocketmine\level\sound\GenericSound;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
# Server / Plugin Class
use pocketmine\level\Position;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
# Events class
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerItemConsumeEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;

class Main extends PluginBase implements Listener{

    public function onEnable(): void{
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("Plugin Sounds is Enabled!");
        @mkdir($this->getDataFolder());
		if(!file_exists($this->getDataFolder(). "config.yml")){
            $this->saveResource('config.yml');
        }
        $this->config = new Config($this->getDataFolder(). 'config.yml', Config::YAML);
    }

    public function onBreak(BlockBreakEvent $event) {
		$player = $event->getPlayer();
		$sound = $this->getConfig()->get("break-sound");
		$player->getLevel()->addSound(new GenericSound($player, $sound), [$player]);
    }
      
    public function onJoin(PlayerJoinEvent $event){
		$player = $event->getPlayer();
		$sound = $this->getConfig()->get("join-sound");
		$event->setJoinMessage("");
		$player->getLevel()->addSound(new GenericSound($player, $sound), [$player]);
	}
	
    public function onHit(EntityDamageEvent $event){
		$player = $event->getPlayer();
		$sound = $this->getConfig()->get("hit-sound");
	    if($event instanceof EntityDamageByEntityEvent){
			$damager = $event->getDamager();
			$damager->getLevel()->addSound(new GenericSound($player, $sound), [$player]);
	    }
    }

	public function onDeath(PlayerDeathEvent $ev){
		$player = $event->getPlayer();
		$sound = $this->getConfig()->get("death-sound");
		$player->getLevel()->addSound(new GenericSound($player, $sound), [$player]);
    }
}