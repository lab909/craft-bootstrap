import ViteRestart from 'vite-plugin-restart'

let port = 3000;

// https://vitejs.dev/config/
export default ({ command }) => ({
  cacheDir: 'node_modules/.vite',
	base: command === 'serve' ? '' : '/dist/',

	build: {
		emptyOutDir: true,
		manifest: true,
		outDir: 'web/dist/',
    sourcemap: true,
		rollupOptions: {
			input: {
			},
		},
	},

	plugins: [
    ViteRestart({
      reload: ['templates/**/*'],
    }),
	],

	// Anything in publicDir will be copied into web/dist during `npm run build`
	publicDir: './src/public',

	// https://nystudio107.com/docs/vite/#specifying-the-dev-server-port
	server: {
		// Allow cross-origin requests -- https://github.com/vitejs/vite/security/advisories/GHSA-vg6x-rcgg-rjx6
		allowedHosts: true,
		cors: {
			origin:
				/https?:\/\/([A-Za-z0-9\-\.]+)?(localhost|\.local|\.test|\.site)(?::\d+)?$/,
		},
		fs: {
			strict: false,
		},
		headers: {
			'Access-Control-Allow-Private-Network': 'true',
		},
		host: '0.0.0.0',
    origin: `${process.env.DDEV_PRIMARY_URL}:${port}`,
		port: 3000,
		strictPort: true,
	},
})
