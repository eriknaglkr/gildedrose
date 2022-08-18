<?php

declare(strict_types=1);

namespace GildedRose;

final class GildedRose
{
    /**
     * @var Item[]
     */
    private $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            if (! $this->shouldUpdateItem($item)) {
                continue;
            }

            $item->sell_in = $item->sell_in - 1;
            $modifier = $this->getQualityModifier($item);
            $item->quality = min(50, max(0, $item->quality + $modifier));
        }
    }

    private function shouldUpdateItem(Item $item): bool
    {
        return $item->name !== 'Sulfuras, Hand of Ragnaros';
    }

    private function getQualityModifier(Item $item): int
    {
        switch ($item->name) {
            case 'Aged Brie':
                $modifier = $item->sell_in >= 0 ? 1 : 2;
                break;
            case 'Backstage passes to a TAFKAL80ETC concert':
                $modifier = $this->getBackstagePassesModifier($item);
                break;
            case 'Conjured Mana Cake':
                $modifier = $item->sell_in >= 0 ? -2 : -4;
                break;
            default:
                $modifier = $item->sell_in >= 0 ? -1 : -2;
                break;
        }
        return $modifier;
    }

    private function getBackstagePassesModifier(Item $item): int
    {
        $modifier = 1;
        if ($item->sell_in < 0) {
            $modifier = 0 - $item->quality;
        } elseif ($item->sell_in < 5) {
            $modifier = 3;
        } elseif ($item->sell_in < 10) {
            $modifier = 2;
        }
        return $modifier;
    }
}
