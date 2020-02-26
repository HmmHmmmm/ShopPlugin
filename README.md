## ShopPlugin


[Language English](#english)

[Language Thai](#thai)


download ShopPlugin.phar dev https://poggit.pmmp.io/ci/HmmHmmmm/ShopPlugin/ShopPlugin


# English

```diff
You must install the plugin
- EconomyAPI
this plugin will work
```

Download the plugin EconomyAPI [Click here](https://poggit.pmmp.io/p/economyapi)


**Features of plugin**<br>
- Is a plugin to create a shop to buy and sell
- You can add/delete item
- Can choose the amount of item According to the price per piece
- have gui chest
- have gui form
- Have language thai, english (You can edit the language you don't like at, /resources/language)


**How to use**<br>
- Sample clip [click](https://youtu.be/Rd7uGpD1tIU)


**Command**<br>
- /shop : open gui chest
- /shop category create <NameTheCategory> <FullCategoryName> <ItemId> <ItemDamage> : Create Category
- /shop category remove <NameCategory> : Remove category
- /shop category additem <NameCategory> <BuyPrice> <SellPrice> <ItemId> <ItemDamage> : Add items to category
- /shop category removeitem <NameCategory> <ItemId> <ItemDamage> : Delete items in category
- /shop category icon <NameCategory> <ItemId> <ItemDamage> : Change icon in category
- /shop category changename <NameCategory> <FullNameOfCategory> : Change the full name of category
- /shop category list : See all list of categories


**Images**<br>
![1](https://github.com/HmmHmmmm/ShopPlugin/blob/master/images/2.0/1en.jpg)

![2](https://github.com/HmmHmmmm/ShopPlugin/blob/master/images/2.0/2en.jpg)

![3](https://github.com/HmmHmmmm/ShopPlugin/blob/master/images/2.0/3en.jpg)

![4](https://github.com/HmmHmmmm/ShopPlugin/blob/master/images/2.0/4en.jpg)

![5](https://github.com/HmmHmmmm/ShopPlugin/blob/master/images/2.0/5en.jpg)


# Thai

```diff
คุณต้องลงปลั๊กอิน
- EconomyAPI
ถึงปลั๊กอินนี้จะทำงาน
```

ดาวโหลดปลั๊กอิน EconomyAPI [Click here](https://poggit.pmmp.io/p/economyapi)


**คุณสมบัติของปลั๊กอิน**<br>
- เป็นปลั๊กอินสร้างร้านค้าชื้อและขาย
- คุณสามารถ เพิ่ม/ลบ สินค้าได้
- สามารถเลือกจำนวนสินค้าตามราคาที่ตั้งต่อชิ้นไว้ได้
- มี gui chest
- มี gui form
- มีภาษา thai english (สามารถแก้ไขภาษาที่คุณไม่ชอบได้ที่ /resources/language)


**วิธีใช้งาน**<br>
- คลิปตัวอย่าง [คลิก](https://youtu.be/Rd7uGpD1tIU)


**Command**<br>
- /shop : เปิด gui chest
- /shop category create <ตั้งชื่อรายการ> <ชื่อเต็มของรายการ> <ไอเทมId> <ไอเทมDamage> : สร้างรายการ
- /shop category remove <ชื่อรายการ> : ลบรายการ
- /shop category additem <ชื่อรายการ> <ราคาชื้อ> <ราคาขาย> <ไอเทมId> <ไอเทมDamage> : เพิ่มไอเทมในรายการ
- /shop category removeitem <ชื่อรายการ> <ไอเทมId> <ไอเทมDamage> : ลบไอเทมในรายการ
- /shop category icon <ชื่อรายการ> <ไอเทมId> <ไอเทมDamage> : เปลี่ยนiconในรายการ
- /shop category changename <ชื่อรายการ> <ชื่อเต็มของรายการ> : เปลี่ยนชื่อเต็มในรายการ
- /shop category list : ดูรายการทั้งหมด


**Images**<br>
![1](https://github.com/HmmHmmmm/ShopPlugin/blob/master/images/2.0/1th.jpg)

![2](https://github.com/HmmHmmmm/ShopPlugin/blob/master/images/2.0/2th.jpg)

![3](https://github.com/HmmHmmmm/ShopPlugin/blob/master/images/2.0/3th.jpg)

![4](https://github.com/HmmHmmmm/ShopPlugin/blob/master/images/2.0/4th.jpg)

![5](https://github.com/HmmHmmmm/ShopPlugin/blob/master/images/2.0/5th.jpg)


# Config
```
#Language
#thai=ภาษาไทย
#english=English language
language: english
```
  

# Permissions
```
permissions:
  shop:
    default: false
    children:
      shop.command:
        default: false
        children:
          shop.command.info:
            default: op
          shop.command.category:
            default: false
            children:
              shop.command.category.create:
                default: op
              shop.command.category.remove:
                default: op
              shop.command.category.additem:
                default: op
              shop.command.category.removeitem:
                default: op
              shop.command.category.icon:
                default: op
              shop.command.category.changename:
                default: op
              shop.command.category.list:
                default: op
```


