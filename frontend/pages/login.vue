<template>
    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            
            <div class="col wrapper-box">

                <div v-show="success" class="alert alert-success mt-1" role="alert">
                    <p>{{ message }}</p>
                </div>

                <h2 class="wrapper-box__title text-center">Sign in</h2>

                <div>
                
                    
                    <b-form @submit.stop.prevent="handleSubmit" novalidate>
                        
                        <b-form-group id="input_group_2" label="Email" label-for="input_email">
                            <b-form-input
                                id="input_email"
                                name="input_email"
                                v-model="$v.form.email.$model"
                                :state="validateState('email')"
                                aria-describedby="input_email_feedback"
                            ></b-form-input>

                            <template v-if="this.submitted && $v.form.email.$error">
                                <b-form-invalid-feedback id="input_email_feedback" v-if="!$v.form.email.required">Email is required.</b-form-invalid-feedback>
                                <b-form-invalid-feedback id="input_email_feedback" v-if="form.email && !$v.form.email.email">Enter valid email address.</b-form-invalid-feedback>
                            </template>
                        </b-form-group>
                        
                        <b-form-group id="input_group_3" label="Password" label-for="input_password">
                            <b-form-input
                                id="input_password"
                                name="input_password"
                                        type="password"
                                v-model="$v.form.password.$model"
                                :state="validateState('password')"
                                aria-describedby="input_password_feedback"
                            ></b-form-input>

                            <b-form-invalid-feedback
                                id="input_password_feedback"
                            >This is a required field and must be at least 6 characters.</b-form-invalid-feedback>
                        </b-form-group>
                        
                        <input type="submit" value="Login" class="btn btn-primary btn-block btn-u">
                        
                        <hr>
                        
                        <nuxt-link to="/signup" class="text-link d-block text-right">No account yet?</nuxt-link>

                        <div v-show="error" class="alert alert-danger mb-0 mt-3" role="alert">
                            {{ errorsMessage }}
                        </div>

                    </b-form>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Cookies from 'js-cookie';
import { validationMixin } from "vuelidate";
import { required, email, minLength } from "vuelidate/lib/validators";

export default {
    data () {
      return {
        form: {
          email: null,
          password: null
        },
        submitted: false,
        success: false,
        message: '',
        error: false,
        errorsMessage: []
      }
    },
    validations: {
    form: {
      email: {
        required,
        email
      },
      password: { required, minLength: minLength(6) }
    }
  },
    mounted(){
        if(this.$route.query.q) {
            this.success = true;
            this.message = decodeURI(this.$route.query.q);
        }
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
                email: this.form.email,
                password: this.form.password
            }

            await this.$store.dispatch('account/login', payload)
                .then( (resp) => {

                    if (resp.success == false) {

                        this.error = true;
                        this.errorsMessage = resp.message;

                    } else if (resp.success == true) {

                        var data = {
                            "token": resp.access_token,
                            "user": resp.user,
                            "loggedIn": true
                        }
                        this.$store.commit('setSession', data)
                        Cookies.set('session', data);

                        this.$router.push('/kudo');
                    }

            });
        }
    }
}
</script>
