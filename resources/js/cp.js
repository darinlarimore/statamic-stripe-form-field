import '../css/cp.css'
import Fieldtype from './components/StripePayment.vue'

Statamic.booting(() => {
	Statamic.$components.register('stripe_payment-fieldtype', Fieldtype)
})
