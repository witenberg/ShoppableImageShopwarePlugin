import template from './sw-cms-el-shoppable-image.html.twig';
import './sw-cms-el-shoppable-image.scss';

const { Component } = Shopware;

Component.register('sw-cms-el-shoppable-image', {
    template,

    mixins: [
        'cms-element'
    ],

    inject: ['repositoryFactory'],

    props: {
        element: {
            type: Object,
            required: true
        }
    },

    data() {
        return {
            // ...
        };
    },

    computed: {
        mediaRepository() {
            return this.repositoryFactory.create('media');
        },
        // Obiekt CSS dla kontenera obrazu
        mediaWrapperStyles() {
            return {
                'min-height': this.element.config.minHeight?.value || '200px',
            };
        },

        // Obiekt CSS dla samego obrazu
        mediaStyles() {
            return {
                'background-image': this.element.data.media?.url ? `url("${this.element.data.media.url}")` : 'none',
                'background-size': this.element.config.backgroundSize?.value || 'cover',
            };
        },

        // Zwraca hotspoty, tylko jeśli mamy obraz tła
        hotspots() {
            if (!this.element.data.media?.url) {
                return [];
            }
            return this.element.config.hotspots?.value || [];
        }
    },

    watch: {
        'element.config.media.value': {
            handler(mediaId) {
                if (!mediaId) {
                    this.element.data.media = null;
                    return;
                }
                this.updateMediaItem(mediaId);
            },
            immediate: true
        }
    },

    created() {
        this.initElementConfig('shoppable-image');
        this.initElementData('shoppable-image');
    },

    methods: {
        async updateMediaItem(mediaId) {
            if (!mediaId) return;
            try {
                const media = await this.mediaRepository.get(mediaId, Shopware.Context.api);
                this.element.data.media = media;
            } catch (e) {
                this.element.data.media = null;
            }
        },

        getHotspotPosition(hotspot) {
            return {
                top: `${hotspot.positionY}%`,
                left: `${hotspot.positionX}%`
            };
        }
    }
});