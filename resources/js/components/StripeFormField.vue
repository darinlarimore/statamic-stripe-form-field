
<template>
	<div>
		{{cardNumber}}
		{{cardExpiry}}
		{{cardCvc}}
	</div>
</template>

<script>
export default {
	mixins: [Fieldtype],

	computed: {
		message() {
			console.log(this.value);
		}
	}
}
</script>
