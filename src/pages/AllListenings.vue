<template>
    <div class="listenings">
        <listening  v-for="(listening, index) in listenings" 
                    :key="'listening_' + index"
                    :data="listening" />
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
        };
    },
    computed: {
        hasListenings() {
            if (this.listenings.lenght > 0) {
                return true;
            } 
            return false;
        }
    },
    mounted: function() {
        this.$http.get('/listening/list')
        .then(({data}) => {
            this.listenings = data;
        });
    }
}
</script>