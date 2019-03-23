<template>
    <div>
        <router-link :to="{name:'home'}">Go Back</router-link>
        <MobileBGCarsView></MobileBGCarsView>
        <hr>
        <MobileBGBikesView></MobileBGBikesView>
        <hr>
        <MobileBGBusesView></MobileBGBusesView>
        <hr>
        <CarsBGCarsView></CarsBGCarsView>
        <hr>
        <CarsBGBikesView></CarsBGBikesView>
        <hr>
        <CarsBGBusesView></CarsBGBusesView>
    </div>
</template>

<script>
    import MobileBGCarsView from '../components/filterViews/MobileBGCars.vue';
    import MobileBGBikesView from '../components/filterViews/MobileBGBikes.vue';
    import MobileBGBusesView from '../components/filterViews/MobileBGBuses.vue';
    import CarsBGCarsView from '../components/filterViews/CarsBGCars.vue';
    import CarsBGBikesView from '../components/filterViews/CarsBGBikes.vue';
    import CarsBGBusesView from '../components/filterViews/CarsBGBuses.vue';

    export default {
        name: 'AllFilters',
        components: {
            MobileBGCarsView: MobileBGCarsView,
            MobileBGBikesView: MobileBGBikesView,
            MobileBGBusesView: MobileBGBusesView,
            CarsBGCarsView: CarsBGCarsView,
            CarsBGBusesView: CarsBGBusesView,
            CarsBGBikesView: CarsBGBikesView,
        }
    }
</script>

