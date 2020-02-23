<?php

namespace hmmhmmmm\shop;

use pocketmine\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\item\Item;
use pocketmine\plugin\Plugin;

class ShopCommand extends Command implements PluginIdentifiableCommand{
   private $plugin;
   public function __construct(Shop $plugin){
      parent::__construct("shop");
      $this->plugin = $plugin;
   }
   public function getPlugin(): Plugin{
      return $this->plugin;
   }
   public function sendConsoleError(CommandSender $sender): void{
      $sender->sendMessage("§cขออภัย: คำสั่งสามารถพิมพ์ได้เฉพาะในเกมส์");
   }
   public function sendPermissionError(CommandSender $sender): void{
      $sender->sendMessage("§cขออภัย: คุณไม่สามารถพิมพ์คำสั่งนี้ได้");
   }
   public function getPrefix(): string{
      return $this->getPlugin()->getPrefix();
   }
   public function sendHelp(CommandSender $sender): void{
      $sender->sendMessage($this->getPrefix()." : §fCommand");
      if($sender->hasPermission("shop.command.info")){
         $sender->sendMessage("§a/shop info : §fเครดิตผู้สร้างปลั๊กอิน");
      }
      if($sender->hasPermission("shop.command.category.create")){
         $sender->sendMessage("§a/shop category create <ตั้งชื่อรายการ> <ชื่อเต็มของรายการ> <itemId> <itemDamage> : §fสร้างรายการ");
      }
      if($sender->hasPermission("shop.command.category.remove")){
         $sender->sendMessage("§a/shop category remove <ชื่อรายการ> : §fลบรายการ");
      }
      if($sender->hasPermission("shop.command.category.additem")){
         $sender->sendMessage("§a/shop category additem <ชื่อรายการ> <ราคาชื้อ> <ราคาขาย> <itemId> <itemDamage> : §fเพิ่มไอเทมในรายการ");
      }
      if($sender->hasPermission("shop.command.category.removeitem")){
         $sender->sendMessage("§a/shop category removeitem <ชื่อรายการ> <itemId> <itemDamage> : §fลบไอเทมในรายการ");
      }
      if($sender->hasPermission("shop.command.category.icon")){
         $sender->sendMessage("§a/shop category icon <ชื่อรายการ> <itemId> <itemDamage> : §fเปลี่ยนiconในรายการ");
      }
      if($sender->hasPermission("shop.command.category.changename")){
         $sender->sendMessage("§a/shop category changename <ชื่อรายการ> <ชื่อเต็มของรายการ> : §fเปลี่ยนชื่อเต็มในรายการ");
      }
      if($sender->hasPermission("shop.command.category.list")){
         $sender->sendMessage("§a/shop category list : §fดูรายการทั้งหมด");
      }
      
   }
   public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
      if(empty($args)){
         if($sender instanceof Player){
            $this->getPlugin()->getChestMenu()->create($sender);
            $sender->sendMessage("§eคุณสามารถดูคำสั่งเพิ่มเติมได้โดยใช้ /shop help");
         }else{
            $this->sendHelp($sender);
         }
         return true;
      }
      $sub = array_shift($args);            
      if(isset($sub)){
         switch($sub){
            case "help":
               $this->sendHelp($sender);
               break;
            case "info":
               if(!$sender->hasPermission("shop.command.info")){
                  $this->sendPermissionError($sender);
                  return true;
               }
               $sender->sendMessage($this->getPlugin()->getPluginInfo());
               break;
            case "category":
            case "c":
               if(count($args) < 1){
                  $sender->sendMessage("§cลอง: /quest category create|remove|additem|removeitem|icon|changename|list|");
                  return true;
               }
               $sub_data = array_shift($args);
               switch($sub_data){
                  case "create":
                     if(!$sender->hasPermission("shop.command.category.create")){
                        $this->sendPermissionError($sender);
                        return true;
                     }
                     if(count($args) < 3){
                        $sender->sendMessage("§cลอง: /shop category create <ตั้งชื่อรายการ> <ชื่อเต็มของรายการ> <itemId> <itemDamage>");
                        return true;
                     }
                     $name = array_shift($args);
                     if($this->getPlugin()->isCategory($name)){
                        $sender->sendMessage($this->getPrefix()." §cรายการ ".$name." มีอยู่แล้ว");
                        return true;
                     }
                     if($this->getPlugin()->getCountCategory() >= 24){
                        $sender->sendMessage($this->getPrefix()." §cไม่สามารถเพิ่มรายการได้เกิน 24รายการ");
                        return true;
                     }
                     $nameFull = array_shift($args);
                     $id = (int) array_shift($args);
                     if(!is_numeric($id)){
                        $sender->sendMessage($this->getPrefix()." §c<itemId> กรุณาเขียนให้เป็นตัวเลข");
                        return true;
                     }
                     $damage = (int) array_shift($args);
                     if(!isset($damage)){
                        $damage = 0;
                     }
                     if(!is_numeric($damage)){
                        $sender->sendMessage($this->getPrefix()." §c<itemDamage> กรุณาเขียนให้เป็นตัวเลข");
                        return true;
                     }
                     $itemicon = $id.":".$damage;
                     $item = Item::fromString($itemicon);
                     if($item->getId() == 0){
                        $sender->sendMessage($this->getPrefix()." §cไม่สามารถใช้ไอเทม ".$itemicon." ได้");
                        return true;
                     }
                     if($item->getName() == "Unknown"){
                        $sender->sendMessage($this->getPrefix()." §cไอเทม ".$itemicon." ไม่ได้อยู่ในเกมส์");
                        return true;
                     }
                     $this->getPlugin()->createCategory($name, $nameFull, $itemicon);
                     $sender->sendMessage($this->getPrefix()." คุณได้สร้างรายการ ".$name."(".$nameFull.") icon ".$item->getName()." ".$itemicon." เรียบร้อย!");
                     break;
                  case "remove":
                     if(!$sender->hasPermission("shop.command.category.remove")){
                        $this->sendPermissionError($sender);
                        return true;
                     }
                     if(count($args) < 1){
                        $sender->sendMessage("§cลอง: /shop category remove <ชื่อรายการ>");
                        return true;
                     }
                     $name = array_shift($args);
                     if(!$this->getPlugin()->isCategory($name)){
                        $sender->sendMessage($this->getPrefix()." §cไม่พบรายการ ".$name);
                        return true;
                     }
                     
                     $this->getPlugin()->removeCategory($name);
                     $sender->sendMessage($this->getPrefix()." คุณได้ลบรายการ ".$name." เรียบร้อย!");
                     break;
                  case "additem":
                     if(!$sender->hasPermission("shop.command.category.additem")){
                        $this->sendPermissionError($sender);
                        return true;
                     }
                     if(count($args) < 4){
                        $sender->sendMessage("§cลอง: /shop category additem <ชื่อรายการ> <ราคาชื้อ> <ราคาขาย> <itemId> <itemDamage>");
                        return true;
                     }
                     $name = array_shift($args);
                     if(!$this->getPlugin()->isCategory($name)){
                        $sender->sendMessage($this->getPrefix()." §cไม่พบรายการ ".$name);
                        return true;
                     }
                     if($this->getPlugin()->getCountItems($name) >= 24){
                        $sender->sendMessage($this->getPrefix()." §cไม่สามารถเพิ่มไอเทมได้เกิน 24ชิ้น");
                        return true;
                     }
                     $buyPrice = (int) array_shift($args);
                     if(!is_numeric($buyPrice)){
                        $sender->sendMessage($this->getPrefix()." §c<ราคาชื้อ> กรุณาเขียนให้เป็นตัวเลข");
                        return true;
                     }
                     $sellPrice = (int) array_shift($args);
                     if(!is_numeric($sellPrice)){
                        $sender->sendMessage($this->getPrefix()." §c<ราคาขาย> กรุณาเขียนให้เป็นตัวเลข");
                        return true;
                     }
                     $id = (int) array_shift($args);
                     if(!is_numeric($id)){
                        $sender->sendMessage($this->getPrefix()." §c<itemId> กรุณาเขียนให้เป็นตัวเลข");
                        return true;
                     }
                     $damage = (int) array_shift($args);
                     if(!isset($damage)){
                        $damage = 0;
                     }
                     if(!is_numeric($damage)){
                        $sender->sendMessage($this->getPrefix()." §c<itemDamage> กรุณาเขียนให้เป็นตัวเลข");
                        return true;
                     }
                     $itemicon = $id.":".$damage;
                     $item = Item::fromString($itemicon);
                     if($item->getId() == 0){
                        $sender->sendMessage($this->getPrefix()." §cไม่สามารถใช้ไอเทม ".$itemicon." ได้");
                        return true;
                     }
                     if($item->getName() == "Unknown"){
                        $sender->sendMessage($this->getPrefix()." §cไอเทม ".$itemicon." ไม่ได้อยู่ในเกมส์");
                        return true;
                     }
                     if($this->getPlugin()->isItem($name, $itemicon)){
                        $sender->sendMessage($this->getPrefix()." §cรายการ ".$name." ไอเทม ".$item->getName()." ".$itemicon." มีอยู่แล้ว");
                        return true;
                     }
                     $this->getPlugin()->addItem($name, $itemicon, $buyPrice, $sellPrice);
                     $sender->sendMessage($this->getPrefix()." คุณได้เพิ่มไอเทม ".$item->getName()." ".$itemicon." ราคาชื้อ ".$buyPrice." ราคาขาย ".$sellPrice." ในรายการ ".$name." เรียบร้อย!");
                     break;
                  case "removeitem":
                     if(!$sender->hasPermission("shop.command.category.removeitem")){
                        $this->sendPermissionError($sender);
                        return true;
                     }
                     if(count($args) < 2){
                        $sender->sendMessage("§cลอง: /shop category removeitem <ชื่อรายการ> <itemId> <itemDamage>");
                        return true;
                     }
                     $name = array_shift($args);
                     if(!$this->getPlugin()->isCategory($name)){
                        $sender->sendMessage($this->getPrefix()." §cไม่พบรายการ ".$name);
                        return true;
                     }
                     $id = (int) array_shift($args);
                     if(!is_numeric($id)){
                        $sender->sendMessage($this->getPrefix()." §c<itemId> กรุณาเขียนให้เป็นตัวเลข");
                        return true;
                     }
                     $damage = (int) array_shift($args);
                     if(!isset($damage)){
                        $damage = 0;
                     }
                     if(!is_numeric($damage)){
                        $sender->sendMessage($this->getPrefix()." §c<itemDamage> กรุณาเขียนให้เป็นตัวเลข");
                        return true;
                     }
                     $itemicon = $id.":".$damage;
                     if(!$this->getPlugin()->isItem($name, $itemicon)){
                        $sender->sendMessage($this->getPrefix()." §cพบไอเทม ".$itemicon." ในรายการ ".$name);
                        return true;
                     }
                     $this->getPlugin()->removeItem($name, $itemicon);
                     $sender->sendMessage($this->getPrefix()." คุณได้ลบไอเทม ".$itemicon." ในรายการ ".$name." เรียบร้อย!");
                     break;
                  case "changename":
                     if(!$sender->hasPermission("shop.command.category.changename")){
                        $this->sendPermissionError($sender);
                        return true;
                     }
                     if(count($args) < 2){
                        $sender->sendMessage("§cลอง: /shop category changename <ชื่อรายการ> <ชื่อเต็มของรายการ>");
                        return true;
                     }
                     $name = array_shift($args);
                     if(!$this->getPlugin()->isCategory($name)){
                        $sender->sendMessage($this->getPrefix()." §cไม่พบรายการ ".$name);
                        return true;
                     }
                     $nameFull = array_shift($args);
                     $this->getPlugin()->setCategoryName($name, $nameFull);
                     $sender->sendMessage($this->getPrefix()." คุณได้เปลี่ยนชื่อเต็มของรายการเป็น ".$nameFull." ในรายการ ".$name." เรียบร้อย!");
                     break;
                  case "icon":
                     if(!$sender->hasPermission("shop.command.category.icon")){
                        $this->sendPermissionError($sender);
                        return true;
                     }
                     if(count($args) < 2){
                        $sender->sendMessage("§cลอง: /shop category icon <ชื่อรายการ> <itemId> <itemDamage>");
                        return true;
                     }
                     $name = array_shift($args);
                     if(!$this->getPlugin()->isCategory($name)){
                        $sender->sendMessage($this->getPrefix()." §cไม่พบรายการ ".$name);
                        return true;
                     }
                     $id = (int) array_shift($args);
                     if(!is_numeric($id)){
                        $sender->sendMessage($this->getPrefix()." §c<itemId> กรุณาเขียนให้เป็นตัวเลข");
                        return true;
                     }
                     $damage = (int) array_shift($args);
                     if(!isset($damage)){
                        $damage = 0;
                     }
                     if(!is_numeric($damage)){
                        $sender->sendMessage($this->getPrefix()." §c<itemDamage> กรุณาเขียนให้เป็นตัวเลข");
                        return true;
                     }
                     $itemicon = $id.":".$damage;
                     $item = Item::fromString($itemicon);
                     if($item->getId() == 0){
                        $sender->sendMessage($this->getPrefix()." §cไม่สามารถใช้ไอเทม ".$itemicon." ได้");
                        return true;
                     }
                     if($item->getName() == "Unknown"){
                        $sender->sendMessage($this->getPrefix()." §cไอเทม ".$itemicon." ไม่ได้อยู่ในเกมส์");
                        return true;
                     }
                     $this->getPlugin()->setCategoryIcon($name, $itemicon);
                     $sender->sendMessage($this->getPrefix()." คุณได้เปลี่ยน icon เป็น ".$item->getName()." ".$itemicon." ในรายการ ".$name." เรียบร้อย!");
                     break;
                  case "list":
                     if(!$sender->hasPermission("shop.command.category.list")){
                        $this->sendPermissionError($sender);
                        return true;
                     }
                     if($this->getPlugin()->getCountCategory() == 0){
                        $sender->sendMessage($this->getPrefix()." §cไม่มีรายการ");
                        return true;
                     }
                     $sender->sendMessage($this->getPrefix()." ชื่อรายการทั้งหมด ".implode(", ", $this->getPlugin()->getCategory()));
                     break;
               }
               break;
            default:
               $this->sendHelp($sender);
               break;
         }
      }
      return true;
   }
}