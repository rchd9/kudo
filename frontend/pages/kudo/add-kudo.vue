<template>
    <div class="container">
        <h3>Kudo Board</h3>

        <b-form @submit.stop.prevent="handleSubmit" novalidate>
                        
            <b-form-group id="input_group_1" label="User" label-for="input_user">
                <b-form-select
                    id="input-3"
                    v-model="$v.form.user.$model"
                    :state="validateState('user')"
                    aria-describedby="input_user_feedback"
                    >
                    <option
                        v-for="(option, index) in users"
                        :key="index"
                        :value="option.id"
                    >
                        {{ option.name }}
                    </option>
                    </b-form-select>

                <b-form-invalid-feedback
                    id="input_user_feedback"
                >This is a required field.</b-form-invalid-feedback>
            </b-form-group>
            
            <b-form-group id="input_group_3" label="Title" label-for="input_title">
                <b-form-input
                    id="input_title"
                    name="input_title"
                    v-model="$v.form.title.$model"
                    :state="validateState('title')"
                    aria-describedby="input_title_feedback"
                ></b-form-input>

                <b-form-invalid-feedback
                    id="input_title_feedback"
                >This is a required field.</b-form-invalid-feedback>
            </b-form-group>
            
            <input type="submit" value="Send" class="btn btn-primary btn-block btn-u">
            
            <span class="error-block error-message"></span>
            
            <hr>

            <div v-show="error" class="alert alert-danger mb-0 mt-3" role="alert">
                {{ errorsMessage }}
            </div>

        </b-form>
    </div>
</template>


<script>
import { mapGetters } from 'vuex';
import Cookies from 'js-cookie';
import { validationMixin } from "vuelidate";
import { required, email, minLength } from "vuelidate/lib/validators";

export default {
    middleware: 'auth',
    data () {
      return {
        form: {
          user: null,
          title: null
        },
        subjects: ["awesome", "a privilege", "good job", "a lot of wisdom", "well done", "thank you", "the next time", "to improve"],
        submitted: false,
        success: false,
        message: '',
        error: false,
        errorsMessage: []
      }
    },
    validations: {
        form: {
            user: {
                required
            },
            title: { required }
        }
    },
    computed:{
        ...mapGetters({
            users: 'users/getUsers',
        })
    },
    async mounted(){
        const session = JSON.parse(Cookies.get('session'));
        await this.$store.dispatch('users/getAllUsers', session.token);

    },
    methods: {
        validateState(name) {
            const { $dirty, $error } = this.$v.form[name];
            return $dirty ? !$error : null;
        },  
        async handleSubmit() {

            this.submitted = true;

            this.$v.form.$touch();

            if (this.$v.form.$anyError) {
                return;
            }

            const payload = {
                user: this.form.user,
                title: this.form.title
            }

            const session = JSON.parse(Cookies.get('session'));
            const token = session.token;
            await this.$store.dispatch('kudo/addKudo', {payload, token})
                .then( (resp) => {

                    if (resp.success == false) {

                        this.error = true;
                        this.errorsMessage = resp.message;

                    } else if (resp.success == true) {
                        this.$router.push('/kudo?q='+encodeURI(resp.message));
                    }

            });
        }
    }
}
</script>
