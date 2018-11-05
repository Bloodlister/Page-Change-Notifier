<template>
    <div class="input">
        <input type="checkbox" checked>
        <p class="inputLable">{{label}}:</p>
        <div class="number-input">
            Min <input type="number" min="0" placeholder="0" v-model="min_value">
            -
            Max <input type="numbet" min="0" placeholder="0" v-model="max_value">
        </div>
    </div>
</template>


<script>
export default {
    name: "BetweenNumbers",
    props: ['label'],
    data: function () {
        return {
            min_value: 0,
            max_value: 0,
        }
    },
}
</script>

<style lang="scss" scoped>
@import '../../assets/input.scss';
</style>
