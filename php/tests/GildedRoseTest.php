<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Item;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    public function testFoo(): void
    {
        $items = [new Item('foo', 0, 0)];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame('foo', $items[0]->name);
    }

    public function testNormalItemUpdate(): void
    {
        $item = new Item('+5 Dexterity Vest', 10, 20);
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        $this->assertSame(9, $item->sell_in);
        $this->assertSame(19, $item->quality);
    }

    public function testNormalItemExpired(): void
    {
        $item = new Item('+5 Dexterity Vest', 0, 20);
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        $this->assertSame(-1, $item->sell_in);
        $this->assertSame(18, $item->quality);
    }

    public function testNormalItemNoQuality(): void
    {
        $item = new Item('+5 Dexterity Vest', 0, 0);
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        $this->assertSame(-1, $item->sell_in);
        $this->assertSame(0, $item->quality);
    }

    public function testAgedBrieUpdate(): void
    {
        $item = new Item('Aged Brie', 2, 0);
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        $this->assertSame(1, $item->sell_in);
        $this->assertSame(1, $item->quality);
    }

    public function testAgedBrieExpired(): void
    {
        $item = new Item('Aged Brie', 0, 0);
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        $this->assertSame(-1, $item->sell_in);
        $this->assertSame(2, $item->quality);
    }

    public function testAgedBrieMaxExpired(): void
    {
        $item = new Item('Aged Brie', 0, 49);
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        $this->assertSame(-1, $item->sell_in);
        $this->assertSame(50, $item->quality);
    }

    public function testSulfurasUpdate(): void
    {
        $item = new Item('Sulfuras, Hand of Ragnaros', 0, 80);
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        $this->assertSame(0, $item->sell_in);
        $this->assertSame(80, $item->quality);
    }

    public function testSulfurasExpired(): void
    {
        $item = new Item('Sulfuras, Hand of Ragnaros', -1, 80);
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        $this->assertSame(-1, $item->sell_in);
        $this->assertSame(80, $item->quality);
    }

    public function testBackstagePassUpdate(): void
    {
        $item = new Item('Backstage passes to a TAFKAL80ETC concert', 20, 10);
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        $this->assertSame(19, $item->sell_in);
        $this->assertSame(11, $item->quality);
    }

    public function testBackstagePassUpdateMax(): void
    {
        $item = new Item('Backstage passes to a TAFKAL80ETC concert', 5, 49);
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        $this->assertSame(4, $item->sell_in);
        $this->assertSame(50, $item->quality);
    }

    public function testBackstagePassUpdateTenDays(): void
    {
        $item = new Item('Backstage passes to a TAFKAL80ETC concert', 10, 10);
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        $this->assertSame(9, $item->sell_in);
        $this->assertSame(12, $item->quality);
    }

    public function testBackstagePassUpdateFiveDays(): void
    {
        $item = new Item('Backstage passes to a TAFKAL80ETC concert', 5, 10);
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        $this->assertSame(4, $item->sell_in);
        $this->assertSame(13, $item->quality);
    }

    public function testBackstagePassUpdateExpired(): void
    {
        $item = new Item('Backstage passes to a TAFKAL80ETC concert', 0, 10);
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        $this->assertSame(-1, $item->sell_in);
        $this->assertSame(0, $item->quality);
    }

    public function testConjuredItemUpdate(): void
    {
        $item = new Item('Conjured Mana Cake', 3, 6);
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        $this->assertSame(2, $item->sell_in);
        $this->assertSame(4, $item->quality);
    }

    public function testConjuredItemExpired(): void
    {
        $item = new Item('Conjured Mana Cake', 0, 6);
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        $this->assertSame(-1, $item->sell_in);
        $this->assertSame(2, $item->quality);
    }

    public function testConjuredItemMaxExpired(): void
    {
        $item = new Item('Conjured Mana Cake', 0, 0);
        $gildedRose = new GildedRose([$item]);
        $gildedRose->updateQuality();
        $this->assertSame(-1, $item->sell_in);
        $this->assertSame(0, $item->quality);
    }
}
