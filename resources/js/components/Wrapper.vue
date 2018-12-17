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
                <div class="message">
                    <div v-if="message !== ''" 
                        class="success"
                        @click="clearMessage"
                        >
                        {{ message }}
                    </div>
                    <div v-if="error !== ''" 
                        class="error"
                        @click="clearError"
                        >
                        {{ error }}
                    </div>
                </div>
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
            message: '',
            error: ''
        }
    },
    computed:  {
        currentSearch: function () {
            return this.searches[this.index % this.searches.length];
        }
    },
    methods: {
        createListen: function(data) {
            this.$http.post('/filters/create', data)
            .then(resp => {
                this.message = "Success";
            })
            .catch(err => {
                this.message = "Error";
            });
        },
        clearMessage: function() {
            this.message = '';
        },
        clearError: function() {
            this.error = '';
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

.message {
    text-align: center;
    text-transform: uppercase;

    .success {
        display: block;
        margin: 10px auto;
        width: 400px;
        border: 1px solid rgb(150, 255, 150);
        border-radius: 10px;
        background-color: rgb(100, 255, 100);
        color: white;
    }

    .error {
        display: block;
        margin: 10px auto;
        width: 400px;
        border: 1px solid rgb(255, 55, 55);
        border-radius: 10px;
        background-color: rgb(255, 70, 70);
        color: black;
    }
}
</style>
