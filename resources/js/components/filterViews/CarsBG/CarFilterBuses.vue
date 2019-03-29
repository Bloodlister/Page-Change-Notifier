<template>
    <div>
        <div class="title">{{ this.data.type }}</div>
        <div class="description">
            <p>Brand: {{ brand }}</p>
            <p>Models:</p>
            <p> {{ models }}</p>
            <p>Price:
                {{ searchParams.priceFrom }}{{ searchParams.priceFrom ? searchParams.currency : ''}} -
                {{ searchParams.priceTo }}{{ searchParams.priceTo ? searchParams.currency : ''}}</p>
            <p>Year: {{ searchParams.yearFrom }} - {{ searchParams.yearTo }}</p>
        </div>
        <hr>
        <div class="actions">
            <div @click.stop="remove">Remove</div>
        </div>
    </div>
</template>

<script>
    import brandsAndModels from '../../../../../storage/app/carsBGConfigs/CarsBGBuses.json'
    import inputData from '../../searches/data/CarsBgBuses.js';

    let brands = inputData.inputs.brands;

    export default {
        name: "CarsBGBusesFilter",
        props: {
            id: {
                type: Number,
                required: true,
            },
            data: Object
        },
        computed: {
            brand() {
                return brands[this.data.search_params.brandId];
            },
            models() {
                let modelNames = [];
                this.data.search_params.models.forEach((id) => {
                    modelNames.push(brandsAndModels[this.data.search_params.brandId][id]);
                });

                return modelNames.join(' / ');
            },
            searchParams() {
                let data = {};
                if (this.data.search_params !== undefined) {
                    if (this.data.search_params['brand'] !== '') {
                        data.brand = this.data.search_params['brand'];
                        data.model = this.data.search_params['models'];
                    }
                    if (this.data.search_params['yearFrom'] !== '' || this.data.search_params['yearTo'] !== '') {
                        data.yearFrom = this.data.search_params['yearFrom'];
                        data.yearTo = this.data.search_params['yearTo'];
                        data.currency = this.data.search_params['currency'];
                    }
                    if (this.data.search_params['priceFrom'] !== '' || this.data.search_params['priceTo'] !== '') {
                        data.priceFrom = this.data.search_params['priceFrom'];
                        data.priceTo = this.data.search_params['priceTo'];
                    }
                }

                return data;
            }
        },
        methods: {
            remove() {
                this.$http.post('/filters/delete', {
                    filterId: this.id
                }).then(res => {
                    if(res.data.success) {
                        this.$emit('resetListenings');
                    }
                });
            }
        }
    }
</script>