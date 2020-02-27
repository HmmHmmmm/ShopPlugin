<?php

namespace hmmhmmmm\shop\ui;

use hmmhmmmm\shop\Shop;

use pocketmine\Player;
use pocketmine\item\Item;
use muqsit\invmenu\InvMenu;
use pocketmine\nbt\tag\CompoundTag;

class ChestMenu{
   private $plugin;
   const EXIT = 26;
   const BACK = 25;
   
   public function __construct(Shop $plugin){
      $this->plugin = $plugin;
   }
   public function getPlugin(): Shop{
      return $this->plugin;
   }
   public function getPrefix(): string{
      return $this->getPlugin()->getPrefix();
   }
   public function create(Player $player): void{
      $menu = new InvMenu(InvMenu::TYPE_CHEST);
      $menu->readonly();
      $menu->setListener([$this->plugin->eventListener, "ShopMenu"]);
      $menu->setName($this->getPrefix());
      $inv = $menu->getInventory();
      $inv->setContents($this->sendMenu());
      $menu->send($player);
   }
   public function sendMenu(): array{
      $array = [];
      $array[self::EXIT] = Item::get(35, 14, 1)->setCustomName($this->getPlugin()->getLanguage()->getTranslate("chestmenu.exit"));
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
   public function sendItem(string $category): array{
      $array = [];
      $array[self::BACK] = Item::get(35, 4, 1)->setCustomName($this->getPlugin()->getLanguage()->getTranslate("chestmenu.back"));
      $array[self::EXIT] = Item::get(35, 14, 1)->setCustomName($this->getPlugin()->getLanguage()->getTranslate("chestmenu.exit"));
      $i = 0;
      if($this->getPlugin()->getCountItems($category) !== 0){
         foreach($this->getPlugin()->getItems($category) as $itemicon){
            if($i < 24){
               $item = Item::fromString($itemicon);
               $buyPrice = $this->getPlugin()->getBuyPrice($category, $itemicon);
               $sellPrice = $this->getPlugin()->getSellPrice($category, $itemicon);
               $lore = [
                  "text1" => $this->getPlugin()->getLanguage()->getTranslate("chestmenu.senditem.lore", [$buyPrice, $sellPrice])
               ];
               $tag = new CompoundTag();
               $tag->setString("category", $category);
               $item->setCustomBlockData($tag);
               $array[$i] = $item->setLore($lore);
               $i++;
            }
         }
      }
      return $array;
   }
}