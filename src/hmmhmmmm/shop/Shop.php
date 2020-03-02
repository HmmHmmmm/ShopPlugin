<?php

namespace hmmhmmmm\shop;

use hmmhmmmm\shop\cmd\ShopCommand;
use hmmhmmmm\shop\data\Language;
use hmmhmmmm\shop\database\Database;
use hmmhmmmm\shop\database\YML;
use hmmhmmmm\shop\listener\EventListener;
use hmmhmmmm\shop\ui\ShopChest;
use hmmhmmmm\shop\ui\ShopForm;
use xenialdan\customui\API as XenialdanCustomUI;
use muqsit\invmenu\InvMenu;
use muqsit\invmenu\InvMenuHandler;

use pocketmine\plugin\PluginBase;
use pocketmine\plugin\Plugin;
use pocketmine\utils\Config;

class Shop extends PluginBase{
   private $prefix = "?";
   private $facebook = "§cwithout";
   private $youtube = "§cwithout";
   private $discord = "§cwithout";
   private $language = null;
   private $data = null;
   public $array = [];
   private $shopform = null;
   private $moneyapi = null;
   private $shopchest = null;
   public $eventListener = null;
   
   public $database;

   private $langClass = [
      "thai",
      "english"
   ];
   
   public function onEnable(): void{
      @mkdir($this->getDataFolder());
      @mkdir($this->getDataFolder()."language/");
      $this->saveDefaultConfig();
      $this->prefix = "Shop";
      $this->youtube = "https://bit.ly/2HL1j28";
      $langConfig = $this->getConfig()->getNested("language");
      if(!in_array($langConfig, $this->langClass)){
         $this->getLogger()->error("§cNot found language ".$langConfig.", Please try ".implode(", ", $this->langClass));
         $this->getServer()->getPluginManager()->disablePlugin($this);
         return;
      }else{
         $this->language = new Language($this, $langConfig);
         $this->shopform = new ShopForm($this);
         $this->eventListener = new EventListener($this);
         $this->getServer()->getCommandMap()->register("ShopPlugin", new ShopCommand($this));
         $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
         switch($this->getConfig()->getNested("database")){
            case "yml":
               $this->database = new YML($this, "Yaml");
               break;
            default:
               $this->database = new YML($this, "Yaml");
               break;
         }
      }
      if($this->getServer()->getPluginManager()->getPlugin("EconomyAPI") === null){
         $this->getLogger()->error($this->language->getTranslate("notfound.plugin", ["EconomyAPI"]));
         $this->getServer()->getPluginManager()->disablePlugin($this);
         return;
      }else{
         $this->moneyapi = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
      }
      if(!class_exists(XenialdanCustomUI::class)){
         $this->getLogger()->error($this->language->getTranslate("notfound.libraries", ["CustomUI"]));
         $this->getServer()->getPluginManager()->disablePlugin($this);
         return;
      }
      if(!class_exists(InvMenu::class)){
         $this->getLogger()->error($this->language->getTranslate("notfound.libraries", ["InvMenu"]));
         $this->getServer()->getPluginManager()->disablePlugin($this);
         return;
      }else{
         if(!InvMenuHandler::isRegistered()){
            InvMenuHandler::register($this);
         }
         $this->shopchest = new ShopChest($this);
      }
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
   
   public function getDiscord(): string{
      return $this->discord;
   }
   
   public function getLanguage(): Language{
      return $this->language;
   }
   
   public function getShopForm(): ShopForm{
      return $this->shopform;
   }
   
   public function getMoneyAPI(): Plugin{
      return $this->moneyapi;
   }
   
   public function getShopChest(): ShopChest{
      return $this->shopchest;
   }
   
   public function getDatabase(): Database{
      return $this->database;
   }
   
   public function getPluginInfo(): string{
      $author = implode(", ", $this->getDescription()->getAuthors());
      $arrayText = [
         $this->getPrefix()." ".$this->getLanguage()->getTranslate("plugininfo.name", [$this->getDescription()->getName()]),
         $this->getPrefix()." ".$this->getLanguage()->getTranslate("plugininfo.version", [$this->getDescription()->getVersion()]),
         $this->getPrefix()." ".$this->getLanguage()->getTranslate("plugininfo.author", [$author]),
         $this->getPrefix()." ".$this->getLanguage()->getTranslate("plugininfo.description"),
         $this->getPrefix()." ".$this->getLanguage()->getTranslate("plugininfo.facebook", [$this->getFacebook()]),
         $this->getPrefix()." ".$this->getLanguage()->getTranslate("plugininfo.youtube", [$this->getYoutube()]),
         $this->getPrefix()." ".$this->getLanguage()->getTranslate("plugininfo.website", [$this->getDescription()->getWebsite()]),
         $this->getPrefix()." ".$this->getLanguage()->getTranslate("plugininfo.discord", [$this->getDiscord()]),
      ];
      return implode("\n", $arrayText);
   }
   
   public function getCategory(): array{
      return $this->getDatabase()->getCategory();
   }
   
   public function getCountCategory(): int{
      return $this->getDatabase()->getCountCategory();
   }
   
   public function isCategory(string $category): bool{
      return $this->getDatabase()->isCategory($category);
   }
   
   public function createCategory(string $category, string $name, string $itemicon): void{
      $this->getDatabase()->createCategory($category, $name, $itemicon);
   }
   
   public function removeCategory(string $category): void{
      $this->getDatabase()->removeCategory($category);
   }
   
   public function getCategoryName(string $category): string{
      return $this->getDatabase()->getCategoryName($category);
   }
   
   public function setCategoryName(string $category, string $nameNew): void{
      $this->getDatabase()->setCategoryName($category, $nameNew);
   }
   
   public function getCategoryIcon(string $category): string{
      return $this->getDatabase()->getCategoryIcon($category);
   }
   
   public function setCategoryIcon(string $category, string $itemiconNew): void{
      $this->getDatabase()->setCategoryIcon($category, $itemiconNew);
   }
   
   public function getItems(string $category): array{
      return $this->getDatabase()->getItems($category);
   }
   
   public function getCountItems(string $category): int{
      return $this->getDatabase()->getCountItems($category);
   }
   
   public function isItem(string $category, string $itemicon): bool{
      return $this->getDatabase()->isItem($category, $itemicon);
   }
   
   public function addItem(string $category, string $itemicon, int $buyPrice, int $sellPrice): void{
      $this->getDatabase()->addItem($category, $itemicon, $buyPrice, $sellPrice);
   }
   
   public function removeItem(string $category, string $itemicon): void{
      $this->getDatabase()->removeItem($category, $itemicon);
   }
   
   public function getBuyPrice(string $category, string $itemicon): int{
      return $this->getDatabase()->getBuyPrice($category, $itemicon);
   }
   
   public function getSellPrice(string $category, string $itemicon): int{
      return $this->getDatabase()->getSellPrice($category, $itemicon);
   }

}