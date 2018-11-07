<template>
    <div class="input">
        <between-numbers :hrefValues="scopeData.hrefValues" 
                        :storage="storage"
                        :label="scopeData.label" 
                        :extraData="scopeData.extraData"/>

        <dropdown :storage="storage" :hrefValue="dropdownData.hrefValue" :default="dropdownData.default">
            <option v-for="(option, index) in dropdownData.options" :key="index" :value="option.value">{{option.label}}</option>
        </dropdown>
    </div>
</template>

<script>
import BetweenNumbers from './BetweenNumbers.vue';
import Dropdown from './Dropdown.vue';

export default {
    name: 'Currency',
    props: ['storage', 'scopeData', 'dropdownData'],
    components: {
        BetweenNumbers,
        Dropdown,
    },
}
</script>