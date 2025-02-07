
<template>
	<div class="s-text-sm">
		<template v-if="value">
			Payment received –
			<a :href="value" target="_blank" class="s-text-blue-600 hover:s-text-blue-800">
				View receipt
			</a>
		</template>
		<template v-else>
			No payment received
		</template>
	</div>
</template>

<script>
	export default {
		mixins: [Fieldtype],
	}
</script>
