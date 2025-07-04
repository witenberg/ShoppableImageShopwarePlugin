import template from './sw-cms-el-config-shoppable-image.html.twig';
import './sw-cms-el-config-shoppable-image.scss';

const { Component, Mixin, Utils } = Shopware;

Component.register('sw-cms-el-config-shoppable-image', {
    template,

    mixins: [
        'cms-element'
    ],

    inject: ['repositoryFactory'],

    data() {
        return {
            isLoading: false,
        };
    },

    computed: {
        mediaRepository() {
            return this.repositoryFactory.create('media');
        },

        // Ten computed jest teraz głównym źródłem danych dla `sw-media-upload-v2`
        previewSource() {
            // `element.data.media` jest obiektem przejściowym, ładowanym z serwera
            // `element.config.mediaId.value` jest tym, co faktycznie zapisujemy
            if (this.element.data && this.element.data.media) {
                return this.element.data.media;
            }
            return null;
        },

        uploadTag() {
            return `cms-element-media-config-${this.element.id}`;
        },

        roomCategoryOptions() {
            return [
                { label: 'All Rooms', value: 'all' },
                { label: 'Living Room', value: 'living-room' },
                { label: 'Bedroom', value: 'bedroom' },
                { label: 'Kitchen', value: 'kitchen' },
                { label: 'Bathroom', value: 'bathroom' },
                { label: 'Dining Room', value: 'dining-room' },
                { label: 'Office', value: 'office' },
                { label: 'Garden', value: 'garden' }
            ];
        }
    },

    created() {
        this.createdComponent();
    },

    methods: {
        createdComponent() {
            this.initElementConfig('shoppable-image');
            this.initElementData('shoppable-image');
            if (!this.element.config.hotspots.value) {
                this.element.config.hotspots.value = [];
            }
            if (!this.element.config.roomCategory) {
                this.element.config.roomCategory = {
                    source: 'static',
                    value: 'all' // Ustawiamy 'all' jako domyślną wartość
                };
            }
        },

        onMediaInput(mediaId) {
            if (!this.element.data) {
                this.element.data = {};
            }
            this.element.config.media.value = mediaId;
            this.$emit('element-update', this.element);
        },

        onImageRemove() {
            if (!this.element.data) {
                this.element.data = {};
            }
            this.element.config.media.value = null;
            this.element.config.hotspots.value = [];
            this.element.data.media = null;
            this.$emit('element-update', this.element);
        },

        onImageClick(event) {
            const wrapper = this.$refs.imageWrapper;
            if (!wrapper) return;
            const x = ((event.clientX - wrapper.getBoundingClientRect().left) / wrapper.offsetWidth) * 100;
            const y = ((event.clientY - wrapper.getBoundingClientRect().top) / wrapper.offsetHeight) * 100;
            if (!this.element.config.hotspots.value) {
                this.element.config.hotspots.value = [];
            }
            this.element.config.hotspots.value.push({
                id: Utils.createId(),
                productId: null,
                positionX: x.toFixed(2),
                positionY: y.toFixed(2),
            });
            this.$emit('element-update', this.element);
        },

        removeHotspot(hotspotId) {
            const index = this.element.config.hotspots.value.findIndex(h => h.id === hotspotId);
            if (index > -1) {
                this.element.config.hotspots.value.splice(index, 1);
                this.$emit('element-update', this.element);
            }
        },

        onHotspotProductChange(productId, hotspotId) {
            const hotspot = this.element.config.hotspots.value.find(h => h.id === hotspotId);
            if (hotspot) {
                hotspot.productId = productId;
                this.$emit('element-update', this.element);
            }
        },

        onRoomCategoryChange(value) {
            this.element.config.roomCategory.value = value;
            this.$emit('element-update', this.element);
        }
    }
});