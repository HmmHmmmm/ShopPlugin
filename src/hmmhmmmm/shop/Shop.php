<?php

namespace hmmhmmmm\shop;

use hmmhmmmm\shop\cmd\ShopCommand;
use hmmhmmmm\shop\data\Language;
use hmmhmmmm\shop\listener\EventListener;
use hmmhmmmm\shop\ui\ChestMenu;
use hmmhmmmm\shop\ui\Form;

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
   private $form = null;
   private $moneyapi = null;
   private $chestmenu = null;

   private $langClass = [
      "thai",
      "english"
   ];
   
   public function onEnable(){
      @mkdir($this->getDataFolder());
      @mkdir($this->getDataFolder()."language/");
      $this->data = new Config($this->getDataFolder()."shop.yml", Config::YAML, array());
      $this->saveDefaultConfig();
      $this->prefix = "Shop";
      $this->facebook = "https://bit.ly/39ULjqk";
      $this->youtube = "https://bit.ly/2HL1j28";
      $this->discord = "https://discord.gg/n6CmNr";
      $this->form = new Form($this);
      $this->chestmenu = new ChestMenu($this);
      $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
      $this->getServer()->getCommandMap()->register("ShopPlugin", new ShopCommand($this));
      $langConfig = $this->getConfig()->getNested("language");
      if(!in_array($langConfig, $this->langClass)){
         $this->getLogger()->error("§cNot found language ".$langConfig.", Please try ".implode(", ", $this->langClass));
         $this->getServer()->getPluginManager()->disablePlugin($this);
      }else{
         $this->language = new Language($this, $langConfig);
      }
      if($this->getServer()->getPluginManager()->getPlugin("EconomyAPI") === null){
         $this->getLogger()->critical($this->language->getTranslate("notfound.plugin", ["EconomyAPI"]));
         $this->getServer()->getPluginManager()->disablePlugin($this);
      }else{
         $this->moneyapi = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
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
   public function getData(): Config{
      return $this->data;
   }
   public function getForm(): Form{
      return $this->form;
   }
   public function getMoneyAPI(): Plugin{
      return $this->moneyapi;
   }
   public function getChestMenu(): ChestMenu{
      return $this->chestmenu;
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