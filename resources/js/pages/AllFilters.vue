<template>
    <div>
        <router-link :to="{name:'home'}">Go Back</router-link>
        <MobileBGCarsView></MobileBGCarsView>
        <hr>
        <MobileBGBikesView></MobileBGBikesView>
        <hr>
        <MobileBGBusesView></MobileBGBusesView>
        <hr>
    </div>
</template>

<script>
    import MobileBGCarsView from '../components/filterViews/MobileBGCars.vue';
    import MobileBGBikesView from '../components/filterViews/MobileBGBikes.vue';
    import MobileBGBusesView from '../components/filterViews/MobileBGBuses.vue';

    export default {
        name: 'AllFilters',
        components: {
            MobileBGCarsView: MobileBGCarsView,
            MobileBGBikesView: MobileBGBikesView,
            MobileBGBusesView: MobileBGBusesView,
        }
    }
</script>

