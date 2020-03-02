<?php

namespace hmmhmmmm\shop\ui;

use hmmhmmmm\shop\Shop;
use muqsit\invmenu\InvMenu;

use pocketmine\Player;
use pocketmine\item\Item;
use pocketmine\nbt\tag\CompoundTag;

class ShopChest{
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
   
   public function sendChest(Player $player): void{
      $menu = InvMenu::create(InvMenu::TYPE_CHEST);
      $menu->readonly();
      $menu->setListener([$this->plugin->eventListener, "ShopMenu"]);
      $menu->setName($this->getPrefix());
      $inv = $menu->getInventory();
      $inv->setContents($this->sendCategoryMenu());
      $menu->send($player);
   }

   public function sendCategoryMenu(): array{
      $array = [
         26 => Item::get(35, 14, 1)->setCustomName($this->lang->getTranslate(
            "chestmenu.exit"
         ))
      ];
      $i = 0;
      if($this->getPlugin()->getCountCategory() !== 0){
         foreach($this->getPlugin()->getCategory() as $category){
            if($i < 24){
               $item = Item::fromString($this->getPlugin()->getCategoryIcon($category));
               $tag = new CompoundTag();
               $tag->setString("category", $category);
               $item->setCustomBlockData($tag);
               $array[$i] = $item->setCustomName($this->getPlugin()->getCategoryName($category));
               $i++;
            }
         }
      }
      return $array;
   }
   
   public function makeCategoryItemPage(string $category): array{
      $items = [];
      foreach($this->getPlugin()->getItems($category) as $itemicon){
         $item = Item::fromString($itemicon);
         $items[] = $item;
      }
      return array_chunk($items, 18);
   }
   
   public function sendCategoryItem(string $category, int $page = 0): array{
      if(!isset($this->makeCategoryItemPage($category)[$page])){
         $arrayNull = [
            26 => Item::get(35, 4, 1)->setCustomName($this->lang->getTranslate(
               "chestmenu.back"
            ))
         ];
         return $arrayNull;
      }
      $itemNext = Item::get(35, 5, 1);
      $tag1 = new CompoundTag();
      $tag1->setString("category", $category);
      $tag1->setInt("page", $page);
      $itemNext->setCustomBlockData($tag1);
      $array = [
         24 => Item::get(35, 4, 1)->setCustomName($this->lang->getTranslate(
            "chestmenu.back"
         )),
         25 => $itemNext->setCustomName($this->lang->getTranslate(
            "chestmenu.next",
            [($page + 1), count($this->makeCategoryItemPage($category))]
         )),
         26 => Item::get(35, 14, 1)->setCustomName($this->lang->getTranslate(
            "chestmenu.exit"
         ))
      ];
      for($i = 18; $i < 24; $i++){
         $array[$i] = Item::get(160, 3, 1)->setCustomName("???");
      }
      $i = 0;
      if($this->getPlugin()->getCountItems($category) !== 0){
         foreach($this->makeCategoryItemPage($category)[$page] as $item){
            $itemicon = $item->getId().":".$item->getDamage();
            $buyPrice = $this->getPlugin()->getBuyPrice($category, $itemicon);
            $sellPrice = $this->getPlugin()->getSellPrice($category, $itemicon);
            $lore = [
               "text1" => $this->lang->getTranslate(
                  "chestmenu.senditem.lore",
                  [$buyPrice, $sellPrice]
               )
            ];
            $tag = new CompoundTag();
            $tag->setString("category", $category);
            $item->setCustomBlockData($tag);
            $array[$i] = $item->setLore($lore);
            $i++;
         }
      }
      return $array;
   }
   
}