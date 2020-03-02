<?php

namespace hmmhmmmm\shop\data;

use hmmhmmmm\shop\Shop;

use pocketmine\utils\Config;

class Language{
   private $plugin = null;
   private $data = null;
   private $lang = "?";
   private $version = null;
   
   private $langEnglish = [
      "reset" => false,
      "version" => 1,
      "notfound.plugin" => "§cThis plugin will not work, Please install the plugin %1",
      "notfound.libraries" => "§cLibraries %1 not found, Please download this plugin to as .phar",
      "plugininfo.name" => "§fName plugin %1",
      "plugininfo.version" => "§fVersion %1",
      "plugininfo.author" => "§fList of creators %1",
      "plugininfo.description" => "§fDescription of the plugin. §eis a plugin free. Please do not sell. If you redistribute it, please credit the creator. :)",
      "plugininfo.facebook" => "§fFacebook %1",
      "plugininfo.youtube" => "§fYoutube %1",
      "plugininfo.website" => "§fWebsite %1",
      "plugininfo.discord" => "§fDiscord %1",
      "shop.command.consoleError" => "§cSorry: commands can be typed only in the game.",
      "shop.command.permissionError" => "§cSorry: You cannot type this command.",
      "shop.command.sendHelp.empty" => "§eYou can see more commands by typing /shop help",
      "shop.command.info.usage" => "/shop info",
      "shop.command.info.description" => "§fCredit of the plugin creator",
      "shop.command.category.usage" => "/shop category create|remove|additem|removeitem|icon|changename|list",
      "shop.command.category.error1" => "§cTry: %1",
      "shop.command.category.create.usage" => "/shop category create <NameTheCategory> <FullCategoryName> <ItemId> <ItemDamage>",
      "shop.command.category.create.description" => "§fCreate Category",
      "shop.command.category.create.error1" => "§cTry: %1",
      "shop.command.category.create.error2" => "§cCategory %1 Already exists",
      "shop.command.category.create.error3" => "§cCannot add category more than 24 items",
      "shop.command.category.create.error4" => "§c<ItemId> Please write as numbers.",
      "shop.command.category.create.error5" => "§c<ItemDamage> Please write as numbers.",
      "shop.command.category.create.error6" => "§cCannot use item %1 have",
      "shop.command.category.create.error7" => "§cItem %1 Not in game",
      "shop.command.category.create.complete" => "You have created a category %1(%2) icon %3 %4 successfully",
      "shop.command.category.remove.usage" => "/shop category remove <NameCategory>",
      "shop.command.category.remove.description" => "§fRemove category",
      "shop.command.category.remove.error1" => "§cTry: %1",
      "shop.command.category.remove.error2" => "§cNot found category %1",
      "shop.command.category.remove.complete" => "You have deleted category %1 successfully",
      "shop.command.category.additem.usage" => "/shop category additem <NameCategory> <BuyPrice> <SellPrice> <ItemId> <ItemDamage>",
      "shop.command.category.additem.description" => "§fAdd items to category",
      "shop.command.category.additem.error1" => "§cTry: %1",
      "shop.command.category.additem.error2" => "§cNot found category %1",
      "shop.command.category.additem.error3" => "§cCannot add more than 24 items in the category.",
      "shop.command.category.additem.error4" => "§c<BuyPrice> Please write as numbers.",
      "shop.command.category.additem.error5" => "§c<SellPrice> Please write as numbers.",
      "shop.command.category.additem.error6" => "§c<ItemId> Please write as numbers.",
      "shop.command.category.additem.error7" => "§c<ItemDamage> Please write as numbers.",
      "shop.command.category.additem.error8" => "§cCannot use item %1 have",
      "shop.command.category.additem.error9" => "§cItem %1 Not in game",
      "shop.command.category.additem.error10" => "§cCategory %1 item %2 %3 Already exists",
      "shop.command.category.additem.complete" => "You have added items %1 %2 BuyPrice %3 SellPrice %4 in category %5 successfully",
      "shop.command.category.removeitem.usage" => "/shop category removeitem <NameCategory> <ItemId> <ItemDamage>",
      "shop.command.category.removeitem.description" => "§fDelete items in category",
      "shop.command.category.removeitem.error1" => "§cTry: %1",
      "shop.command.category.removeitem.error2" => "§cNot found category %1",
      "shop.command.category.removeitem.error3" => "§c<ItemId> Please write as numbers.",
      "shop.command.category.removeitem.error4" => "§c<ItemDamage> Please write as numbers.",
      "shop.command.category.removeitem.error5" => "§cItem not found %1 in category %2",
      "shop.command.category.removeitem.complete" => "You have deleted the item %1 in category %2 successfully",
 
      "shop.command.category.icon.usage" => "/shop category icon <NameCategory> <ItemId> <ItemDamage>",
      "shop.command.category.icon.description" => "§fChange icon in category",
      "shop.command.category.icon.error1" => "§cTry: %1",
      "shop.command.category.icon.error2" => "§cNot found category %1",
      "shop.command.category.icon.error3" => "§c<ItemId> Please write as numbers.",
      "shop.command.category.icon.error4" => "§c<ItemDamage> Please write as numbers.",
      "shop.command.category.icon.error5" => "§cCannot use item %1 have",
      "shop.command.category.icon.error6" => "§cItem %1 Not in the game",
      "shop.command.category.icon.complete" => "You changed the icon to %1 %2 in category %3 successfully",
      "shop.command.category.changename.usage" => "/shop category changename <NameCategory> <FullNameOfCategory>",
      "shop.command.category.changename.description" => "§fChange the full name of category",
      "shop.command.category.changename.error1" => "§cTry: %1",
      "shop.command.category.changename.error2" => "§cNot found category %1",
      "shop.command.category.changename.complete" => "You have changed full name to %1 in category %2 successfully",
      "shop.command.category.list.usage" => "/shop category list",
      "shop.command.category.list.description" => "§fSee all list of categories",
      "shop.command.category.list.error1" => "§cNo category",
      "shop.command.category.list.complete" => "Name of all categories %1",
      "chestmenu.exit" => "§cExit",
      "chestmenu.back" => "§eBack",
      "chestmenu.next" => "§aNext %1/%2",
      "chestmenu.senditem.lore" => "Buy at the price %1 Per piece\nSell ​​at a price %2 Per piece",
      "form.shopui.label" => "Item §d%1 %2\n§fBuy at the price §a%3 §fPer piece\nSell ​​at a price §6%4 §fPer piece",
      "form.shopui.stepslider.title" => "§fYou want",
      "form.shopui.stepslider.step1" => "§aBuy",
      "form.shopui.stepslider.step2" => "§6Sell",
      "form.shopui.slider.title" => "§fAmount",
      "form.shopbuyconfirm.error1" => "§cYour money is not enough",
      "form.shopbuyconfirm.complete" => "You have bought %1 amount %2 in price %3 successfully",
      "form.shopbuyconfirm.content" => "§fYou want to buy §b%1\n§fAmount §e%2 §fin price §6%3 §fOr not?",
      "form.shopbuyconfirm.button1" => "§aBuy",
      "form.shopbuyconfirm.button2" => "§cNo",
      "form.shopsellconfirm.error1" => "§cNot enough items to sell your",
      "form.shopsellconfirm.complete" => "You have sold %1 amount %2 in price %3 successfully",
      "form.shopsellconfirm.content" => "§fYou want to sell §b%1\n§fAmount §e%2 §fin price §6%3 §fOr not?",
      "form.shopsellconfirm.button1" => "§6Sell",
      "form.shopsellconfirm.button2" => "§cNo"
   ];
   
   
   private $langThai = [
      "reset" => false,
      "version" => 1,
      "notfound.plugin" => "§cปลั๊กนี้จะไม่ทำงาน กรุณาลงปลั๊กอิน %1",
      "notfound.libraries" => "§cไม่พบไลบรารี %1 กรุณาดาวน์โหลดปลั๊กอินนี้ให้เป็น .phar",
      "plugininfo.name" => "§fปลั๊กอินชื่อ %1",
      "plugininfo.version" => "§fเวอร์ชั่น %1",
      "plugininfo.author" => "§fรายชื่อผู้สร้าง %1",
      "plugininfo.description" => "§fคำอธิบายของปลั๊กอิน §eเป็นปลั๊กอินทำแจกกรุณาอย่าเอาไปขาย ถ้าจะแจกต่อโปรดให้เครดิตผู้สร้างด้วย :)",
      "plugininfo.facebook" => "§fเฟสบุ๊ค %1",
      "plugininfo.youtube" => "§fยูทูป %1",
      "plugininfo.website" => "§fเว็บไซต์ %1",
      "plugininfo.discord" => "§fดิสคอร์ด %1",
      "shop.command.consoleError" => "§cขออภัย: คำสั่งสามารถพิมพ์ได้เฉพาะในเกมส์",
      "shop.command.permissionError" => "§cขออภัย: คุณไม่สามารถพิมพ์คำสั่งนี้ได้",
      "shop.command.sendHelp.empty" => "§eคุณสามารถดูคำสั่งเพิ่มเติมได้โดยพิมพ์ /shop help",
      "shop.command.info.usage" => "/shop info",
      "shop.command.info.description" => "§fเครดิตผู้สร้างปลั๊กอิน",
      "shop.command.category.usage" => "/shop category create|remove|additem|removeitem|icon|changename|list",
      "shop.command.category.error1" => "§cลอง: %1",
      "shop.command.category.create.usage" => "/shop category create <ตั้งชื่อรายการ> <ชื่อเต็มของรายการ> <ไอเทมId> <ไอเทมDamage>",
      "shop.command.category.create.description" => "§fสร้างรายการ",
      "shop.command.category.create.error1" => "§cลอง: %1",
      "shop.command.category.create.error2" => "§cรายการ %1 มีอยู่แล้ว",
      "shop.command.category.create.error3" => "§cไม่สามารถเพิ่มรายการได้เกิน 24 รายการ",
      "shop.command.category.create.error4" => "§c<ไอเทมId> กรุณาเขียนให้เป็นตัวเลข",
      "shop.command.category.create.error5" => "§c<ไอเทมDamage> กรุณาเขียนให้เป็นตัวเลข",
      "shop.command.category.create.error6" => "§cไม่สามารถใช้ไอเทม %1 ได้",
      "shop.command.category.create.error7" => "§cไอเทม %1 ไม่ได้อยู่ในเกมส์",
      "shop.command.category.create.complete" => "คุณได้สร้างรายการ %1(%2) icon %3 %4 เรียบร้อย!",
      "shop.command.category.remove.usage" => "/shop category remove <ชื่อรายการ>",
      "shop.command.category.remove.description" => "§fลบรายการ",
      "shop.command.category.remove.error1" => "§cลอง: %1",
      "shop.command.category.remove.error2" => "§cไม่พบรายการ %1",
      "shop.command.category.remove.complete" => "คุณได้ลบรายการ %1 เรียบร้อย!",
      "shop.command.category.additem.usage" => "/shop category additem <ชื่อรายการ> <ราคาชื้อ> <ราคาขาย> <ไอเทมId> <ไอเทมDamage>",
      "shop.command.category.additem.description" => "§fเพิ่มไอเทมในรายการ",
      "shop.command.category.additem.error1" => "§cลอง: %1",
      "shop.command.category.additem.error2" => "§cไม่พบรายการ %1",
      "shop.command.category.additem.error3" => "§cไม่สามารถเพิ่มไอเทมในรายการได้เกิน 24 รายการ",
      "shop.command.category.additem.error4" => "§c<ราคาชื้อ> กรุณาเขียนให้เป็นตัวเลข",
      "shop.command.category.additem.error5" => "§c<ราคาขาย> กรุณาเขียนให้เป็นตัวเลข",
      "shop.command.category.additem.error6" => "§c<ไอเทมId> กรุณาเขียนให้เป็นตัวเลข",
      "shop.command.category.additem.error7" => "§c<ไอเทมDamage> กรุณาเขียนให้เป็นตัวเลข",
      "shop.command.category.additem.error8" => "§cไม่สามารถใช้ไอเทม %1 ได้",
      "shop.command.category.additem.error9" => "§cไอเทม %1 ไม่ได้อยู่ในเกมส์",
      "shop.command.category.additem.error10" => "§cรายการ %1 ไอเทม %2 %3 มีอยู่แล้ว",
      "shop.command.category.additem.complete" => "คุณได้เพิ่มไอเทม %1 %2 ราคาชื้อ %3 ราคาขาย %4 ในรายการ %5 เรียบร้อย!",
      "shop.command.category.removeitem.usage" => "/shop category removeitem <ชื่อรายการ> <ไอเทมId> <ไอเทมDamage>",
      "shop.command.category.removeitem.description" => "§fลบไอเทมในรายการ",
      "shop.command.category.removeitem.error1" => "§cลอง: %1",
      "shop.command.category.removeitem.error2" => "§cไม่พบรายการ %1",
      "shop.command.category.removeitem.error3" => "§c<ไอเทมId> กรุณาเขียนให้เป็นตัวเลข",
      "shop.command.category.removeitem.error4" => "§c<ไอเทมDamage> กรุณาเขียนให้เป็นตัวเลข",
      "shop.command.category.removeitem.error5" => "§cไม่พบไอเทม %1 ในรายการ %2",
      "shop.command.category.removeitem.complete" => "คุณได้ลบไอเทม %1 ในรายการ %2 เรียบร้อย!",
 
      "shop.command.category.icon.usage" => "/shop category icon <ชื่อรายการ> <ไอเทมId> <ไอเทมDamage>",
      "shop.command.category.icon.description" => "§fเปลี่ยนiconในรายการ",
      "shop.command.category.icon.error1" => "§cลอง: %1",
      "shop.command.category.icon.error2" => "§cไม่พบรายการ %1",
      "shop.command.category.icon.error3" => "§c<ไอเทมId> กรุณาเขียนให้เป็นตัวเลข",
      "shop.command.category.icon.error4" => "§c<ไอเทมDamage> กรุณาเขียนให้เป็นตัวเลข",
      "shop.command.category.icon.error5" => "§cไม่สามารถใช้ไอเทม %1 ได้",
      "shop.command.category.icon.error6" => "§cไอเทม %1 ไม่ได้อยู่ในเกมส์",
      "shop.command.category.icon.complete" => "คุณได้เปลี่ยน icon เป็น %1 %2 ในรายการ %3 เรียบร้อย!",
      "shop.command.category.changename.usage" => "/shop category changename <ชื่อรายการ> <ชื่อเต็มของรายการ>",
      "shop.command.category.changename.description" => "§fเปลี่ยนชื่อเต็มของรายการ",
      "shop.command.category.changename.error1" => "§cลอง: %1",
      "shop.command.category.changename.error2" => "§cไม่พบรายการ %1",
      "shop.command.category.changename.complete" => "คุณได้เปลี่ยนชื่อเต็มเป็น %1 ในรายการ %2 เรียบร้อย!",
      "shop.command.category.list.usage" => "/shop category list",
      "shop.command.category.list.description" => "§fดูรายชื่อรายการทั้งหมด",
      "shop.command.category.list.error1" => "§cไม่มีรายการ",
      "shop.command.category.list.complete" => "ชื่อรายการทั้งหมด %1",
      "chestmenu.exit" => "§cออก",
      "chestmenu.back" => "§eกลับ",
      "chestmenu.next" => "§aถัดไป %1/%2",
      "chestmenu.senditem.lore" => "ชื้อในราคา %1 ต่อชิ้น\nขายในราคา %2 ต่อชิ้น",
      "form.shopui.label" => "ไอเทม §d%1 %2\n§fชื้อในราคา §a%3 §fต่อชิ้น\nขายในราคา §6%4 §fต่อชิ้น",
      "form.shopui.stepslider.title" => "§fคุณต้องการ",
      "form.shopui.stepslider.step1" => "§aชื้อ",
      "form.shopui.stepslider.step2" => "§6ขาย",
      "form.shopui.slider.title" => "§fจำนวน",
      "form.shopbuyconfirm.error1" => "§cเงินของคุณไม่เพียงพอ",
      "form.shopbuyconfirm.complete" => "คุณได้ชื้อ %1 จำนวน %2 ในราคา %3 เรียบร้อย!",
      "form.shopbuyconfirm.content" => "§fคุณต้องการชื้อ §b%1\n§fจำนวน §e%2 §fในราคา §6%3 §fหรือไม่?",
      "form.shopbuyconfirm.button1" => "§aชื้อ",
      "form.shopbuyconfirm.button2" => "§cไม่",
      "form.shopsellconfirm.error1" => "§cไอเทมที่จะขายของคุณไม่เพียงพอ",
      "form.shopsellconfirm.complete" => "คุณได้ขาย %1 จำนวน %2 ในราคา %3 เรียบร้อย!",
      "form.shopsellconfirm.content" => "§fคุณต้องการขาย §b%1\n§fจำนวน §e%2 §fในราคา §6%3 §fหรือไม่?",
      "form.shopsellconfirm.button1" => "§6ขาย",
      "form.shopsellconfirm.button2" => "§cไม่"
   ];
   

