import Vue from 'vue'
import VeeValidate from 'vee-validate'

Vue.use(VeeValidate, {
    
})

const { locale } = window.config

const dictionary = {
    cn: {
        attributes: {
            username: '帐号'
        },
        messages: {
            required: '不能為空'
        }
    }
};

Validator.localize(locale, dictionary);