<?php

namespace hmmhmmmm\shop\database;

use hmmhmmmm\shop\Shop;

interface Database{

   public function __construct(Shop $plugin, string $name);
  
   public function getName(): string;
}