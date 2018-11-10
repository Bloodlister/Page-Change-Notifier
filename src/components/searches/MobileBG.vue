<template>
    <div class="search">
        <dropdown default="1" hrefValue="topmenu" :storage="storage">
            <option value="1">Cars and Jeeps</option>
            <option value="3">Buses</option>
            <option value="5">Motorbikes</option>
        </dropdown>
        <div class="column">
            <brand-model :storage="storage"
                        :data="inputs.brandModel"/>

            <currency :storage="storage" :dropdownData="inputs.price.dropdownData" :scopeData="inputs.price.scopeData" />
            
            <between-numbers v-for="(between, index) in inputs.betweens" 
                            v-bind:key="index"
                            :storage="storage"
                            :label="between.label" 
                            :hrefValues="between.hrefValues"
                            :extraData="between.extraData"/>
        </div>
        <div class="row">
            <checkbox v-for="(checkbox, index) in inputs.checkboxes" :key="index" 
                        :label="checkbox.label"
                        :storage="storage"
                        :hrefValue="checkbox.hrefValue"/>
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
};
</script>
