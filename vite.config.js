const { resolve } = require('path');

module.exports = {
  build: {
    outDir: 'dist',
    assetsDir: './',

    brotliSize: false,

    rollupOptions: {
      input: {
        main: resolve(__dirname, './src/js/index.js'),
        jquery: resolve(__dirname, './src/js/jquery.js'),
      },

      output: {
        entryFileNames: '[name].js',
        chunkFileNames: '[name].js',
        assetFileNames: '[name].[ext]',
      },
    },
  },
};
