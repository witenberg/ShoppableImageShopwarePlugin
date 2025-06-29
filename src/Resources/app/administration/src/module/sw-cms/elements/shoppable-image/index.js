import './component';
import './config';
import './preview';

Shopware.Service('cmsService').registerCmsElement({
    name: 'shoppable-image',
    label: 'Shoppable Image Element',
    component: 'sw-cms-el-shoppable-image',
    configComponent: 'sw-cms-el-config-shoppable-image',
    previewComponent: 'sw-cms-el-preview-shoppable-image',
    defaultConfig: {
        media: {
            source: 'static',
            value: null,
            required: true,
            entity: {
                name: 'media'
            }
        },
        hotspots: {
            source: 'static',
            value: [] // Tutaj będziemy przechowywać tablicę obiektów hotspot
        },
        roomCategory: {
            source: 'static',
            value: 'all'
        },
        minHeight: {
            source: 'static',
            value: '340px', // Ustawiamy rozsądną domyślną wartość
        },
    }
});