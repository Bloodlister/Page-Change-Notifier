<template>
    <div class="full-width">
        <div>
            Brand:
            <select v-model="selectedBrand" @change="setBrand">
                <option v-for="(brandOption, index) in this.brands"
                        :key="index"
                        :value="index">{{ brandOption }}</option>
            </select>
        </div>
        <div>
            <label for="model">Model:</label>
            <input type="text" name="model" id="model" v-model="model" @change="setModel">
        </div>
    </div>
</template>

<script>
export default {
    props: ['storage', 'brands'],
    data() {
        return {
            selectedBrand: null,
            model: '',
        }
    },
    methods: {
        setBrand(event) {
            this.storage['brand_motoId'] = event.target.value;
        },
        checkModel(event) {
            event.target.firstChild.checked = !event.target.firstChild.checked;
            event.target.firstChild.dispatchEvent(new Event('change'))
        },
        setModel(event) {
            this.storage['model_moto'] = this.model;
        }
    }
}
</script>

<style lang="scss">
.full-width {
    width: 100%;
}

.three-on-row {
    width: 100%;
    display: flex;
    justify-content: space-around;
    flex-direction: row;
    flex-wrap: wrap;

    .row-child {
        width: 32%;
        padding: 4px 0;
        margin: 3px;
        border: 1px solid #EEE;
        border-radius: 4px;
        transition: border 0.5s;

        &:hover {
            border: 1px solid #000;
        }
    }
}
</style>
