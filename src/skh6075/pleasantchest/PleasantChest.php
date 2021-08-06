<?php

namespace skh6075\pleasantchest;

use pocketmine\block\Barrel as PMBarrel;
use pocketmine\block\tile\Barrel as PMBarrelTile;
use pocketmine\block\Chest as PMChest;
use pocketmine\block\inventory\ChestInventory;
use pocketmine\block\tile\Chest as PMChestTile;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;

final class PleasantChest extends PluginBase implements Listener{

	protected function onEnable() : void{
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	/**
	 * @param BlockBreakEvent $event
	 * @priority LOWEST
	 */
	public function onBlockBreakEvent(BlockBreakEvent $event): void{
		if(!$event->isCancelled()){
			$block = $event->getBlock();
			$tile = $block->getPos()->getWorld()->getTile($block->getPos()->asVector3());
			if($block instanceof PMChest && $tile instanceof PMChestTile){
				assert($tile->getInventory() instanceof ChestInventory);
				if(count($tile->getInventory()->getContents(false)) > 0){
					$event->cancel();
					$event->getPlayer()->sendTitle("§l§cANTI CHEST", "§r§7You must empty your inventory before you can break the chest!");
				}
			}elseif($block instanceof PMBarrel && $tile instanceof PMBarrelTile){
				if(count($tile->getInventory()->getContents(false)) > 0){
					$event->cancel();
					$event->getPlayer()->sendTitle("§l§cANTI CHEST", "§r§7You must empty your inventory before you can break the barrel!");
				}
			}
		}
	}
}