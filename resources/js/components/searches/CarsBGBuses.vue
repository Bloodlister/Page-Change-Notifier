<template>
    <div class="search">
        <div class="row">
            <brand-model :storage="this.storage" :brands="this.inputs.brands"/>
            <price :storage="this.storage"></price>
            <years :storage="this.storage"></years>
        </div>
        <button v-on:click="passToParent">Create filter</button>
    </div>
</template>


<script>
import Inputs from './data/CarsBgBuses.js';
import BrandModel from '../input/CarsBGBuses/BrandModel.vue';
import Years from '../input/CarsBGBuses/Years.vue';
import Price from '../input/CarsBGBuses/Price.vue';

export default {
    name: 'CarsBGBuses',
    title: 'CarsBg Buses',
    components: {
        BrandModel,
        Years,
        Price,
    },
    data: function() {
        return {
            storage: Inputs.defaultStorage,
            inputs: Inputs.inputs,
        }
    },
    methods: {
        passToParent() {
            this.$emit('passData', {
                type: "CarsBgBuses",
                data: this.storage
            })
        }
    },
};
</script>
