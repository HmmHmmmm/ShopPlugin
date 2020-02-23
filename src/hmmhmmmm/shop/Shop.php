<?php

namespace hmmhmmmm\shop;

use pocketmine\Player;
use pocketmine\event\Listener;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\inventory\InventoryCloseEvent;
use pocketmine\inventory\ChestInventory;
use pocketmine\inventory\transaction\action\SlotChangeAction;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\plugin\PluginBase;
use pocketmine\plugin\Plugin;
use pocketmine\utils\Config;

class Shop extends PluginBase implements Listener{
   private static $instance = null;
   private $prefix = "?";
   private $facebook = "§cไม่มี";
   private $youtube = "§cไม่มี";
   private $data = null;
   public $array = [];
   private $form = null;
   private $formapi = null;
   private $moneyapi = null;
   private $chestmenu = null;

   public static function getInstance(){
      return self::$instance;
   }
   public function onLoad(){
      self::$instance = $this;
   } 
   public function onEnable(){
      @mkdir($this->getDataFolder());
      $this->data = new Config($this->getDataFolder()."shop.yml", Config::YAML, array());
      $this->prefix = "Shop";
      $this->facebook = "https://m.facebook.com/phonlakrit.knaongam.1";
      $this->youtube = "https://m.youtube.com/channel/UCtjvLXDxDAUt-8CXV1eWevA";
      $this->form = new Form($this);
      $this->chestmenu = new ChestMenu($this);
      $this->getServer()->getPluginManager()->registerEvents($this, $this);
      $cmd = [
         new ShopCommand($this)
      ];
      foreach($cmd as $command){
         $this->getServer()->getCommandMap()->register($command->getName(), $command);
      }
      
      if($this->getServer()->getPluginManager()->getPlugin("FormAPI") === null){
         $this->getLogger()->critical("§cปลั๊กนี้จะไม่ทำงาน กรุณาลงปลั๊กอิน FormAPI");
         $this->getServer()->getPluginManager()->disablePlugin($this);
      }else{
         $this->formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
      }
      if($this->getServer()->getPluginManager()->getPlugin("EconomyAPI") === null){
         $this->getLogger()->critical("§cปลั๊กนี้จะไม่ทำงาน กรุณาลงปลั๊กอิน EconomyAPI");
         $this->getServer()->getPluginManager()->disablePlugin($this);
      }else{
         $this->moneyapi = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
      }
      $this->getServer()->getLogger()->info($this->getPluginInfo());
   }
   public function getPrefix(): string{
      return "§b[§6".$this->prefix."§b]§f";
   }
   public function getFacebook(): string{
      return $this->facebook;
   }
   public function getYoutube(): string{
      return $this->youtube;
   }
   public function getPluginInfo(): string{
      $author = $this->getDescription()->getAuthors();
      $text = "\n".$this->getPrefix()." ชื่อปลั๊กอิน ".$this->getDescription()->getName()."\n".$this->getPrefix()." เวอร์ชั่น ".$this->getDescription()->getVersion()."\n".$this->getPrefix()." รายชื่อผู้สร้าง ".implode(", ", $author)."\n".$this->getPrefix()." คำอธิบายของปลั๊กอิน: ปลั๊กอินนี้ทำแจก โปรดอย่าเอาไปขาย *หากจะเอาไปแจกต่อโปรดให้เครดิตด้วย*\n".$this->getPrefix()." เฟสบุ๊ค ".$this->getFacebook()."\n".$this->getPrefix()." ยูทูป ".$this->getYoutube()."\n".$this->getPrefix()." เว็บไซต์ ".$this->getDescription()->getWebsite();
      return $text;   }
   public function getData(): Config{
      return $this->data;
   }
   public function getForm(): Form{
      return $this->form;
   }
   public function getFormAPI(): Plugin{
      return $this->formapi;
   }
   public function getMoneyAPI(): Plugin{
      return $this->moneyapi;
   }
   public function getChestMenu(): ChestMenu{
      return $this->chestmenu;
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
               if(isset($this->array["chestmenu"][$player->getName()])){
                  $event->setCancelled(true);                 
                  if($chestItem->getCustomName() == "§cออก"){
                     $chestinv->onClose($player);
                  }
                  if($chestItem->getCustomName() == "§eกลับ"){
                     $chestinv->setContents($this->getChestMenu()->sendMenu());
                  }
                  if($this->getCountCategory() !== 0){
                     foreach($this->getCategory() as $category){
                        if($this->getCountItems($category) !== 0){
                           if($chestItem->getCustomName() == $this->getCategoryName($category)){
                              $chestinv->clearAll();
                              $chestinv->setContents($this->getChestMenu()->sendItem($category));
                           }
                           if($chestItem->getCustomName() == null){
                              $id = $chestItem->getId();
                              $damage = $chestItem->getDamage();
                              $itemicon = $id.":".$damage;
                              if($chestItem->hasCustomBlockData()){
                                 $category = $chestItem->getCustomBlockData()->getString("รายการ");
                                 $buyPrice = $this->getBuyPrice($category, $itemicon);
                                 $sellPrice = $this->getSellPrice($category, $itemicon);
                                 $chestinv->onClose($player);
                                 $this->getForm()->ShopUI($player, $itemicon, $buyPrice, $sellPrice);
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
         if(isset($this->array["chestmenu"][$player->getName()])){
            $v3 = $inventory->getHolder(); //ลบ tile chest กันความแลคในอนาคต
            $player->getLevel()->sendBlocks([$player], [$v3]);
            unset($this->array["chestmenu"][$player->getName()]);
         }
      }
   }
   public function getCategory(): array{
      $shopData = $this->getData();
      $data = $shopData->getAll();
      return array_keys($data);
   }
   public function getCountCategory(): int{
      $shopData = $this->getData();
      $data = $shopData->getAll();
      return count($data);
   }
   public function isCategory(string $category): bool{
      $shopData = $this->getData();
      $data = $shopData->getAll();
      return isset($data[$category]);
   }
   public function createCategory(string $category, string $name, string $itemicon): void{
      $shopData = $this->getData();
      $data = $shopData->getAll();
      $data[$category]["name"] = $name;
      $data[$category]["icon"] = $itemicon;
      $data[$category]["items"] = [];
      $shopData->setAll($data);
      $shopData->save();
   }
   public function removeCategory(string $category): void{
      $shopData = $this->getData();
      $data = $shopData->getAll();
      unset($data[$category]);
      $shopData->setAll($data);
      $shopData->save();
   }
   public function getCategoryName(string $category): string{
      $shopData = $this->getData();
      $data = $shopData->getAll();
      return $data[$category]["name"];
   }
   public function setCategoryName(string $category, string $nameNew): void{
      $shopData = $this->getData();
      $data = $shopData->getAll();
      $data[$category]["name"] = $nameNew;
      $shopData->setAll($data);
      $shopData->save();
   }
   public function getCategoryIcon(string $category): string{
      $shopData = $this->getData();
      $data = $shopData->getAll();
      return $data[$category]["icon"];
   }
   public function setCategoryIcon(string $category, string $itemiconNew): void{
      $shopData = $this->getData();
      $data = $shopData->getAll();
      $data[$category]["icon"] = $itemiconNew;
      $shopData->setAll($data);
      $shopData->save();
   }
   public function getItems(string $category): array{
      $shopData = $this->getData();
      $data = $shopData->getAll();
      return array_keys($data[$category]["items"]);
   }
   public function getCountItems(string $category): int{
      $shopData = $this->getData();
      $data = $shopData->getAll();
      return count($data[$category]["items"]);
   }
   public function isItem(string $category, string $itemicon): bool{
      $shopData = $this->getData();
      $data = $shopData->getAll();
      return isset($data[$category]["items"][$itemicon]);
   }
   public function addItem(string $category, string $itemicon, int $buyPrice, int $sellPrice): void{
      $shopData = $this->getData();
      $data = $shopData->getAll();
      $data[$category]["items"][$itemicon]["buyPrice"] = $buyPrice;
      $data[$category]["items"][$itemicon]["sellPrice"] = $sellPrice;
      $shopData->setAll($data);
      $shopData->save();
   }
   public function removeItem(string $category, string $itemicon): void{
      $shopData = $this->getData();
      $data = $shopData->getAll();
      unset($data[$category]["items"][$itemicon]);
      $shopData->setAll($data);
      $shopData->save();
   }
   public function getBuyPrice(string $category, string $itemicon): int{
      $shopData = $this->getData();
      $data = $shopData->getAll();
      return $data[$category]["items"][$itemicon]["buyPrice"];
   }
   public function getSellPrice(string $category, string $itemicon): int{
      $shopData = $this->getData();
      $data = $shopData->getAll();
      return $data[$category]["items"][$itemicon]["sellPrice"];
   }
}