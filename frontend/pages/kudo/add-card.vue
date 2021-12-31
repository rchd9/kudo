<template>
    <div class="container">
        <h3>Kudo Board</h3>

        <h4 class="kudo-title"><b>Title:</b> {{ kudo.title }}</h4>

        <b-form @submit.stop.prevent="handleSubmit" novalidate>
            <b-form-group id="input_group_2" label="Subject" label-for="input_subject">
                <b-form-select
                    id="input-3"
                    v-model="$v.form.subject.$model"
                    :options="subjects"
                    :state="validateState('subject')"
                    aria-describedby="input_subject_feedback"
                    ></b-form-select>

                <b-form-invalid-feedback
                    id="input_subject_feedback"
                >This is a required field.</b-form-invalid-feedback>
            </b-form-group>
            
            <b-form-group id="input_group_3" label="Comment" label-for="input_comment">
                <b-form-textarea
                    id="input_comment"
                    name="input_comment"
                    v-model="$v.form.comment.$model"
                    :state="validateState('comment')"
                    aria-describedby="input_comment_feedback"
                    placeholder=""
                    rows="3"
                    max-rows="6"
                ></b-form-textarea>

                <b-form-invalid-feedback
                    id="input_comment_feedback"
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
import { required, email, minLength } from "vuelidate/lib/validators";

export default {
    middleware: 'auth',
    data () {
      return {
        form: {
          comment: null,
          subject: null
        },
        subjects: ["awesome", "a privilege", "good job", "a lot of wisdom", "well done", "thank you", "the next time", "to improve"],
        kudoName: '',
        submitted: false,
        success: false,
        message: '',
        error: false,
        errorsMessage: []
      }
    },
    validations: {
        form: {
            comment: { required },
            subject: { required }
        }
    },
    computed:{
        ...mapGetters({
            kudo: 'kudo/getKudo',
        })
    },
    async mounted(){
        
        const id = this.$route.query.id;
        const session = JSON.parse(Cookies.get('session'));
        const token = session.token;
        await this.$store.dispatch('kudo/getKudoFromId', {id, token} );

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
                kudoId: this.kudo.id,
                subject: this.form.subject,
                comment: this.form.comment
            }

            const session = JSON.parse(Cookies.get('session'));
            const token = session.token;
            await this.$store.dispatch('kudo/addCard', {payload, token})
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
