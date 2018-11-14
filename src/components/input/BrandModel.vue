<template>
    <div class="search">
        Brand: 
        <select v-model="selectedBrand" @click="setBrand">
            <option value=""></option>
            <option v-for="(brandOption, index) in data.brandOptions" 
                    :key="index" 
                    :value="brandOption.hrefValue">{{ brandOption.label }}</option>
        </select>

        Model:  
        <select v-model="selectedModel" @click="setModel">
            <option value=""></option>
            <option v-for="(modelOption, index) in modelsForBrand"
                    :key="index"
                    :value="modelOption.hrefValue">{{ modelOption.label }}</option>
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
            return this.data.modelOptions[this.selectedBrand]
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
    mounted: function() {
        console.log(this.storage)
    }
}
</script>
