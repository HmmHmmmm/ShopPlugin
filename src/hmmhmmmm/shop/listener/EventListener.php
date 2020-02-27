<?php

namespace hmmhmmmm\shop\listener;

use hmmhmmmm\shop\Shop;

use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\item\Item;
use pocketmine\inventory\transaction\action\SlotChangeAction;

class EventListener implements Listener{
   private $plugin;
   
   public function __construct(Shop $plugin){
      $this->plugin = $plugin;
   }
   public function getPlugin(): Shop{
      return $this->plugin;
   }
   public function getPrefix(): string{
      return $this->getPlugin()->getPrefix();
   }
   public function ShopMenu(Player $player, Item $sourceItem, Item $targetItem, SlotChangeAction $action): void{
      $chestinv = $action->getInventory();
      $chestItem = $sourceItem;
      if($chestItem->getCustomName() == $this->getPlugin()->getLanguage()->getTranslate("chestmenu.exit")){
         $chestinv->onClose($player);
      }
      if($chestItem->getCustomName() == $this->getPlugin()->getLanguage()->getTranslate("chestmenu.back")){
         $chestinv->setContents($this->plugin->getChestMenu()->sendMenu());
      }
      if($this->plugin->getCountCategory() !== 0){
         if($chestItem->hasCustomBlockData()){
            $category = $chestItem->getCustomBlockData()->getString("category");
            if($this->plugin->getCountItems($category) !== 0){
               if($chestItem->getCustomName() == $this->plugin->getCategoryName($category)){
                  $chestinv->clearAll();
                  $chestinv->setContents($this->plugin->getChestMenu()->sendItem($category));
               }
               if($chestItem->getCustomName() == null){
                  $id = $chestItem->getId();
                  $damage = $chestItem->getDamage();
                  $itemicon = $id.":".$damage;
                  $buyPrice = $this->plugin->getBuyPrice($category, $itemicon);
                  $sellPrice = $this->plugin->getSellPrice($category, $itemicon);
                  $chestinv->onClose($player);
                  $this->plugin->getForm()->ShopUI($player, $itemicon, $buyPrice, $sellPrice);
               }
            }
         }
      }
   }
}