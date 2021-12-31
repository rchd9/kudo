<template>
    <div class="container">
        <h3>Kudo Board</h3>

        <div v-show="success" class="alert alert-success mt-1" role="alert">
            <p>{{ message }}</p>
        </div>

        <div>
            <ul class="actions">
                <li>
                    <button @click="addKudo" class="btn btn-primary btn-block btn-u">Add new Kudo</button>
                </li>
                <li>
                    <button  @click="viewKudos" class="btn btn-primary btn-block btn-u">View Kudos</button>
                </li>
                <li>
                    <button @click="logout" class="btn btn-primary btn-block btn-u">Logout</button>
                </li>
            </ul>
        </div>

        <div class="list">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col">Created at</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="kudo in kudos" :key="kudo.id">
                            <td>{{ kudo.title }}</td>
                            <td>{{ $moment(kudo.created_at).format('MMMM DD[,] h:mm A') }}</td>
                            <td><button @click="addCard(kudo.id)" class="btn btn-primary btn-u">Add Card</button></td>
                        </tr>
                    </tbody>
                </table>
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
          success: false,
          message: ''
      }
    },
    computed:{
        ...mapGetters({
            kudos: 'kudo/getKudos',
        })
    },
    async mounted() {
        if(this.$route.query.q) {
            this.success = true;
            this.message = decodeURI(this.$route.query.q);
        }

        const session = JSON.parse(Cookies.get('session'));
        const token = session.token;
        await this.$store.dispatch('kudo/getAllKudos', token);
    },
    methods: {
        viewKudos() {
            this.$router.push('/');
        },
        addKudo() {
            this.$router.push('/kudo/add-kudo');
        },
        addCard(kudoId) {
            this.$router.push('/kudo/add-card/?id='+kudoId);
        },
        async logout() {
            await this.$store.dispatch('account/logout');
            Cookies.remove('session');
            window.location.reload(true);
        }
    }
}
</script>
