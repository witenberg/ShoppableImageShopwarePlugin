<?php declare(strict_types=1);

namespace ShoppableImage\Storefront\Resolver;

use Shopware\Core\Content\Cms\Aggregate\CmsSlot\CmsSlotEntity;
use Shopware\Core\Content\Cms\DataResolver\CriteriaCollection;
use Shopware\Core\Content\Cms\DataResolver\Element\ElementDataCollection;
use Shopware\Core\Content\Cms\DataResolver\ResolverContext\ResolverContext;
use Shopware\Core\Content\Cms\DataResolver\Element\AbstractCmsElementResolver;
use Shopware\Core\Content\Media\MediaDefinition;
use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\Struct\ArrayStruct;

class ShoppableImageCmsElementResolver extends AbstractCmsElementResolver
{
    public function getType(): string
    {
        return 'shoppable-image';
    }

    public function collect(CmsSlotEntity $slot, ResolverContext $resolverContext): ?CriteriaCollection
    {
        $config = $slot->getFieldConfig();
        $collection = new CriteriaCollection();

        // Używamy konsekwentnie nazwy 'media'
        $mediaConfig = $config->get('media');
        if ($mediaConfig && $mediaConfig->getValue()) {
            $criteria = new Criteria([$mediaConfig->getValue()]);
            $collection->add('shoppable_image_media_' . $slot->getUniqueIdentifier(), MediaDefinition::class, $criteria);
        }

        $hotspotsConfig = $config->get('hotspots');
        if ($hotspotsConfig && is_array($hotspotsConfig->getValue())) {
            $productIds = array_column($hotspotsConfig->getValue(), 'productId');
            $productIds = array_filter($productIds);

            if (!empty($productIds)) {
                $criteria = new Criteria($productIds);
                $criteria->addAssociation('cover.media');
                $collection->add('shoppable_image_products_' . $slot->getUniqueIdentifier(), ProductDefinition::class, $criteria);
            }
        }

        return $collection;
    }

    public function enrich(CmsSlotEntity $slot, ResolverContext $resolverContext, ElementDataCollection $result): void
    {
        $data = new ArrayStruct();
        
        // Używamy konsekwentnie nazwy 'media'
        $mediaResult = $result->get('shoppable_image_media_' . $slot->getUniqueIdentifier());
        if ($mediaResult && $mediaEntity = $mediaResult->first()) {
            $data->set('media', $mediaEntity);
        }

        $enrichedHotspots = [];
        $hotspotsConfig = $slot->getFieldConfig()->get('hotspots');
        $productsResult = $result->get('shoppable_image_products_' . $slot->getUniqueIdentifier());

        if ($hotspotsConfig && is_array($hotspotsConfig->getValue()) && $productsResult) {
            foreach ($hotspotsConfig->getValue() as $hotspot) {
                if (isset($hotspot['productId']) && $product = $productsResult->get($hotspot['productId'])) {
                    $hotspot['product'] = $product;
                    $enrichedHotspots[] = $hotspot;
                }
            }
        }
        $data->set('hotspots', $enrichedHotspots);
        
        $slot->setData($data);
    }
}