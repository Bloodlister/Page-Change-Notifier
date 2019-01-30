<template>
    <div class="search">
        <select @change="set">
            <slot />
        </select>
    </div>
</template>

<script>
export default {
    name: "Dropdown",
    props: ['storage', 'hrefValue', 'default'],
    mounted: function() {
        if(this.default) {
            this.storage[this.hrefValue] = this.default;
        }
    },
    methods: {
        set: function(event) {
            this.storage[this.hrefValue] = event.target.value;
        }
    }
};
</script>
