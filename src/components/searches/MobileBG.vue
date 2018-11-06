<template>
    <div class="search">
        <dropdown hrefValue="topmenu" :storage="storage">
            <option value="1">Cars and Jeeps</option>
            <option value="3">Buses</option>
            <option value="5">Motorbikes</option>
        </dropdown>
        <div class="column">
            <between-numbers v-for="(between, index) in betweens" 
                             v-bind:key="index"
                             :storage="storage"
                             :label="between.label" 
                             :hrefValues="between.hrefValues"
                             :extraData="between.extraData"/>
        </div>
        <div class="row">
            <checkbox v-for="(checkbox, index) in checkboxes" :key="index" 
                        :label="checkbox.label"
                        :storage="storage"
                        :hrefValue="checkbox.hrefValue"/>
        </div>
    </div>
</template>


<script>
import Dropdown from '../input/Dropdown.vue';
import BetweenNumbers from '../input/BetweenNumbers.vue';
import Checkbox from '../input/Checkbox.vue';

export default {
    name: 'MobileBG',
    components: {
        BetweenNumbers,
        Checkbox,
        Dropdown,
    },
    methods: {
        getData: function() {
            console.log('Hello');
        }
    },
    data: function() {
        return {
            storage: {
                f20: "6", // Price
                f21: "01", // New and Used cars
            },
            betweens: [
                {
                    active: false,
                    label: "Price",
                    hrefValues: {
                        min: "f10",
                        max: "f11",
                    },
                    extraData: {
                        max: 30000,
                    },
                },
                {
                    active: false,
                    label: "Year",
                    hrefValues: {
                        min: "f7",
                        max: "f8",
                    },
                    extraData: {
                        min: 1990,
                        max: 2018,
                    },
                }
            ],
            checkboxes: [
                {
                    hrefValue: 'f22',
                    label: "Has Pictures",
                }
            ]
        }
    },
};
</script>
