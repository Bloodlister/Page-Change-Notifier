<template>
    <div class="input">
        <input type="checkbox">
        <p class="inputLable">{{label}}:</p>
        <div class="number-input">
            Min <input type="number" min="0" placeholder="0" v-model="min_value" @input="validateValue(); save()">
            -
            Max <input type="numbet" min="0" placeholder="0" v-model="max_value" @input="validateValue(); save()">
            <p v-if="error" class="error">Minimum value is bigger than maximum</p>
        </div>
    </div>
</template>


<script>
export default {
    name: "BetweenNumbers",
    props: ['storage', 'label', 'hrefValues', 'extraData'],
    data: function () {
        return {
            min_value: 0,
            max_value: 100,
            error: false,
        }
    },
    mounted: function() {
        if(this.extraData) {
            if(this.extraData.min) {
                this.min_value = this.extraData.min;
            }
            if(this.extraData.max) {
                this.max_value = this.extraData.max;
            }
        }
        this.save();
    },
    methods: {
        validateValue: function() {
            if(this.min_value > this.max_value) {
                this.error = true;
            } else {
                this.error = false;
            }
        },

        save: function() {
            this.storage[this.hrefValues.min] = {
                min_value: this.min_value,
            }
            this.storage[this.hrefValues.max] = {
                max_value: this.max_value,
            }
        },
    },
}
</script>

<style lang="scss" scoped>
.input {
    margin: 5px 0;
}
</style>
