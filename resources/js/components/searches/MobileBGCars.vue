<template>
    <div class="search">
        <div class="row">
            <brand-model :storage="storage"
                    :data="this.inputs.brandOptions"/>
        </div>
        <div class="column">

            <currency :storage="storage" 
                    :dropdownData="inputs.price.dropdownData" 
                    :scopeData="inputs.price.scopeData" />

            <between-numbers v-for="(between, index) in inputs.betweens" 
                            v-bind:key="index"
                            :storage="storage"
                            :label="between.label" 
                            :hrefValues="between.hrefValues"
                            :extraData="between.extraData"/>
        </div>
        <button v-on:click="passToParent">Listen</button>
    </div>
</template>


<script>
import Dropdown from '../input/Dropdown.vue';
import Currency from '../input/Currency.vue';
import BetweenNumbers from '../input/BetweenNumbers.vue';
import Checkbox from '../input/Checkbox.vue';
import Inputs from './data/MobileBG.js';
import BrandModel from '../input/BrandModel.vue';

export default {
    name: 'MobileBGCars',
    title: 'MobileBG Cars',
    components: {
        BetweenNumbers,
        Checkbox,
        Dropdown,
        Currency,
        BrandModel,
    },
    methods: {
        passToParent: function() {
            this.$emit('passData', {
                type: "MobileBG",
                data: this.storage
            });
        },
    },
    data: function() {
        return {
            target: "https://www.mobile.bg/pcgi/mobile.cgi",
            storage: Inputs.requiredFields,
            inputs: Inputs,
        };
    },
};
</script>
