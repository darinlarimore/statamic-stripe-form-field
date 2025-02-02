module.exports = {
	content: ['./resources/**/*'],
	corePlugins: {
		preflight: false,
	},
	prefix: 's-',
	darkMode: ['variant', ['html[class*="dark"] &']],
}
