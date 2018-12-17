<template>
    <div>
        <router-link :to="{name:'home'}">Go Back</router-link>
        <div v-if="listeningsStatus === 2 && listenings.length > 0" id="listenings">
            <listening  v-for="(listening, index) in listenings" 
                        :key="index"
                        :id="listening.id"
                        :data="listening" 
                        v-on:resetListenings="setListenings"
                        class="listening"/>
        </div>
        <div v-else-if="listeningsStatus === 2 && listenings.length === 0">
            No Listenings found.
        </div>
        <div v-else>
            Loading . . .
        </div>
    </div>
</template>

<script>
import Listening from './../components/Listening.vue';

export default {
    name: 'AllListenings',
    components: {
        Listening: Listening
    },
    data: function() {
        return {
            listenings: [],
            listeningsStatus: 1
        };
    },
    computed: {
        hasListenings() {
            if (this.listenings.length > 0) {
                return true;
            } 
            return false;
        }
    },
    mounted: function() {
        this.setListenings();
    },
    methods: {
        setListenings() {
            this.$http.get('/filters/all')
            .then(({data}) => {
                this.listeningsStatus = 2;
                this.listenings = data;
            });
        }
    }
}
</script>

<style lang="scss" scoped>
#listenings {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: flex-start;

    .listening {
        border-radius: 10px;
        border: 1px solid black;
        max-width: 300px;
        padding: 10px;
        margin: 10px;
    }
}
</style>
