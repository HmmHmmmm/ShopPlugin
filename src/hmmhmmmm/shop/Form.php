<?php

namespace hmmhmmmm\shop;

use pocketmine\Player;
use pocketmine\item\Item;

class Form{
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
   
   public function ShopUI(Player $player, string $itemicon, int $buyPrice, int $sellPrice): void{
      $item = Item::fromString($itemicon);
      $form = $this->getPlugin()->getFormAPI()->createCustomForm(function ($player, $data) use ($buyPrice, $sellPrice, $itemicon){
         if($data == null){
            return;
         }
         $count = (int) $data[2];
         if($data[1] == 0){
            $price = $buyPrice * $count;
            $this->ShopBuyConfirm($player, $itemicon, $count, $price);
         }
         if($data[1] == 1){
            $price = $sellPrice * $count;
            $this->ShopSellConfirm($player, $itemicon, $count, $price);
         }
      });
      $form->setTitle($this->getPrefix()." Shop UI");
      $form->addLabel($this->getPrefix()." ไอเทม §d".$item->getName()." ".$itemicon."\n§fชื้อในราคา §a".$buyPrice." §fต่อชิ้น\nขายในราคา §6".$sellPrice." §fต่อชิ้น"); //0
      $form->addStepSlider("§fคุณต้องการ", ["§aชื้อ", "§6ขาย"]);  //1
      $form->addSlider("§fจำนวน", 0, 64, 1, 0); //2
      $form->sendToPlayer($player);
   }
   
   public function ShopBuyConfirm(Player $player, string $itemicon, int $count, int $price): void{
      $item = Item::fromString($itemicon);
      $item->setCount($count);
      $form = $this->getPlugin()->getFormAPI()->createModalForm(function ($player, $data) use ($item, $price){
         if(!($data === null)){
            if($data == 1){//ปุ่ม1
               if($this->getPlugin()->getMoneyAPI()->myMoney($player) >= $price){
                  $reduce = (int) $this->getPlugin()->getMoneyAPI()->myMoney($player) - $price;
                  $this->getPlugin()->getMoneyAPI()->setMoney($player, $reduce);
                  $player->getInventory()->addItem($item);
                  $player->sendMessage($this->getPrefix()." คุณได้ชื้อ ".$item->getName()." จำนวน ".$item->getCount()." ในราคา ".$price." เรียบร้อย!");
               }else{
                  $player->sendMessage($this->getPrefix()." §cเงินของคุณไม่เพียงพอ");
               }
            }
            if($data == 0){//ปุ่ม2
            }
         }
      });
      $form->setTitle($this->getPrefix()." Buy Confirm");
      $form->setContent($this->getPrefix()." §fคุณต้องการชื้อ §b".$item->getName()."\n§fจำนวน §e".$item->getCount()." §fในราคา §6".$price." §fหรือไม่?");
      $form->setButton1("§aชื้อ"); 
      $form->setButton2("§cไม่");
      $form->sendToPlayer($player);
   }
   
   public function ShopSellConfirm(Player $player, string $itemicon, int $count, int $price): void{
      $item = Item::fromString($itemicon);
      $item->setCount($count);
      $form = $this->getPlugin()->getFormAPI()->createModalForm(function ($player, $data) use ($item, $price){
         if(!($data === null)){
            if($data == 1){//ปุ่ม1
               if($player->getInventory()->contains($item)){
                  $this->getPlugin()->getMoneyAPI()->addMoney($player, $price);
                  $player->getInventory()->removeItem($item);
                  $player->sendMessage($this->getPrefix()." คุณได้ขาย ".$item->getName()." จำนวน ".$item->getCount()." ในราคา ".$price." เรียบร้อย!");
               }else{
                  $player->sendMessage($this->getPrefix()." §cไอเทมที่จะขายไม่เพียงพอ");
               }
            }
            if($data == 0){//ปุ่ม2
            }
         }
      });
      $form->setTitle($this->getPrefix()." Sell Confirm");
      $form->setContent($this->getPrefix()." §fคุณต้องการขาย §b".$item->getName()."\n§fจำนวน §e".$item->getCount()." §fในราคา §6".$price." §fหรือไม่?");
      $form->setButton1("§6ขาย"); 
      $form->setButton2("§cไม่");
      $form->sendToPlayer($player);
   }
}