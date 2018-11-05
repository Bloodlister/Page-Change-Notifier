<template>
    <div class="input">
        <div class="input-checkbox">
            {{label}}: <input type="checkbox">
        </div>
    </div>
</template>


<script>
export default {
    name: "Checkbox",
    props: ['label'],
    data: function () {
        return {
            checked: false,
        }
    },
}
</script>