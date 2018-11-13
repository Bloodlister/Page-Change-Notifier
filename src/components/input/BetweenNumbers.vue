<template>
    <div class="input">
        <input type="checkbox" v-model="active" @change="activate">
        <p class="inputLable">{{label}}:</p>
        <div class="number-input">
            Min <input :disabled="!active" type="number" min="0" placeholder="0" v-model="min_value" @input="validateValue(); save()">
            -
            Max <input :disabled="!active" type="number" min="0" placeholder="0" v-model="max_value" @input="validateValue(); save()">
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
            active: false,
            min_value: '',
            max_value: '',
            error: false,
        }
    },
    mounted: function() {
        this.save();
    },
    
    methods: {
        activate: function() {
            this.min_value = '';
            this.max_value = '';
            this.save();
        },

        validateValue: function() {
            if(this.min_value > this.max_value) {
                this.error = true;
            } else {
                this.error = false;
            }
        },

        save: function() {
            this.storage[this.hrefValues.min] = this.min_value;
            this.storage[this.hrefValues.max] = this.max_value;
        },
    },
}
</script>

<style lang="scss" scoped>
.input {
    margin: 5px 0;
}
</style>
