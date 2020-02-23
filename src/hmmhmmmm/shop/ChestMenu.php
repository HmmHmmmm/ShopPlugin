<?php

namespace hmmhmmmm\shop;

use pocketmine\Player;
use pocketmine\block\Block;
use pocketmine\item\Item;
use pocketmine\tile\Tile;
use pocketmine\tile\Chest as TileChest;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\math\Vector3;

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
      $this->getPlugin()->array["chestmenu"][$player->getName()] = true;
      $v3 = new Vector3($player->getX(), $player->getY() - 5, $player->getZ());
      $tile = Tile::createTile("Chest", $player->getLevel(), TileChest::createNBT($v3));
      $block = Block::get(Block::CHEST);
      $block->x = $tile->x;
      $block->y = $tile->y;
      $block->z = $tile->z;
      $block->level = $tile->getLevel();
      $block->level->sendBlocks([$player],[$block]);
      $inventory = $tile->getInventory();
      $inventory->setContents($this->sendMenu());
      $player->addWindow($inventory);
   }
   public function sendMenu(): array{
      $array = [];
      $array[self::EXIT] = Item::get(35, 14, 1)->setCustomName("§cออก");
      $i = 0;
      if($this->getPlugin()->getCountCategory() !== 0){
         foreach($this->getPlugin()->getCategory() as $category){
            $item = Item::fromString($this->getPlugin()->getCategoryIcon($category));
            $array[$i] = $item->setCustomName($this->getPlugin()->getCategoryName($category));
            $i++;
         }
      }
      return $array;
   }
   public function sendItem(string $category): array{
      $array = [];
      $array[self::BACK] = Item::get(35, 4, 1)->setCustomName("§eกลับ");
      $array[self::EXIT] = Item::get(35, 14, 1)->setCustomName("§cออก");
      /*
      * หีบเล็กจะมีช่องทั้งหมด 27ช่อง
      * gui pocket ล่างสุดจะมี 3ช่อง //เผื่อลืม
      */
      $i = 0;
      if($this->getPlugin()->getCountItems($category) !== 0){
         foreach($this->getPlugin()->getItems($category) as $itemicon){
            $item = Item::fromString($itemicon);
            $buyPrice = $this->getPlugin()->getBuyPrice($category, $itemicon);
            $sellPrice = $this->getPlugin()->getSellPrice($category, $itemicon);
            $lore = [
               "text1" => "ชื้อในราคา ".$buyPrice." ต่อชิ้น\nขายในราคา ".$sellPrice." ต่อชิ้น"
            ];
            $tag = new CompoundTag();
            $tag->setString("รายการ", $category);
            $item->setCustomBlockData($tag);
            $array[$i] = $item->setLore($lore);
            $i++;
         }
      }
      return $array;
   }
}