<template>
    <div class="search">
        Brand: 
        <select v-model="selectedBrand">
            <option value=""></option>
            <option v-for="(brandOption, index) in data.brandOptions" 
                    :key="index" 
                    :value="brandOption.hrefValue">{{ brandOption.label }}</option>
        </select>

        Model:  
        <select>
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
    props: ['storage', 'hrefValues', 'data'],
    data: function() {
        return {
            selectedBrand: '',
        };
    },
    computed: {
        modelsForBrand: function() {
            return this.data.modelOptions[this.selectedBrand]
        }
    }
}
</script>
