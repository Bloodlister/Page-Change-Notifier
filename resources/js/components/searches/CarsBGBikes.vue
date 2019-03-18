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
import Inputs from './data/CarsBgBikes.js';
import BrandModel from '../input/CarsBGBikes/BrandModel.vue';
import Years from '../input/CarsBGBikes/Years.vue';
import Price from '../input/CarsBGBikes/Price.vue';

export default {
    name: 'CarsBGBikes',
    title: 'CarsBg Bikes',
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
                type: "CarsBgBikes",
                data: this.storage
            })
        }
    },
};
</script>
