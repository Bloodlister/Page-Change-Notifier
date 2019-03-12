<template>
    <div class="input">
        <div class="input-checkbox">
            {{label}}: <input type="checkbox" @click="set">
        </div>
    </div>
</template>


<script>
export default {
    name: "Checkbox",
    props: ['storage', 'hrefValue', 'label'],
    data: function () {
        return {
            checked: false,
        }
    },
    methods: {
        set: function(event) {
            this.storage[this.hrefValue] = event.target.value === 'on' ? 1 : 0;
        }
    }
}
</script>

<style lang="scss" scoped>
.input {
    flex: 1 0 21%;
}
</style>
