<?php

namespace hmmhmmmm\shop\database;

use hmmhmmmm\shop\Shop;

use pocketmine\utils\Config;

class YML implements Database{
   private $plugin;
   private $data;
   private $name;
   
   public function __construct(Shop $plugin, string $name){
      $this->plugin = $plugin;
      $this->name = $name;
      $this->data = new Config($this->plugin->getDataFolder()."shop.yml", Config::YAML, array());
      $this->plugin->getLogger()->info("You have chosen database ".$this->name);
   }
   
   public function getName(): string{
      return $this->name;
   }
   
   public function getData(): Config{
      return $this->data;
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