<template>
    <div class="search">
        Brand: 
        <select v-model="selectedBrand" @click="setBrand">
            <option value=""></option>
            <option v-for="(brandOption, index) in Object.keys(data.brandsAndModels)" 
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
    name: 'BrandModel',
    props: ['storage', 'data'],
    data: function() {
        return {
            selectedBrand: '',
            selectedModel: '',
        };
    },
    computed: {
        modelsForBrand: function() {
            return this.data.brandsAndModels[this.selectedBrand]
        }
    },
    methods: {
        setBrand: function(event) {
            this.storage[this.data.hrefValues.brand] = event.target.value;
            this.storage[this.data.hrefValues.model] = '';
        },
        setModel: function	(event) {
            this.storage[this.data.hrefValues.model] = event.target.value;
        },
    },
    mounted: function() {}
}
</script>
