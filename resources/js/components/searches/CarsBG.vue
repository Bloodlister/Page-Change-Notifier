<template>
    <div class="search">
        <div class="row">
            <brand-model :storage="this.storage" :brands="this.inputs.brands"/>
        </div>
    </div>
</template>


<script>
import Inputs from './data/CarsBG.js';
import BrandModel from './../input/CarsBG/BrandModel.vue'

export default {
    name: 'CarsBG',
    title: 'CarsBg',
    components: {
        BrandModel
    },
    data: function() {
        return {
            storage: Inputs.defaultStorage,
            inputs: Inputs.inputs,
        }
    },
    methods: {
        passToParent: function() {
            this.$emit('passData', {
                type: "CarsBg",
                data: this.storage
            })
        }
    },
};
</script>