   public function __construct(Shop $plugin, string $lang){
      $this->plugin = $plugin;
      $this->lang = $lang;
      $this->plugin->getLogger()->info("You have chosen language ".$this->getLang());
      $this->data = new Config($this->plugin->getDataFolder()."language/$this->lang.yml", Config::YAML, array());
      $d = $this->data->getAll();
      if(!isset($d["reset"])){
         $this->reset();
      }else{
         if($d["reset"]){
            $this->reset();
            $this->plugin->getLogger()->info("You have reset language ".$this->getLang());
         }
         if(isset($d["version"])){
            $this->version = $d["version"];
            if($this->getVersion() !== 1){
               $this->plugin->getLogger()->info("Language ".$this->getLang()." has been update as version ".$this->getVersion()." please reset language");
            }
         }else{
            $this->reset();
            $this->plugin->getLogger()->info("Language ".$this->getLang()." has been update as version ".$this->getVersion()." therefore language has been reset");
         }
      }
   }
   
   public function getPlugin(): Shop{
      return $this->plugin;
   }
   
   public function getData(): Config{
      return $this->data;
   }
   
   public function getLang(): string{
      return $this->lang;
   }
   
   public function getVersion(): int{
      return $this->version;
   }
   
   public function reset(): void{
      $data = $this->getData();
      if($this->getLang() == "thai"){
         foreach($this->langThai as $key => $value){
            $data->setNested($key, $value);
         }
      }
      if($this->getLang() == "english"){
         foreach($this->langEnglish as $key => $value){
            $data->setNested($key, $value);
         }
      }
      $data->save();
   }
   
   public function getTranslate(string $key, array $params = []): string{
      $data = $this->getData();
      if(!$data->exists($key)){
         $message = $data->getNested($key);
         for($i = 0; $i < count($params); $i++){
            $message = str_replace("%".($i + 1), $params[$i], $message);
         }
         return $message;
      }else{
         return "§cNot found message ".$key;
      }
   }
}