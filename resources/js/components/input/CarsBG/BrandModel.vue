<template>
    <div class="full-width">
        <div>
            Brand:
            <select v-model="selectedBrand" @change="setBrand">
                <option selected disabled style="display: none;"></option>
                <option v-for="(brandOption, index) in this.brands"
                        :key="index"
                        :value="index">{{ brandOption }}</option>
            </select>
        </div>
        <div>
            Models: |
            <button class="btn btn-sm btn-info pull-right" @click="modelsVisible = !modelsVisible">Hide models</button>
            <div class="three-on-row" v-show="modelsVisible">
                <div class="row-child" v-for="(model, id) in models" @click.self="checkModel">
                    <input :key="id"
                           :id="'model_' + id"
                           type="checkbox"
                           name="models[]"
                           @change="setModel"
                           :value=id /> {{ model }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['storage', 'brands'],
    data() {
        return {
            selectedBrand: null,
            selectedModel: null,
            models: {},
            modelsVisible: true,
        }
    },
    methods: {
        setBrand: function(event) {
            this.storage['brandId'] = event.target.value;
            this.storage['models'] = [];

            this.$http.get('/carsbg/models?brandId=' + this.storage['brandId']).then(resp => {
                this.models = resp.data.models;
            });
        },
        checkModel: function (event) {
            event.target.firstChild.checked = !event.target.firstChild.checked;
            event.target.firstChild.dispatchEvent(new Event('change'))
        },
        setModel(event) {
            let checked = event.target.checked;
            let value = event.target.value;
            if (checked) {
                this.storage['models'].push(value);
            } else {
                this.storage['models'].splice(this.storage['models'].indexOf(value), 1);
            }
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