<?php

namespace hmmhmmmm\shop\data;

use hmmhmmmm\shop\Shop;

use pocketmine\utils\Config;

class Language{
   private $plugin = null;
   private $data = null;
   private $lang = "?";
   
   private $langEnglish = [
      "reset" => false,
      "notfound.plugin" => "§cThis plugin will not work. Please install the plugin %s",
      "notfound.libraries" => "§cLibraries %s not found",
      "plugininfo.name" => "§fName plugin %s",
      "plugininfo.version" => "§fVersion %s",
      "plugininfo.author" => "§fList of creators %s",
      "plugininfo.description" => "§fDescription of the plugin. §eis a plugin free. Please do not sell. If you redistribute it, please credit the creator. :)",
      "plugininfo.facebook" => "§fFacebook %s",
      "plugininfo.youtube" => "§fYoutube %s",
      "plugininfo.website" => "§fWebsite %s",
      "plugininfo.discord" => "§fDiscord %s",
      "shop.command.consoleError" => "§cSorry: commands can be typed only in the game.",
      "shop.command.permissionError" => "§cSorry: You cannot type this command.",
      "shop.command.sendHelp.empty" => "§eYou can see more commands by typing /shop help",
      "shop.command.info.usage" => "/shop info",
      "shop.command.info.description" => "§fCredit of the plugin creator",
      "shop.command.category.usage" => "/shop category create|remove|additem|removeitem|icon|changename|list",
      "shop.command.category.error1" => "§cTry: %s",
      "shop.command.category.create.usage" => "/shop category create <NameTheCategory> <FullCategoryName> <ItemId> <ItemDamage>",
      "shop.command.category.create.description" => "§fCreate Category",
      "shop.command.category.create.error1" => "§cTry: %s",
      "shop.command.category.create.error2" => "§cCategory %s Already exists",
      "shop.command.category.create.error3" => "§cCannot add category more than 24 items",
      "shop.command.category.create.error4" => "§c<ItemId> Please write as numbers.",
      "shop.command.category.create.error5" => "§c<ItemDamage> Please write as numbers.",
      "shop.command.category.create.error6" => "§cCannot use item %s have",
      "shop.command.category.create.error7" => "§cItem %s Not in game",
      "shop.command.category.create.complete" => "You have created a category %s(%s) icon %s %s successfully",
      "shop.command.category.remove.usage" => "/shop category remove <NameCategory>",
      "shop.command.category.remove.description" => "§fRemove category",
      "shop.command.category.remove.error1" => "§cTry: %s",
      "shop.command.category.remove.error2" => "§cNot found category %s",
      "shop.command.category.remove.complete" => "You have deleted category %s successfully",
      "shop.command.category.additem.usage" => "/shop category additem <NameCategory> <BuyPrice> <SellPrice> <ItemId> <ItemDamage>",
      "shop.command.category.additem.description" => "§fAdd items to category",
      "shop.command.category.additem.error1" => "§cTry: %s",
      "shop.command.category.additem.error2" => "§cNot found category %s",
      "shop.command.category.additem.error3" => "§cCannot add more than 24 items in the category.",
      "shop.command.category.additem.error4" => "§c<BuyPrice> Please write as numbers.",
      "shop.command.category.additem.error5" => "§c<SellPrice> Please write as numbers.",
      "shop.command.category.additem.error6" => "§c<ItemId> Please write as numbers.",
      "shop.command.category.additem.error7" => "§c<ItemDamage> Please write as numbers.",
      "shop.command.category.additem.error8" => "§cCannot use item %s have",
      "shop.command.category.additem.error9" => "§cItem %s Not in game",
      "shop.command.category.additem.error10" => "§cCategory %s item %s %s Already exists",
      "shop.command.category.additem.complete" => "You have added items %s %s BuyPrice %s SellPrice %s in category %s successfully",
      "shop.command.category.removeitem.usage" => "/shop category removeitem <NameCategory> <ItemId> <ItemDamage>",
      "shop.command.category.removeitem.description" => "§fDelete items in category",
      "shop.command.category.removeitem.error1" => "§cTry: %s",
      "shop.command.category.removeitem.error2" => "§cNot found category %s",
      "shop.command.category.removeitem.error3" => "§c<ItemId> Please write as numbers.",
      "shop.command.category.removeitem.error4" => "§c<ItemDamage> Please write as numbers.",
      "shop.command.category.removeitem.error5" => "§cItem not found %s in category %s",
      "shop.command.category.removeitem.complete" => "You have deleted the item %s in category %s successfully",
 
      "shop.command.category.icon.usage" => "/shop category icon <NameCategory> <ItemId> <ItemDamage>",
      "shop.command.category.icon.description" => "§fChange icon in category",
      "shop.command.category.icon.error1" => "§cTry: %s",
      "shop.command.category.icon.error2" => "§cNot found category %s",
      "shop.command.category.icon.error3" => "§c<ItemId> Please write as numbers.",
      "shop.command.category.icon.error4" => "§c<ItemDamage> Please write as numbers.",
      "shop.command.category.icon.error5" => "§cCannot use item %s have",
      "shop.command.category.icon.error6" => "§cItem %s Not in the game",
      "shop.command.category.icon.complete" => "You changed the icon to %s %s in category %s successfully",
      "shop.command.category.changename.usage" => "/shop category changename <NameCategory> <FullNameOfCategory>",
      "shop.command.category.changename.description" => "§fChange the full name of category",
      "shop.command.category.changename.error1" => "§cTry: %s",
      "shop.command.category.changename.error2" => "§cNot found category %s",
      "shop.command.category.changename.complete" => "You have changed full name to %s in category %s successfully",
      "shop.command.category.list.usage" => "/shop category list",
      "shop.command.category.list.description" => "§fSee all list of categories",
      "shop.command.category.list.error1" => "§cNo category",
      "shop.command.category.list.complete" => "Name of all categories %s",
      "chestmenu.exit" => "§cExit",
      "chestmenu.back" => "§eBack",
      "chestmenu.senditem.lore" => "Buy at the price %s Per piece\nSell ​​at a price %s Per piece",
      "form.shopui.label" => "Item §d%s %s\n§fBuy at the price §a%s §fPer piece\nSell ​​at a price §6%s §fPer piece",
      "form.shopui.stepslider.title" => "§fYou want",
      "form.shopui.stepslider.step1" => "§aBuy",
      "form.shopui.stepslider.step2" => "§6Sell",
      "form.shopui.slider.title" => "§fAmount",
      "form.shopbuyconfirm.error1" => "§cYour money is not enough",
      "form.shopbuyconfirm.complete" => "You have bought %s amount %s in price %s successfully",
      "form.shopbuyconfirm.content" => "§fYou want to buy §b%s\n§fAmount §e%s §fin price §6%s §fOr not?",
      "form.shopbuyconfirm.button1" => "§aBuy",
      "form.shopbuyconfirm.button2" => "§cNo",
      "form.shopsellconfirm.error1" => "§cNot enough items to sell your",
      "form.shopsellconfirm.complete" => "You have sold %s amount %s in price %s successfully",
      "form.shopsellconfirm.content" => "§fYou want to sell §b%s\n§fAmount §e%s §fin price §6%s §fOr not?",
      "form.shopsellconfirm.button1" => "§6Sell",
      "form.shopsellconfirm.button2" => "§cNo"
   ];
   
