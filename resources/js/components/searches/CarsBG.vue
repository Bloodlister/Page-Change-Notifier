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
import Inputs from './data/CarsBG.js';
import BrandModel from './../input/CarsBG/BrandModel.vue';
import Years from './../input/CarsBG/Years.vue';
import Price from './../input/CarsBG/Price.vue';

export default {
    name: 'CarsBG',
    title: 'CarsBg',
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
                type: "CarsBg",
                data: this.storage
            })
        }
    },
};
</script>
