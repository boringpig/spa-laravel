import Vue from 'vue'
import cn from '../validate-locales/cn';
import VeeValidate, { Validator } from 'vee-validate';

const { locale } = window.config;

Validator.localize(locale, cn);

Vue.use(VeeValidate);