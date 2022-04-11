<template>
    <div>

        <b-form @submit="onSubmit" v-if="show" class="form">

            <b-form-group
                id="input-group-1"
                label="Nome"
                label-for="input-1"
            >
                <b-form-input
                    id="input-1"
                    v-model="form.name"
                    type="text"
                    placeholder="Nome"
                    required
                ></b-form-input>
            </b-form-group>

            <b-form-group
                id="input-group-1"
                label="Email"
                label-for="input-1"
            >
                <b-form-input
                    id="input-1"
                    v-model="form.email"
                    type="email"
                    placeholder="Email"
                    required
                ></b-form-input>
            </b-form-group>

            <b-form-group id="input-group-2" label="Senha" label-for="input-2">
                <b-form-input
                    id="input-2"
                    type="password"
                    v-model="form.password"
                    placeholder="Senha"
                    required
                ></b-form-input>
            </b-form-group>

            <b-form-group id="input-group-2" label="Confirmar Senha" label-for="input-2">
                <b-form-input
                    id="input-2"
                    type="password"
                    v-model="form.confirme_pass"
                    placeholder="Confirmar Senha"
                    required
                ></b-form-input>
            </b-form-group>

            <b-button type="submit" variant="primary">Cadastrar</b-button>
        </b-form>

    </div>
</template>

<script>
import {BRow, BCol, BForm, BFormGroup, BFormInput, BFormSelect, BFormCheckboxGroup, BFormCheckbox, BButton, BCard,} from 'bootstrap-vue'

export default {
    components:{
        BRow, BCol, BForm, BFormGroup, BFormInput, BFormSelect, BFormCheckboxGroup, BFormCheckbox, BButton, BCard,
    },
    data() {
        return {
            form: {
                email: '',
                name: '',
                password: '',
                confirme_pass: '',
            },
            show: true,
            erros: []
        }
    },
    methods: {
        onSubmit(event) {
            event.preventDefault()
            axios.post('/api/register', this.form).then((item) =>{
                console.log('registrado', item)
            })
        },
    }
}
</script>
<style scoped>
.form{
    margin: 30px;
}
</style>
