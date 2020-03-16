<?php

namespace hmmhmmmm\shop\ui;

use hmmhmmmm\shop\Shop;
use xenialdan\customui\elements\Button;
use xenialdan\customui\elements\Dropdown;
use xenialdan\customui\elements\Input;
use xenialdan\customui\elements\Label;
use xenialdan\customui\elements\Slider;
use xenialdan\customui\elements\StepSlider;
use xenialdan\customui\elements\Toggle;
use xenialdan\customui\windows\CustomForm;
use xenialdan\customui\windows\ModalForm;
use xenialdan\customui\windows\SimpleForm;

use pocketmine\Player;
use pocketmine\item\Item;

class ShopForm{
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
   
   public function Menu(Player $player, string $itemicon, int $buyPrice, int $sellPrice): void{
      $item = Item::fromString($itemicon);
      $form = new CustomForm(
         $this->getPrefix()." Menu"
      );
      $form->addElement(new Label($this->getPrefix()." ".$this->lang->getTranslate(
         "form.shopui.label",
         [$item->getName(), $itemicon, $buyPrice, $sellPrice]
      )));
      $menu = [
         $this->lang->getTranslate("form.shopui.stepslider.step1"),
         $this->lang->getTranslate("form.shopui.stepslider.step2")
      ];
      $form->addElement(new Toggle(
         $this->lang->getTranslate(
            "form.shopui.stepslider.title"
         )." ".$this->lang->getTranslate(
            "form.shopui.stepslider.step1"
         )."|".$this->lang->getTranslate(
            "form.shopui.stepslider.step2"
         ),
         true
      ));
      $form->addElement(new Slider(
         $this->lang->getTranslate("form.shopui.slider.title"),
         0, 64, 1, 0
      ));
      $form->setCallable(function ($player, $data) use ($buyPrice, $sellPrice, $itemicon){
         if($data == null){
            return;
         }
         $count = (int) $data[2];
         if(!$data[1]){
            $price = $buyPrice * $count;
            $this->BuyConfirm($player, $itemicon, $count, $price);
         }else{
            $price = $sellPrice * $count;
            $this->SellConfirm($player, $itemicon, $count, $price);
         }
      });
      
      $form->setCallableClose(function (Player $player){
         //??
      });
      $player->sendForm($form);
   }
   
   public function BuyConfirm(Player $player, string $itemicon, int $count, int $price): void{
      $item = Item::fromString($itemicon);
      $item->setCount($count);
      $form = new ModalForm(
         $this->getPrefix()." Buy Confirm",
         $this->getPrefix()." ".$this->lang->getTranslate(
            "form.shopbuyconfirm.content",
            [$item->getName(), $item->getCount(), $price]
         ),
         $this->lang->getTranslate("form.shopbuyconfirm.button1"),
         $this->lang->getTranslate("form.shopbuyconfirm.button2")
      );
      $form->setCallable(function ($player, $data) use ($item, $price){
         if(!($data === null)){
            if($data){
               if($this->getPlugin()->getMoneyAPI()->myMoney($player) >= $price){
                  $reduce = (int) $this->getPlugin()->getMoneyAPI()->myMoney($player) - $price;
                  $this->getPlugin()->getMoneyAPI()->setMoney($player, $reduce);
                  $player->getInventory()->addItem($item);
                  $player->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                     "form.shopbuyconfirm.complete",
                     [$item->getName(), $item->getCount(), $price]
                  ));
               }else{
                  $player->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                     "form.shopbuyconfirm.error1"
                  ));
               }
            }
         }
      });
      $form->setCallableClose(function (Player $player){
         //??
      });
      $player->sendForm($form);
   }
   
   public function SellConfirm(Player $player, string $itemicon, int $count, int $price): void{
      $item = Item::fromString($itemicon);
      $item->setCount($count);
      $form = new ModalForm(
         $this->getPrefix()." Sell Confirm",
         $this->getPrefix()." ".$this->lang->getTranslate(
            "form.shopsellconfirm.content",
            [$item->getName(), $item->getCount(), $price]
         ),
         $this->lang->getTranslate("form.shopsellconfirm.button1"),
         $this->lang->getTranslate("form.shopsellconfirm.button2")
      );
      $form->setCallable(function ($player, $data) use ($item, $price){
         if(!($data === null)){
            if($data){
               if($player->getInventory()->contains($item)){
                  $this->getPlugin()->getMoneyAPI()->addMoney($player, $price);
                  $player->getInventory()->removeItem($item);
                  $player->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                     "form.shopsellconfirm.complete",
                     [$item->getName(), $item->getCount(), $price]
                  ));
               }else{
                  $player->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                     "form.shopsellconfirm.error1"
                  ));
               }
            }
         }
      });
      $form->setCallableClose(function (Player $player){
         //??
      });
      $player->sendForm($form);
   }
   
}