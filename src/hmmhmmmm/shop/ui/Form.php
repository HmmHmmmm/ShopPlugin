<?php

namespace hmmhmmmm\shop\ui;

use hmmhmmmm\shop\Shop;
use jojoe77777\FormAPI\CustomForm;
use jojoe77777\FormAPI\ModalForm;
use jojoe77777\FormAPI\SimpleForm;

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
   
   public function createCustomForm(?callable $function = null): CustomForm{
      return new CustomForm($function);
   }
   public function createSimpleForm(?callable $function = null): SimpleForm{
      return new SimpleForm($function);
   }
   public function createModalForm(?callable $function = null): ModalForm{
      return new ModalForm($function);
   }
   
   public function ShopUI(Player $player, string $itemicon, int $buyPrice, int $sellPrice): void{
      $item = Item::fromString($itemicon);
      $form = $this->createCustomForm(function ($player, $data) use ($buyPrice, $sellPrice, $itemicon){
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
      $form->addLabel($this->getPrefix()." ".$this->getPlugin()->getLanguage()->getTranslate("form.shopui.label", [$item->getName(), $itemicon, $buyPrice, $sellPrice]));
      $form->addStepSlider($this->getPlugin()->getLanguage()->getTranslate("form.shopui.stepslider.title"), [$this->getPlugin()->getLanguage()->getTranslate("form.shopui.stepslider.step1"), $this->getPlugin()->getLanguage()->getTranslate("form.shopui.stepslider.step2")]);
      $form->addSlider($this->getPlugin()->getLanguage()->getTranslate("form.shopui.slider.title"), 0, 64, 1, 0);
      $form->sendToPlayer($player);
   }
   
   public function ShopBuyConfirm(Player $player, string $itemicon, int $count, int $price): void{
      $item = Item::fromString($itemicon);
      $item->setCount($count);
      $form = $this->createModalForm(function ($player, $data) use ($item, $price){
         if(!($data === null)){
            if($data == 1){//ปุ่ม1
               if($this->getPlugin()->getMoneyAPI()->myMoney($player) >= $price){
                  $reduce = (int) $this->getPlugin()->getMoneyAPI()->myMoney($player) - $price;
                  $this->getPlugin()->getMoneyAPI()->setMoney($player, $reduce);
                  $player->getInventory()->addItem($item);
                  $player->sendMessage($this->getPrefix()." ".$this->getPlugin()->getLanguage()->getTranslate("form.shopbuyconfirm.complete", [$item->getName(), $item->getCount(), $price]));
               }else{
                  $player->sendMessage($this->getPrefix()." ".$this->getPlugin()->getLanguage()->getTranslate("form.shopbuyconfirm.error1"));
               }
            }
            if($data == 0){//ปุ่ม2
            }
         }
      });
      $form->setTitle($this->getPrefix()." Buy Confirm");
      $form->setContent($this->getPrefix()." ".$this->getPlugin()->getLanguage()->getTranslate("form.shopbuyconfirm.content", [$item->getName(), $item->getCount(), $price]));
      $form->setButton1($this->getPlugin()->getLanguage()->getTranslate("form.shopbuyconfirm.button1")); 
      $form->setButton2($this->getPlugin()->getLanguage()->getTranslate("form.shopbuyconfirm.button2"));
      $form->sendToPlayer($player);
   }
   
   public function ShopSellConfirm(Player $player, string $itemicon, int $count, int $price): void{
      $item = Item::fromString($itemicon);
      $item->setCount($count);
      $form = $this->createModalForm(function ($player, $data) use ($item, $price){
         if(!($data === null)){
            if($data == 1){//ปุ่ม1
               if($player->getInventory()->contains($item)){
                  $this->getPlugin()->getMoneyAPI()->addMoney($player, $price);
                  $player->getInventory()->removeItem($item);
                  $player->sendMessage($this->getPrefix()." ".$this->getPlugin()->getLanguage()->getTranslate("form.shopsellconfirm.complete", [$item->getName(), $item->getCount(), $price]));
               }else{
                  $player->sendMessage($this->getPrefix()." ".$this->getPlugin()->getLanguage()->getTranslate("form.shopsellconfirm.error1"));
               }
            }
            if($data == 0){//ปุ่ม2
            }
         }
      });
      $form->setTitle($this->getPrefix()." Sell Confirm");
      $form->setContent($this->getPrefix()." ".$this->getPlugin()->getLanguage()->getTranslate("form.shopsellconfirm.content", [$item->getName(), $item->getCount(), $price]));
      $form->setButton1($this->getPlugin()->getLanguage()->getTranslate("form.shopsellconfirm.button1")); 
      $form->setButton2($this->getPlugin()->getLanguage()->getTranslate("form.shopsellconfirm.button2"));
      $form->sendToPlayer($player);
   }
}