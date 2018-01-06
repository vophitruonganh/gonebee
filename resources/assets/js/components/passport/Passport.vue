<template>
    <div class="container">
    <passport-clients></passport-clients>
    <authorized-clients></authorized-clients>
    <personal-access-tokens></personal-access-tokens>
    </div>
</template>

<script>
import PassportClients from './Clients.vue';
import AuthorizedClients from './AuthorizedClients.vue';
import PersonalAccessTokens from './PersonalAccessTokens.vue';
export default {
    components:{
        PassportClients: PassportClients,
        AuthorizedClients:AuthorizedClients,
        PersonalAccessTokens:PersonalAccessTokens
    }
}
</script>

<style>
#app {
  font-family: Arial, Helvetica, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;

  background: #f1f1f1;
}
</style>
