<template>
    <div>
        <h2 class="text-center">CarsBG Buses</h2>
        <div v-if="filtersStatus === 2 && filters.length > 0" id="filters">
            <mobileBGFilter  v-for="(filter, index) in filters"
                             :key="index"
                             :id="filter.id"
                             :data="filter"
                             :brandModels="brandModels"
                             v-on:resetListenings="setFilters"
                             class="filter"/>
        </div>
        <div v-else-if="filtersStatus === 2 && filters.length === 0">
            No filters found.
        </div>
        <div v-else>
            Loading . . .
        </div>
    </div>
</template>

<script>
    import Filter from './CarsBG/CarFilterBuses.vue';

    export default {
        name: "CarsBGBusesView",
        components: {
            mobileBGFilter: Filter
        },
        data: function() {
            return {
                filters: [],
                filtersStatus: 1,
                brandModels: {
                    getModels(brand) {
                        if (!this.models[brand]) {
                            this.$http.get('/carsbg/models?brandId=' + this.storage['brandId']).then(resp => {
                                this.models = resp.data.models;
                            });
                        }
                    }
                },
            };
        },
        computed: {
            hasListenings() {
                if (this.filters.length > 0) {
                    return true;
                }
                return false;
            }
        },
        mounted: function() {
            this.setFilters();
        },
        methods: {
            setFilters() {
                this.$http.get('/filters/CarsBGBuses')
                    .then(({data}) => {
                        this.filtersStatus = 2;
                        this.filters = data;
                    });
            }
        }
    }
</script>


<style lang="scss" scoped>
    #filters {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: flex-start;

        .filter {
            border-radius: 10px;
            border: 1px solid black;
            max-width: 300px;
            padding: 10px;
            margin: 10px;
        }
    }
</style>