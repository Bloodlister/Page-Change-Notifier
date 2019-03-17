<template>
    <div class="search">
        <div class="row">
            <brand-model :storage="storage" :data="this.inputs.brandOptions"/>
        </div>
        <div class="column">

            <currency :storage="storage" :dropdownData="inputs.price.dropdownData" :scopeData="inputs.price.scopeData" />

            <between-numbers v-for="(between, index) in inputs.betweens"
                             v-bind:key="index"
                             :storage="storage"
                             :label="between.label"
                             :hrefValues="between.hrefValues"
                             :extraData="between.extraData"/>
        </div>
        <button v-on:click="passToParent">Create filter</button>
    </div>
</template>


<script>
    import Dropdown from '../input/MobileBGBuses/Dropdown.vue';
    import Currency from '../input/MobileBGBuses/Currency.vue';
    import BetweenNumbers from '../input/MobileBGBuses/BetweenNumbers.vue';
    import Checkbox from '../input/MobileBGBuses/Checkbox.vue';
    import Inputs from './data/MobileBGBuses.js';
    import BrandModel from '../input/MobileBGBuses/BrandModel.vue';

    export default {
        name: 'MobileBGBuses',
        title: 'MobileBG Buses',
        components: {
            BetweenNumbers,
            Checkbox,
            Dropdown,
            Currency,
            BrandModel,
        },
        methods: {
            passToParent() {
                this.$emit('passData', {
                    type: "MobileBGBuses",
                    data: this.storage
                });
            },
        },
        data: function() {
            return {
                storage: Inputs.requiredFields,
                inputs: Inputs,
            };
        },
    };
</script>
