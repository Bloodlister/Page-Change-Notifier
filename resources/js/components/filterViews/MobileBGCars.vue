<template>
    <div>
        <h2 class="text-center">MobileBG Cars</h2>
        <div v-if="filtersStatus === 2 && filters.length > 0" id="filters">
            <mobileBGFilter  v-for="(listening, index) in filters"
                        :key="index"
                        :id="listening.id"
                        :data="listening"
                        v-on:resetListenings="setListenings"
                        class="listening"/>
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
        name: "MobileBGCarsView",
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
                this.$http.get('/filters/MobileBG')
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

        .listening {
            border-radius: 10px;
            border: 1px solid black;
            max-width: 300px;
            padding: 10px;
            margin: 10px;
        }
    }
</style>