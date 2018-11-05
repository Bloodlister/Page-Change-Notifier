<template>
    <div id="wrapper">
        <h1>Wrapper</h1>
        <template>
            <div>
                <div class="searchNavigation">
                    <button v-on:click="index != 0 ? index-- : index++">◄</button>
                    <h1>{{currentSearchName}}</h1>
                    <button v-on:click="index++">►</button>
                </div>

                <component :is="currentSearch"></component>
            </div>
        </template>
        <button v-on:click="setListen">Listen</button>
    </div>
</template>


<script>
import MobileBG from './searches/MobileBG.vue';
import CarsBG from './searches/CarsBG.vue';

export default {
    name: 'Wrapper',
    components: {
        MobileBG,
        CarsBG,
    },
    data: function() {
        return {
            index: 0,
            searches: [MobileBG, CarsBG],
            searchesNames: ['MobileBG', 'CarsBG'],
        }
    },
    computed:  {
        currentSearch: function () {
            return this.searches[this.index % this.searches.length];
        },
        currentSearchName: function () {
            return this.searchesNames[this.index % this.searches.length];
        }
    },
    methods: {
        setListen: function () {
            console.log('Saved');
        },
    },
};
</script>

<style lang="scss" scoped>
#wrapper {
    display: flex;
    flex-direction: column;
    width: 50vw;
    min-width: 300px;
}

.searchNavigation {
    display: flex;
    justify-content: space-between;
    flex-direction: row;

    button {
        border: none;
        background: rgb(38, 176, 183);
        color: white;
        font-family: 'Courier New', Courier, monospace;
        font-weight: bold;
        font-size: 30px;
    }
}

.row {
    display: flex;
    justify-content: space-around;
    flex-direction: row;
}
</style>
