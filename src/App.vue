<template>
  <div id="app">
    <Wrapper></Wrapper>
  </div>
</template>

<script>
import Wrapper from './components/Wrapper.vue';

export default {
  name: 'app',
  components: {
    Wrapper,
  },
};
</script>

<style lang="scss">
@import './assets/input.scss';

#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
</style>
