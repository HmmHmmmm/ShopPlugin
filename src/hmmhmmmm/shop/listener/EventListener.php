<?php

namespace hmmhmmmm\shop\listener;

use hmmhmmmm\shop\Shop;

use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\item\Item;
use pocketmine\inventory\transaction\action\SlotChangeAction;

class EventListener implements Listener{
   private $plugin;
   private $prefix;
   private $lang;
   
   public function __construct(Shop $plugin){
      $this->plugin = $plugin;
      $this->prefix = $this->plugin->getPrefix();
      $this->lang = $this->plugin->getLanguage();
   }
   
   public function getPlugin(): Shop{
      return $this->plugin;
   }
   
   public function getPrefix(): string{
      return $this->prefix;
   }
   
   public function ShopMenu(Player $player, Item $sourceItem, Item $targetItem, SlotChangeAction $action): void{
      $chestinv = $action->getInventory();
      $chestItem = $sourceItem;
      if($chestItem->getCustomName() == $this->lang->getTranslate("chestmenu.exit")){
         $chestinv->onClose($player);
      }
      if($chestItem->getCustomName() == $this->lang->getTranslate("chestmenu.back")){
         $chestinv->setContents($this->plugin->getShopChest()->sendCategoryMenu());
      }
      if($this->plugin->getCountCategory() !== 0){
         if($chestItem->hasCustomBlockData()){
            $category = $chestItem->getCustomBlockData()->getString("category");
            if($this->plugin->getCountItems($category) !== 0){
               if($chestItem->getCustomName() == $this->plugin->getCategoryName($category)){
                  $chestinv->clearAll();
                  $chestinv->setContents(
                     $this->plugin->getShopChest()->sendCategoryItem($category)
                  );
               }
               if($chestItem->getId() == 35
                  && $chestItem->getDamage() == 5
               ){
                  if($chestItem->hasCustomBlockData()){
                     $c = $chestItem->getCustomBlockData()->getString("category");
                     $page = $chestItem->getCustomBlockData()->getInt("page") + 1;
                     $chestinv->clearAll();
                     $chestinv->setContents(
                        $this->plugin->getShopChest()->sendCategoryItem($c, $page)
                     );
                  }
               }
               if($chestItem->getCustomName() == null){
                  $id = $chestItem->getId();
                  $damage = $chestItem->getDamage();
                  $itemicon = $id.":".$damage;
                  $buyPrice = $this->plugin->getBuyPrice($category, $itemicon);
                  $sellPrice = $this->plugin->getSellPrice($category, $itemicon);
                  $chestinv->onClose($player);
                  $this->plugin->getShopForm()->MENU($player, $itemicon, $buyPrice, $sellPrice);
               }
            }
         }
      }
   }
   
}