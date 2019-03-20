<template>
    <div>
        <h2 class="text-center">MobileBG Bikes</h2>
        <div v-if="filtersStatus === 2 && filters.length > 0" id="filters">
            <mobileBGFilter  v-for="(filter, index) in filters"
                        :key="index"
                        :id="filter.id"
                        :data="filter"
                        v-on:resetListenings="setListenings"
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
    import Filter from './MobileBG/Filter.vue';

    export default {
        name: "MobileBGBikesView",
        components: {
            mobileBGFilter: Filter
        },
        data: function() {
            return {
                filters: [],
                filtersStatus: 1
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
            this.setListenings();
        },
        methods: {
            setListenings() {
                this.$http.get('/filters/MobileBGBikes')
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