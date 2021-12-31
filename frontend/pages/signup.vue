<template>
  <div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
      <div class="col wrapper-box">
        <h2 class="wrapper-box__title text-center">Sign up</h2>
        
        <div>
      
          <b-form @submit.stop.prevent="handleSubmit" novalidate>

            <b-form-group id="input_group_1" label="Name" label-for="input_name">
              <b-form-input
                id="input_name"
                name="input_name"
                v-model="$v.form.name.$model"
                :state="validateState('name')"
                aria-describedby="input_name_feedback"
              ></b-form-input>

              <b-form-invalid-feedback
                id="input_name_feedback"
              >This is a required field and must be at least 3 characters.</b-form-invalid-feedback>
            </b-form-group>

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

			      <b-form-group id="input_group_4" label="Password" label-for="input_confirm_password">
              <b-form-input
                id="input_confirm_password"
                name="input_confirm_password"
				        type="password"
                v-model="$v.form.confirmPassword.$model"
                :state="validateState('confirmPassword')"
                aria-describedby="input_confirm_password_feedback"
              ></b-form-input>

              <template v-if="this.submitted && $v.form.confirmPassword.$error">
                <b-form-invalid-feedback id="input_confirm_password_feedback" v-if="!$v.form.confirmPassword.required">Confirm Password is required.</b-form-invalid-feedback>
                <b-form-invalid-feedback id="input_confirm_password_feedback" v-if="form.confirmPassword && !$v.form.confirmPassword.sameAsPassword">Password and Confirm Password should match</b-form-invalid-feedback>
              </template>
            </b-form-group>

            <!--<div class="form-group">
              <label for="">Confirm your password</label>
              <input type="password" name="password2" id="password2" autocomplete="off" class="input-lg form-control">
            </div>-->
                  
            <button class="btn btn-primary btn-block btn-u" type="submit">Sign Up</button>
            <hr>
            <nuxt-link to="/login" class="text-link d-block text-right">Already have an account?</nuxt-link>

            <div v-show="error" class="alert alert-danger mb-0 mt-3" role="alert">
              <ul>
                <li v-for="(error, index) in errorsMessage" :key="index">
                  {{ error[1] }}
                </li>
              </ul>
            </div>
          
          </b-form>

        </div>
      </div>

    </div>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import { validationMixin } from "vuelidate";
import { required, email, minLength, sameAs } from "vuelidate/lib/validators";

export default {
  mixins: [validationMixin],
  data () {
      return {
        form: {
          name: null,
          email: null,
          password: null,
		      confirmPassword: null
        },
        submitted: false,
        success: false,
        error: false,
        errorsMessage: []
      }
  },
  validations: {
    form: {
      name: {
        required,
        minLength: minLength(3)
      },
      email: {
        required,
        email
      },
      password: { required, minLength: minLength(6) },
      confirmPassword: { required, sameAsPassword: sameAs('password') }
    }
  },
  computed: {
      //...mapState('account', ['status'])
  },
  methods: {
    validateState(name) {
      const { $dirty, $error } = this.$v.form[name];
      return $dirty ? !$error : null;
    },    
    async handleSubmit(e) {
      this.submitted = true;

      this.$v.form.$touch();

      if (this.$v.form.$anyError) {
        return;
      }

      console.log('submit');

      const payload = {
          name: this.form.name,
          email: this.form.email,
          password: this.form.password,
		      confirmPassword: this.form.confirmPassword
      }

      await this.$store.dispatch('account/register', payload)
        .then( (resp) => {
          
          //console.log('register', resp);

          if (resp.success == false) {
            this.error = true;
            this.errorsMessage = Object.entries(resp.message);
          } else if (resp.success == true) {
            this.$router.push('/login?q='+encodeURI('Account was created succesfully'));
          }


        });
      //this.register(this.form);
    }
  }
};
</script>