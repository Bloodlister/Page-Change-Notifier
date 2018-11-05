<template>
    <div class="search">
        <between-numbers label="Price"/>
        <div class="row">
            <checkbox label="Shiny"/>
            <checkbox label="Muddy"/>
            <checkbox label="Skimpy"/>
        </div>
    </div>
</template>


<script>
import BetweenNumbers from '../input/BetweenNumbers.vue';
import Checkbox from '../input/Checkbox.vue';

export default {
    name: 'MobileBG',
    components: {
        BetweenNumbers,
        Checkbox,
    },
};
</script>
