<template>
    <div class="container">
      <h3 class="my-4">Kudo Board</h3>

      <h5 class="mb-4">{{ title }}</h5>

      <div class="row">

        <template v-if="cards.length > 0">

            <div class="col-md-4 mb-4" v-for="item in cards" :key="item.id">
                
                <div class="card kudo-card-detail mb-3" >
                    <div class="card-header">
                        {{ item.subject }}
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{ item.comment }}</p>
                    </div>
                    <div class="card-footer">
                        {{ $moment(item.created_at).format('MMMM DD[,] h:mm A') }}
                    </div>
                </div>

            </div>
        </template>

        <template v-else>
            <div class="col-md-12">
                <p>No Kudos yet.</p>
            </div>
        </template>
        
      </div>


    </div>
</template>

<script>
import { mapGetters } from 'vuex';
import Cookies from 'js-cookie';

export default {
  middleware: 'auth',
  data () {
      return {

      }
    },
    computed:{
        ...mapGetters({
            title: 'kudo/getKudoTitle',
            cards: 'kudo/getKudoCards',
        })
    },
    async mounted() {
        const id = this.$route.query.id;
        const session = JSON.parse(Cookies.get('session'));
        const token = session.token;
        await this.$store.dispatch('kudo/getKudoCardsFromId', { id, token });
    },
    methods: {

    }
}
</script>

<style>

</style>