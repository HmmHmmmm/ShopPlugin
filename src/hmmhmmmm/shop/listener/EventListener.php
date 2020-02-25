<?php

namespace hmmhmmmm\shop\listener;

use hmmhmmmm\shop\Shop;

use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\inventory\InventoryCloseEvent;
use pocketmine\inventory\ChestInventory;
use pocketmine\inventory\transaction\action\SlotChangeAction;
use pocketmine\nbt\tag\CompoundTag;

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
   public function onInventoryTransaction(InventoryTransactionEvent $event){
      $transaction = $event->getTransaction();
      $player = null;
      $chestinv = null;
      foreach($transaction->getActions() as $action){
         if($action instanceof SlotChangeAction){
            $inventory = $action->getInventory();
            if($inventory instanceof ChestInventory){
               foreach($inventory->getViewers() as $assumed){
                  if($assumed instanceof Player){
                     $player = $assumed;
                     $chestinv = $inventory;
                  }
               }
            }
            if($chestinv !== null){
               $targetItem = $action->getTargetItem();
               $sourceItem = $action->getSourceItem();
               $chestItem = $sourceItem;
               if(isset($this->plugin->array["chestmenu"][$player->getName()])){
                  $event->setCancelled(true);
                  if($chestItem->getCustomName() == $this->getPlugin()->getLanguage()->getTranslate("chestmenu.exit")){
                     $chestinv->onClose($player);
                  }
                  if($chestItem->getCustomName() == $this->getPlugin()->getLanguage()->getTranslate("chestmenu.back")){
                     $chestinv->setContents($this->plugin->getChestMenu()->sendMenu());
                  }
                  if($this->plugin->getCountCategory() !== 0){
                     foreach($this->plugin->getCategory() as $category){
                        if($this->plugin->getCountItems($category) !== 0){
                           if($chestItem->getCustomName() == $this->plugin->getCategoryName($category)){
                              $chestinv->clearAll();
                              $chestinv->setContents($this->plugin->getChestMenu()->sendItem($category));
                           }
                           if($chestItem->getCustomName() == null){
                              $id = $chestItem->getId();
                              $damage = $chestItem->getDamage();
                              $itemicon = $id.":".$damage;
                              if($chestItem->hasCustomBlockData()){
                                 $category = $chestItem->getCustomBlockData()->getString("รายการ");
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
            }
         }
      }
   }
   public function onInventoryClose(InventoryCloseEvent $event){
      $player = $event->getPlayer();
      $inventory = $event->getInventory();
      if($inventory instanceof ChestInventory){
         if(isset($this->plugin->array["chestmenu"][$player->getName()])){
            $v3 = $inventory->getHolder();
            $player->getLevel()->sendBlocks([$player], [$v3]);
            unset($this->plugin->array["chestmenu"][$player->getName()]);
         }
      }
   }
}