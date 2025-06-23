import './component';
import './preview';

/**
 * @private
 * @package content
 */
Shopware.Service('cmsService').registerCmsBlock({
    name: 'shoppable-image',
    label: 'sw-cms.blocks.custom.shoppableImage.label', // Użyjemy tłumaczeń, które już masz
    category: 'custom', // Kategoria, w której blok pojawi się w edytorze
    component: 'sw-cms-block-shoppable-image',
    previewComponent: 'sw-cms-preview-shoppable-image',
    defaultConfig: {
        marginBottom: '20px',
        marginTop: '20px',
        marginLeft: '20px',
        marginRight: '20px',
        sizingMode: 'full_width',
    },
    // To jest kluczowy fragment: definiujemy, że nasz blok ma jeden "slot" (miejsce)
    // i domyślnie w tym slocie umieszczany jest nasz element 'shoppable-image'
    slots: {
        content: {
            type: 'shoppable-image',
        },
    },
});