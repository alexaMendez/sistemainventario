const typescript = require('@rollup/plugin-typescript')
const pkg = require('../../package.json')

const year = new Date().getFullYear()
const banner = `/*!
 * technologysolution v${pkg.version} (${pkg.homepage})
 * Copyright 2014-${year} ${pkg.author}
 * Licensed under MIT ()
 */`

module.exports = {
  input: 'src/ts/technologysolution.ts',
  output: {
    file: 'dist/js/technologysolution.js',
    format: 'umd',
    banner,
    name: 'technologysolution'
  },
  plugins: [typescript()]
}
