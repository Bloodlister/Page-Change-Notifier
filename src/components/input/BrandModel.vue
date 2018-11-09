<template>
    <div class="search">
        <select>
            <option v-for="(brandOption, index) in brandOptions" 
                    :key="index" 
                    :value="brandOption.hrefValue">{{ brandOption.label }}</option>
        </select>
    </div>
</template>

<script>
export default {
    name: 'BrandModel',
    props: ['storage', 'hrefValues', 'brandOptions', 'modelOptions'],
}
</script>
