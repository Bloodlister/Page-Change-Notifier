<template>
    <div class="search">
        <div class="row">
            <dropdown default="1" hrefValue="topmenu" :storage="storage">
                <option v-for="(option, index) in this.inputs.topmenu" :key="index" 
                    :value="option.hrefValue">{{ option.label }}</option>
            </dropdown>

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
    name: 'MobileBG',
    components: {
        BetweenNumbers,
        Checkbox,
        Dropdown,
        Currency,
        BrandModel,
    },
    methods: {
        getData: function() {
            console.log('Hello');
        },
    },
    data: function() {
        return {
            target: "https://www.mobile.bg/pcgi/mobile.cgi",
            storage: {
                f20: "6", // Price
                f21: "01", // New and Used cars
            },
            inputs: Inputs,
        };
    },
    mounted: function() {
        console.log(this.storage);
    }
};
</script>
