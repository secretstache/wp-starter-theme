/**
 * Compiler configuration
 *
 * @see {@link https://roots.io/sage/docs sage documentation}
 * @see {@link https://bud.js.org/learn/config bud.js configuration guide}
 *
 * @type {import('@roots/bud').Config}
 */
export default async (app) => {
	app.alias('@modules', app.path('node_modules'))

  /**
   * Application assets & entrypoints
   *
   * @see {@link https://bud.js.org/reference/bud.entry}
   * @see {@link https://bud.js.org/reference/bud.assets}
   */
  app
    .entry('app', ['@scripts/app', '@styles/app'])
    .entry('admin', ['@scripts/admin', '@styles/admin'])
    .assets(['images']);

  app.splitChunks({
    cacheGroups: {
      commons: {
      test: /[\\/]node_modules[\\/]|src[\\/]assets[\\/]scripts[\\/]libs/,
      name: 'vendor',
      enforce: true,
      chunks: 'all',
      },
    },
  });

  /**
   * Set public path
   *
   * @see {@link https://bud.js.org/reference/bud.setPublicPath}
   */
  app.setPublicPath('/wp-content/themes/THEME_PUBLIC_PATH_NAME/public/');

  /**
   * Development server settings
   *
   * @see {@link https://bud.js.org/reference/bud.setUrl}
   * @see {@link https://bud.js.org/reference/bud.setProxyUrl}
   * @see {@link https://bud.js.org/reference/bud.watch}
   */
  app
    .setUrl('http://localhost:3000')
    .setProxyUrl(process.env.WP_HOME)
    .watch(['resources/views', 'app']);
};
