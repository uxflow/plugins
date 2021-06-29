const { resolve } = require('path');

module.exports = {
  build: {
    outDir: 'dist',
    assetsDir: './',

    brotliSize: false,

    rollupOptions: {
      input: {
        main: resolve(__dirname, './lib/vendor/js/index.js'),
        jquery: resolve(__dirname, './lib/vendor/js/jquery.js'),
        styles: resolve(__dirname, './lib/vendor/js/styles.js'),
      },

      output: {
        entryFileNames: '[name].js',
        chunkFileNames: '[name].js',
        assetFileNames: '[name].[ext]',
      },
    },
  },
};
