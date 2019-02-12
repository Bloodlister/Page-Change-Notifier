<template>
    <div class="search">
        Brand:
        <select v-model="selectedBrand" @change="setBrand">
            <option selected disabled style="display: none;"></option>
            <option v-for="(brandOption, index) in this.brands"
                    :key="index"
                    :value="index">{{ brandOption }}</option>
        </select>

        Model:
        <select v-model="selectedModel" @change="setModel">
            <option value=""></option>
            <option v-for="(modelOption, index) in modelsForBrand"
                    :key="index"
                    :value="modelOption">{{ modelOption }}</option>
        </select>
    </div>
</template>

<script>
export default {
    props: ['storage', 'brands'],
    data() {
        return {
            selectedBrand: null,
            selectedModel: null,
            modelsForBrand: {}
        }
    },
    methods: {
        setBrand: function(event) {
            this.storage['brandId'] = event.target.value;
            this.$http.get();
        },
        setModel: function(event) {
            console.log(event);
        }
    }
}
</script>

<style>

</style>