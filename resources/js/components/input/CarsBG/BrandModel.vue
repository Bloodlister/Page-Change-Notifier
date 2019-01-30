<template>
    <div class="search">
        Brand:
        <select v-model="selectedBrand" @click="setBrand">
            <option value=""></option>
            <option v-for="(brandOption, index) in Object.keys(this.brands)"
                    :key="index"
                    :value="brandOption">{{ brandOption }}</option>
        </select>

        Model:
        <select v-model="selectedModel" @click="setModel">
            <option value=""></option>
            <option v-for="(modelOption, index) in modelsForBrand"
                    :key="index"
                    :value="modelOption">{{ modelOption }}</option>
        </select>
    </div>
</template>

<script>
export default {
    props: ['brands'],
    data: function() {
        return {
            selectedBrand: '',
            models: {}
        }
    },
    mounted: function() {
        console.log(this.brands);
    },
    methods: {
        setBrand: function(event) {
            this.storage[this.data.hrefValues.brand] = event.target.value;
            this.storage[this.data.hrefValues.model] = '';
        }
    }
}
</script>

<style>

</style>