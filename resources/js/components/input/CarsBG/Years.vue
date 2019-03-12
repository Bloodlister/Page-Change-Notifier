<template>
    <div class="full-width">
        <br>
        Year: Min <input type="number" min="0" placeholder="0" v-model="yearFrom" @input="validateValue(); save()">
        -
        Max <input type="number" min="0" placeholder="0" v-model="yearTo" @input="validateValue(); save()">
        <p v-if="error" class="error">Minimum value is bigger than maximum</p>
    </div>
</template>

<script>
    export default {
        name: "Years",
        props: ['storage'],
        data: function () {
            return {
                yearFrom: '',
                yearTo: '',
                error: false,
            }
        },
        mounted: function() {
            this.save();
        },

        methods: {
            activate: function() {
                this.yearFrom = '';
                this.yearTo = '';
                this.save();
            },

            validateValue: function() {
                this.error = Number.parseInt(this.yearFrom) > Number.parseInt(this.yearTo);
            },

            save: function() {
                this.storage['yearFrom'] = this.yearFrom;
                this.storage['yearTo'] = this.yearTo;
            },
        },
    }
</script>