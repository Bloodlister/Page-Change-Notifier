<template>
    <div id="wrapper">
        <template>
            <div>
                <div class="searchNavigation">
                    <button v-on:click="index != 0 ? index-- : index++">◄</button>
                    <h1>{{currentSearch.name}}</h1>
                    <button v-on:click="index++">►</button>
                </div>
                <keep-alive>
                    <component :is="currentSearch" v-on:passData="createListen"></component>
                </keep-alive>
            </div>
        </template>
        
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
        }
    },
    computed:  {
        currentSearch: function () {
            return this.searches[this.index % this.searches.length];
        }
    },
    methods: {
        createListen: function(data) {
            console.log('create Listen');
        }
    }
};
</script>

<style lang="scss" scoped>
#wrapper {
    display: flex;
    flex-direction: column;
    width: 70vw;
    min-width: 600px;
    margin: 0 auto;
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
</style>
