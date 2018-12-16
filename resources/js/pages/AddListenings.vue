<template>
    <div>
        <router-link :to="{name:'all'}">Your Listenings</router-link>
        &nbsp;|&nbsp; 
        <a href="/logout">Logout</a>
        <Wrapper />
    </div>
</template>

<script>
import Wrapper from './../components/Wrapper.vue';

export default {
    components: {
        Wrapper: Wrapper,
    },
}
</script>
