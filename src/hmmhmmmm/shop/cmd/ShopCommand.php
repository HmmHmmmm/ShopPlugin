<?php

namespace hmmhmmmm\shop\cmd;

use hmmhmmmm\shop\Shop;

use pocketmine\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\Item;
use pocketmine\plugin\Plugin;

class ShopCommand extends Command{
   private $plugin;
   private $prefix;
   private $lang;
   
   public function __construct(Shop $plugin){
      parent::__construct("shop");
      $this->plugin = $plugin;
      $this->prefix = $this->plugin->getPrefix();
      $this->lang = $this->plugin->getLanguage();
   }
   
   public function getPlugin(): Plugin{
      return $this->plugin;
   }
   
   public function sendConsoleError(CommandSender $sender): void{
      $sender->sendMessage($this->lang->getTranslate(
         "shop.command.consoleError"
      ));
   }
      
   public function sendPermissionError(CommandSender $sender): void{
      $sender->sendMessage($this->lang->getTranslate(
         "shop.command.permissionError"
      ));
   }
   
   public function getPrefix(): string{
      return $this->prefix;
   }
   
   public function sendHelp(CommandSender $sender): void{
      $sender->sendMessage($this->getPrefix()." : §fCommand");
      if($sender->hasPermission("shop.command.info")){
         $sender->sendMessage("§a".$this->lang->getTranslate("shop.command.info.usage")." : ".$this->lang->getTranslate("shop.command.info.description"));
      }
      if($sender->hasPermission("shop.command.category.create")){
         $sender->sendMessage("§a".$this->lang->getTranslate("shop.command.category.create.usage")." : ".$this->lang->getTranslate("shop.command.category.create.description"));
      }
      if($sender->hasPermission("shop.command.category.remove")){
         $sender->sendMessage("§a".$this->lang->getTranslate("shop.command.category.remove.usage")." : ".$this->lang->getTranslate("shop.command.category.remove.description"));
      }
      if($sender->hasPermission("shop.command.category.additem")){
         $sender->sendMessage("§a".$this->lang->getTranslate("shop.command.category.additem.usage")." : ".$this->lang->getTranslate("shop.command.category.additem.description"));
      }
      if($sender->hasPermission("shop.command.category.removeitem")){
         $sender->sendMessage("§a".$this->lang->getTranslate("shop.command.category.removeitem.usage")." : ".$this->lang->getTranslate("shop.command.category.removeitem.description"));
      }
      if($sender->hasPermission("shop.command.category.icon")){
         $sender->sendMessage("§a".$this->lang->getTranslate("shop.command.category.icon.usage")." : ".$this->lang->getTranslate("shop.command.category.icon.description"));
      }
      if($sender->hasPermission("shop.command.category.changename")){
         $sender->sendMessage("§a".$this->lang->getTranslate("shop.command.category.changename.usage")." : ".$this->lang->getTranslate("shop.command.category.changename.description"));
      }
      if($sender->hasPermission("shop.command.category.list")){
         $sender->sendMessage("§a".$this->lang->getTranslate("shop.command.category.list.usage")." : ".$this->lang->getTranslate("shop.command.category.list.description"));
      }
      
   }
   
