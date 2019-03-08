<template>
    <div class="full-width">
        <hr>
        Price: Min <input type="number" min="0" placeholder="0" v-model="priceFrom" @input="validateValue(); save()">
        -
        Max <input type="number" min="0" placeholder="0" v-model="priceTo" @input="validateValue(); save()">
        <select name="currencyId">
            <option value="1">лв.</option>
            <option value="2">USD</option>
            <option value="3">EUR</option>
        </select>
        <p v-if="error" class="error">Minimum value is bigger than maximum</p>
    </div>
</template>

<script>
    export default {
        name: "Price",
        props: ['storage'],
        data: function () {
            return {
                priceFrom: '',
                priceTo: '',
                error: false,
            }
        },
        mounted: function() {
            this.save();
        },

        methods: {
            activate: function() {
                this.priceFrom = '';
                this.priceTo = '';
                this.save();
            },

            validateValue: function() {
                this.error = Number.parseInt(this.priceFrom) > Number.parseInt(this.priceTo);
            },

            save: function() {
                this.storage['priceFrom'] = this.priceFrom;
                this.storage['priceTo'] = this.priceTo;
            },
        },
    }
</script>
