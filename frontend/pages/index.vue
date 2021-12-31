<template>
    <div class="container">
      <h3 class="mt-4">Kudo Board</h3>

      <div class="row">

        <div class="col-md-4 mb-4" v-for="kudo in kudos" :key="kudo.id">
          <div @click="goToKudo(kudo.id)" class="card kudo-card h-100">
            <img src="" class="card-img-top" alt="">
            <div class="card-body">
              <h5 class="card-title">{{ kudo.title }}</h5>
            </div>
          </div>
        </div>
        
      </div>


    </div>
</template>

<script>
import { mapGetters } from 'vuex';
import Cookies from 'js-cookie';

export default {
  name: 'IndexPage',
  middleware: 'auth',
  data () {
      return {

      }
    },
    computed:{
        ...mapGetters({
            kudos: 'kudo/getKudos',
        })
    },
    async mounted() {
        const session = JSON.parse(Cookies.get('session'));
        const token = session.token;
        await this.$store.dispatch('kudo/getAllKudos', token);
    },
    methods: {
        goToKudo(id) {
            this.$router.push('/kudo-detail?id='+id);
        }
    }
}
</script>

<style>

</style>