   private $langThai = [
      "reset" => false,
      "notfound.plugin" => "§cปลั๊กนี้จะไม่ทำงาน กรุณาลงปลั๊กอิน %s",
      "notfound.libraries" => "§cไม่พบไลบรารี %s",
      "plugininfo.name" => "§fปลั๊กอินชื่อ %s",
      "plugininfo.version" => "§fเวอร์ชั่น %s",
      "plugininfo.author" => "§fรายชื่อผู้สร้าง %s",
      "plugininfo.description" => "§fคำอธิบายของปลั๊กอิน §eเป็นปลั๊กอินทำแจกกรุณาอย่าเอาไปขาย ถ้าจะแจกต่อโปรดให้เครดิตผู้สร้างด้วย :)",
      "plugininfo.facebook" => "§fเฟสบุ๊ค %s",
      "plugininfo.youtube" => "§fยูทูป %s",
      "plugininfo.website" => "§fเว็บไซต์ %s",
      "plugininfo.discord" => "§fดิสคอร์ด %s",
      "shop.command.consoleError" => "§cขออภัย: คำสั่งสามารถพิมพ์ได้เฉพาะในเกมส์",
      "shop.command.permissionError" => "§cขออภัย: คุณไม่สามารถพิมพ์คำสั่งนี้ได้",
      "shop.command.sendHelp.empty" => "§eคุณสามารถดูคำสั่งเพิ่มเติมได้โดยพิมพ์ /shop help",
      "shop.command.info.usage" => "/shop info",
      "shop.command.info.description" => "§fเครดิตผู้สร้างปลั๊กอิน",
      "shop.command.category.usage" => "/shop category create|remove|additem|removeitem|icon|changename|list",
      "shop.command.category.error1" => "§cลอง: %s",
      "shop.command.category.create.usage" => "/shop category create <ตั้งชื่อรายการ> <ชื่อเต็มของรายการ> <ไอเทมId> <ไอเทมDamage>",
      "shop.command.category.create.description" => "§fสร้างรายการ",
      "shop.command.category.create.error1" => "§cลอง: %s",
      "shop.command.category.create.error2" => "§cรายการ %s มีอยู่แล้ว",
      "shop.command.category.create.error3" => "§cไม่สามารถเพิ่มรายการได้เกิน 24 รายการ",
      "shop.command.category.create.error4" => "§c<ไอเทมId> กรุณาเขียนให้เป็นตัวเลข",
      "shop.command.category.create.error5" => "§c<ไอเทมDamage> กรุณาเขียนให้เป็นตัวเลข",
      "shop.command.category.create.error6" => "§cไม่สามารถใช้ไอเทม %s ได้",
      "shop.command.category.create.error7" => "§cไอเทม %s ไม่ได้อยู่ในเกมส์",
      "shop.command.category.create.complete" => "คุณได้สร้างรายการ %s(%s) icon %s %s เรียบร้อย!",
      "shop.command.category.remove.usage" => "/shop category remove <ชื่อรายการ>",
      "shop.command.category.remove.description" => "§fลบรายการ",
      "shop.command.category.remove.error1" => "§cลอง: %s",
      "shop.command.category.remove.error2" => "§cไม่พบรายการ %s",
      "shop.command.category.remove.complete" => "คุณได้ลบรายการ %s เรียบร้อย!",
      "shop.command.category.additem.usage" => "/shop category additem <ชื่อรายการ> <ราคาชื้อ> <ราคาขาย> <ไอเทมId> <ไอเทมDamage>",
      "shop.command.category.additem.description" => "§fเพิ่มไอเทมในรายการ",
      "shop.command.category.additem.error1" => "§cลอง: %s",
      "shop.command.category.additem.error2" => "§cไม่พบรายการ %s",
      "shop.command.category.additem.error3" => "§cไม่สามารถเพิ่มไอเทมในรายการได้เกิน 24 รายการ",
      "shop.command.category.additem.error4" => "§c<ราคาชื้อ> กรุณาเขียนให้เป็นตัวเลข",
      "shop.command.category.additem.error5" => "§c<ราคาขาย> กรุณาเขียนให้เป็นตัวเลข",
      "shop.command.category.additem.error6" => "§c<ไอเทมId> กรุณาเขียนให้เป็นตัวเลข",
      "shop.command.category.additem.error7" => "§c<ไอเทมDamage> กรุณาเขียนให้เป็นตัวเลข",
      "shop.command.category.additem.error8" => "§cไม่สามารถใช้ไอเทม %s ได้",
      "shop.command.category.additem.error9" => "§cไอเทม %s ไม่ได้อยู่ในเกมส์",
      "shop.command.category.additem.error10" => "§cรายการ %s ไอเทม %s %s มีอยู่แล้ว",
      "shop.command.category.additem.complete" => "คุณได้เพิ่มไอเทม %s %s ราคาชื้อ %s ราคาขาย %s ในรายการ %s เรียบร้อย!",
      "shop.command.category.removeitem.usage" => "/shop category removeitem <ชื่อรายการ> <ไอเทมId> <ไอเทมDamage>",
      "shop.command.category.removeitem.description" => "§fลบไอเทมในรายการ",
      "shop.command.category.removeitem.error1" => "§cลอง: %s",
      "shop.command.category.removeitem.error2" => "§cไม่พบรายการ %s",
      "shop.command.category.removeitem.error3" => "§c<ไอเทมId> กรุณาเขียนให้เป็นตัวเลข",
      "shop.command.category.removeitem.error4" => "§c<ไอเทมDamage> กรุณาเขียนให้เป็นตัวเลข",
      "shop.command.category.removeitem.error5" => "§cไม่พบไอเทม %s ในรายการ %s",
      "shop.command.category.removeitem.complete" => "คุณได้ลบไอเทม %s ในรายการ %s เรียบร้อย!",
 
      "shop.command.category.icon.usage" => "/shop category icon <ชื่อรายการ> <ไอเทมId> <ไอเทมDamage>",
      "shop.command.category.icon.description" => "§fเปลี่ยนiconในรายการ",
      "shop.command.category.icon.error1" => "§cลอง: %s",
      "shop.command.category.icon.error2" => "§cไม่พบรายการ %s",
      "shop.command.category.icon.error3" => "§c<ไอเทมId> กรุณาเขียนให้เป็นตัวเลข",
      "shop.command.category.icon.error4" => "§c<ไอเทมDamage> กรุณาเขียนให้เป็นตัวเลข",
      "shop.command.category.icon.error5" => "§cไม่สามารถใช้ไอเทม %s ได้",
      "shop.command.category.icon.error6" => "§cไอเทม %s ไม่ได้อยู่ในเกมส์",
      "shop.command.category.icon.complete" => "คุณได้เปลี่ยน icon เป็น %s %s ในรายการ %s เรียบร้อย!",
      "shop.command.category.changename.usage" => "/shop category changename <ชื่อรายการ> <ชื่อเต็มของรายการ>",
      "shop.command.category.changename.description" => "§fเปลี่ยนชื่อเต็มของรายการ",
      "shop.command.category.changename.error1" => "§cลอง: %s",
      "shop.command.category.changename.error2" => "§cไม่พบรายการ %s",
      "shop.command.category.changename.complete" => "คุณได้เปลี่ยนชื่อเต็มเป็น %s ในรายการ %s เรียบร้อย!",
      "shop.command.category.list.usage" => "/shop category list",
      "shop.command.category.list.description" => "§fดูรายชื่อรายการทั้งหมด",
      "shop.command.category.list.error1" => "§cไม่มีรายการ",
      "shop.command.category.list.complete" => "ชื่อรายการทั้งหมด %s",
      "chestmenu.exit" => "§cออก",
      "chestmenu.back" => "§eกลับ",
      "chestmenu.senditem.lore" => "ชื้อในราคา %s ต่อชิ้น\nขายในราคา %s ต่อชิ้น",
      "form.shopui.label" => "ไอเทม §d%s %s\n§fชื้อในราคา §a%s §fต่อชิ้น\nขายในราคา §6%s §fต่อชิ้น",
      "form.shopui.stepslider.title" => "§fคุณต้องการ",
      "form.shopui.stepslider.step1" => "§aชื้อ",
      "form.shopui.stepslider.step2" => "§6ขาย",
      "form.shopui.slider.title" => "§fจำนวน",
      "form.shopbuyconfirm.error1" => "§cเงินของคุณไม่เพียงพอ",
      "form.shopbuyconfirm.complete" => "คุณได้ชื้อ %s จำนวน %s ในราคา %s เรียบร้อย!",
      "form.shopbuyconfirm.content" => "§fคุณต้องการชื้อ §b%s\n§fจำนวน §e%s §fในราคา §6%s §fหรือไม่?",
      "form.shopbuyconfirm.button1" => "§aชื้อ",
      "form.shopbuyconfirm.button2" => "§cไม่",
      "form.shopsellconfirm.error1" => "§cไอเทมที่จะขายของคุณไม่เพียงพอ",
      "form.shopsellconfirm.complete" => "คุณได้ขาย %s จำนวน %s ในราคา %s เรียบร้อย!",
      "form.shopsellconfirm.content" => "§fคุณต้องการขาย §b%s\n§fจำนวน §e%s §fในราคา §6%s §fหรือไม่?",
      "form.shopsellconfirm.button1" => "§6ขาย",
      "form.shopsellconfirm.button2" => "§cไม่"
   ];
   

   public function __construct(Shop $plugin, string $lang){
      $this->plugin = $plugin;
      $this->lang = $lang;
      $this->data = new Config($this->plugin->getDataFolder()."language/$this->lang.yml", Config::YAML, array());
      $d = $this->data->getAll();
      if(!isset($d["reset"])){
         $this->reset();
      }else{
         if($d["reset"]){
            $this->reset();
         }
      }
      $this->update();
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
   public function update(): void{
      $data = $this->getData()->getAll();
      if(!isset($data["notfound"]["libraries"])){
         if($this->getLang() == "thai"){
            $data["notfound"]["libraries"] = $this->langThai["notfound.libraries"];
         }
         if($this->getLang() == "english"){
            $data["notfound"]["libraries"] = $this->langEnglish["notfound.libraries"];
         }
         $this->getData()->setAll($data);
         $this->getData()->save();
      }
   }
   public function getTranslate(string $key, array $arrayValue = []): string{
      $data = $this->getData();
      
      if(!empty($arrayValue)){
         return vsprintf($data->getNested($key), $arrayValue);
      }
      return $data->getNested($key);
   }
}