   public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
      if(empty($args)){
         if($sender instanceof Player){
            $this->getPlugin()->getShopChest()->sendChest($sender);
            $sender->sendMessage($this->lang->getTranslate(
               "shop.command.sendHelp.empty"
            ));
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
                  $sender->sendMessage($this->lang->getTranslate(
                     "shop.command.category.error1",
                     [$this->lang->getTranslate("shop.command.category.usage")]
                  ));
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
                        $sender->sendMessage($this->lang->getTranslate(
                           "shop.command.category.create.error1",
                           [$this->lang->getTranslate("shop.command.category.create.usage")]
                        ));
                        return true;
                     }
                     $name = array_shift($args);
                     if($this->getPlugin()->isCategory($name)){
                        $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                           "shop.command.category.create.error2",
                           [$name]
                        ));
                        return true;
                     }
                     if($this->getPlugin()->getCountCategory() >= 24){
                        $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                           "shop.command.category.create.error3"
                        ));
                        return true;
                     }
                     $nameFull = array_shift($args);
                     $id = (int) array_shift($args);
                     if(!is_numeric($id)){
                        $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                           "shop.command.category.create.error4"
                        ));
                        return true;
                     }
                     $damage = (int) array_shift($args);
                     if(!isset($damage)){
                        $damage = 0;
                     }
                     if(!is_numeric($damage)){
                        $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                           "shop.command.category.create.error5"
                        ));
                        return true;
                     }
                     $itemicon = $id.":".$damage;
                     $item = Item::fromString($itemicon);
                     if($item->getId() == 0){
                        $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                           "shop.command.category.create.error6",
                           [$itemicon]
                        ));
                        return true;
                     }
                     if($item->getName() == "Unknown"){
                        $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                           "shop.command.category.create.error7",
                           [$itemicon]
                        ));
                        return true;
                     }
                     $this->getPlugin()->createCategory($name, $nameFull, $itemicon);
                     $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                        "shop.command.category.create.complete",
                        [$name, $nameFull, $item->getName(), $itemicon]
                     ));
                     break;
                  case "remove":
                     if(!$sender->hasPermission("shop.command.category.remove")){
                        $this->sendPermissionError($sender);
                        return true;
                     }
                     if(count($args) < 1){
                        $sender->sendMessage($this->lang->getTranslate(
                           "shop.command.category.remove.error1",
                           [$this->lang->getTranslate("shop.command.category.remove.usage")]
                        ));
                        return true;
                     }
                     $name = array_shift($args);
                     if(!$this->getPlugin()->isCategory($name)){
                        $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                           "shop.command.category.remove.error2",
                           [$name]
                        ));
                        return true;
                     }
                     
                     $this->getPlugin()->removeCategory($name);
                     $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                        "shop.command.category.remove.complete",
                        [$name]
                     ));
                     break;
                  case "additem":
                     if(!$sender->hasPermission("shop.command.category.additem")){
                        $this->sendPermissionError($sender);
                        return true;
                     }
                     if(count($args) < 4){
                        $sender->sendMessage($this->lang->getTranslate(
                           "shop.command.category.additem.error1",
                           [$this->lang->getTranslate("shop.command.category.additem.usage")]
                        ));
                        return true;
                     }
                     $name = array_shift($args);
                     if(!$this->getPlugin()->isCategory($name)){
                        $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                           "shop.command.category.additem.error2",
                           [$name]
                        ));
                        return true;
                     }
                     $buyPrice = (int) array_shift($args);
                     if(!is_numeric($buyPrice)){
                        $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                           "shop.command.category.additem.error4"
                        ));
                        return true;
                     }
                     $sellPrice = (int) array_shift($args);
                     if(!is_numeric($sellPrice)){
                        $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                           "shop.command.category.additem.error5"
                        ));
                        return true;
                     }
                     $id = (int) array_shift($args);
                     if(!is_numeric($id)){
                        $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                           "shop.command.category.additem.error6"
                        ));
                        return true;
                     }
                     $damage = (int) array_shift($args);
                     if(!isset($damage)){
                        $damage = 0;
                     }
                     if(!is_numeric($damage)){
                        $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                           "shop.command.category.additem.error7"
                        ));
                        return true;
                     }
                     $itemicon = $id.":".$damage;
                     $item = Item::fromString($itemicon);
                     if($item->getId() == 0){
                        $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                           "shop.command.category.additem.error8",
                           [$itemicon]
                        ));
                        return true;
                     }
                     if($item->getName() == "Unknown"){
                        $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                           "shop.command.category.additem.error9",
                           [$itemicon]
                        ));
                        return true;
                     }
                     if($this->getPlugin()->isItem($name, $itemicon)){
                        $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                           "shop.command.category.additem.error10",
                           [$name, $item->getName(), $itemicon]
                        ));
                        return true;
                     }
                     $this->getPlugin()->addItem($name, $itemicon, $buyPrice, $sellPrice);
                     $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                        "shop.command.category.additem.complete",
                        [$item->getName(), $itemicon, $buyPrice, $sellPrice, $name]
                     ));
                     break;
                  case "removeitem":
                     if(!$sender->hasPermission("shop.command.category.removeitem")){
                        $this->sendPermissionError($sender);
                        return true;
                     }
                     if(count($args) < 2){
                        $sender->sendMessage($this->lang->getTranslate(
                           "shop.command.category.removeitem.error1",
                           [$this->lang->getTranslate(
                              "shop.command.category.removeitem.usage"
                            )
                           ]
                        ));
                        return true;
                     }
                     $name = array_shift($args);
                     if(!$this->getPlugin()->isCategory($name)){
                        $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                           "shop.command.category.removeitem.error2",
                           [$name]
                        ));
                        return true;
                     }
                     $id = (int) array_shift($args);
                     if(!is_numeric($id)){
                        $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                           "shop.command.category.removeitem.error3"
                        ));
                        return true;
                     }
                     $damage = (int) array_shift($args);
                     if(!isset($damage)){
                        $damage = 0;
                     }
                     if(!is_numeric($damage)){
                        $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                           "shop.command.category.removeitem.error4"
                        ));
                        return true;
                     }
                     $itemicon = $id.":".$damage;
                     if(!$this->getPlugin()->isItem($name, $itemicon)){
                        $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                           "shop.command.category.removeitem.error5",
                           [$itemicon, $name]
                        ));
                        return true;
                     }
                     $this->getPlugin()->removeItem($name, $itemicon);
                     $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                        "shop.command.category.removeitem.complete",
                        [$itemicon, $name]
                     ));
                     break;
                  case "changename":
                     if(!$sender->hasPermission("shop.command.category.changename")){
                        $this->sendPermissionError($sender);
                        return true;
                     }
                     if(count($args) < 2){
                        $sender->sendMessage($this->lang->getTranslate(
                           "shop.command.category.changename.error1",
                           [$this->lang->getTranslate(
                              "shop.command.category.changename.usage"
                            )
                           ]
                        ));
                        return true;
                     }
                     $name = array_shift($args);
                     if(!$this->getPlugin()->isCategory($name)){
                        $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                           "shop.command.category.changename.error2",
                           [$name]
                        ));
                        return true;
                     }
                     $nameFull = array_shift($args);
                     $this->getPlugin()->setCategoryName($name, $nameFull);
                     $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                        "shop.command.category.changename.complete",
                        [$nameFull, $name]
                     ));
                     break;
                  case "icon":
                     if(!$sender->hasPermission("shop.command.category.icon")){
                        $this->sendPermissionError($sender);
                        return true;
                     }
                     if(count($args) < 2){
                        $sender->sendMessage($this->lang->getTranslate(
                           "shop.command.category.icon.error1",
                           [$this->lang->getTranslate("shop.command.category.icon.usage")]
                        ));
                        return true;
                     }
                     $name = array_shift($args);
                     if(!$this->getPlugin()->isCategory($name)){
                        $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                           "shop.command.category.icon.error2",
                           [$name]
                        ));
                        return true;
                     }
                     $id = (int) array_shift($args);
                     if(!is_numeric($id)){
                        $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                           "shop.command.category.icon.error3"
                        ));
                        return true;
                     }
                     $damage = (int) array_shift($args);
                     if(!isset($damage)){
                        $damage = 0;
                     }
                     if(!is_numeric($damage)){
                        $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                           "shop.command.category.icon.error4"
                        ));
                        return true;
                     }
                     $itemicon = $id.":".$damage;
                     $item = Item::fromString($itemicon);
                     if($item->getId() == 0){
                        $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                           "shop.command.category.icon.error5",
                           [$itemicon]
                        ));
                        return true;
                     }
                     if($item->getName() == "Unknown"){
                        $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                           "shop.command.category.icon.error6",
                           [$itemicon]
                        ));
                        return true;
                     }
                     $this->getPlugin()->setCategoryIcon($name, $itemicon);
                     $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                        "shop.command.category.icon.complete",
                        [$item->getName(), $itemicon, $name]
                     ));
                     break;
                  case "list":
                     if(!$sender->hasPermission("shop.command.category.list")){
                        $this->sendPermissionError($sender);
                        return true;
                     }
                     if($this->getPlugin()->getCountCategory() == 0){
                        $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                           "shop.command.category.list.error1"
                        ));
                        return true;
                     }
                     $sender->sendMessage($this->getPrefix()." ".$this->lang->getTranslate(
                        "shop.command.category.list.complete",
                        [implode(", ", $this->getPlugin()->getCategory())]
                     ));
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