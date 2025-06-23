<?php declare(strict_types=1);

namespace ShoppableImage\Storefront\Resolver; // Upewnij się, że namespace jest poprawny

use Shopware\Core\Content\Cms\Aggregate\CmsSlot\CmsSlotEntity;
use Shopware\Core\Content\Cms\DataResolver\CriteriaCollection;
use Shopware\Core\Content\Cms\DataResolver\Element\ElementDataCollection;
use Shopware\Core\Content\Cms\DataResolver\ResolverContext\ResolverContext;
use Shopware\Core\Content\Cms\DataResolver\Block\AbstractCmsBlockResolver; // ZMIANA: dziedziczymy po AbstractCmsBlockResolver

/**
 * To jest resolver dla całego BLOKU. Jego zadaniem jest ustawienie
 * domyślnego layoutu (np. pełnej szerokości) dla sekcji, w której się znajduje.
 */
class ShoppableImageCmsBlockResolver extends AbstractCmsBlockResolver  
{
    public function getType(): string
    {
        // WAŻNE: Tutaj podaj techniczną nazwę swojego BLOKU CMS.
        // Prawdopodobnie będzie taka sama jak elementu, ale upewnij się.
        return 'shoppable-image';
    }

    /**
     * TO JEST PRAWIDŁOWE MIEJSCE NA TĘ KONFIGURACJĘ.
     * Ustawienia stąd zostaną zastosowane do SEKCJI, w której umieszczony jest ten blok.
     */
    public function getDefaultConfig(): array
    {
        return [
            'sizingMode' => 'full_width',
            'marginLeft' => '0px',
            'marginRight' => '0px',
            'marginTop' => '0px',
            'marginBottom' => '0px',
        ];
    }
    
    // Poniższe metody (collect, enrich) dla prostego bloku z jednym slotem
    // często mogą pozostać puste, ponieważ logikę danych obsługuje
    // dedykowany ElementResolver. Shopware automatycznie wywoła oba resolvery.
    // Zachowujemy je dla kompletności.

    public function collect(CmsSlotEntity $slot, ResolverContext $resolverContext): ?CriteriaCollection
    {
        return null;
    }

    public function enrich(CmsSlotEntity $slot, ResolverContext $resolverContext, ElementDataCollection $result): void
    {
        // Logika wzbogacania danych dla bloku, jeśli jest potrzebna.
        // W tym przypadku, cała praca jest wykonywana w ShoppableImageCmsElementResolver.
    }
}