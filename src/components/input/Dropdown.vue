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
    props: ['storage', 'hrefValue'],
    methods: {
        set: function(event) {
            this.storage[this.hrefValue] = event.target.value;
            console.log(this.storage);
        }
    }
};
</script>
