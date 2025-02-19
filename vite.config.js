import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue2'

export default defineConfig({
	server: {
		cors: { origin: "*" },
	},
	plugins: [
		laravel({
			input: [
				'resources/js/cp.js',
				'resources/css/cp.css',
			],
			refresh: true,
			publicDirectory: 'resources/dist',
		}),
		vue(),
	],
})
