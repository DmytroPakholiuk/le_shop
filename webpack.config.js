// webpack.config.js
const path = require('path');
const webpack = require( 'webpack' );

const PATHS = {
    source: path.join(__dirname, 'vue-src'),
    build: path.join(__dirname, 'vue-web')
};

const { VueLoaderPlugin } = require('vue-loader');

module.exports = (env, argv) => {
    let config = {
        production: argv.mode === 'production'
    };

    return {
        mode: 'development',
        entry: [
            './vue-src/app.js'
        ],
        output: {
            path: PATHS.build,
            filename: config.production ? 'app.min.js' : 'app.js'
        },
        module: {
            rules: [
                {
                    test: /\.vue$/,
                    use: 'vue-loader'
                },
                {
                    test: /\.css$/,
                    // loader: ['style-loader', 'css-loader']
                    // loader: 'style-loader'
                    loader: 'css-loader'
                }
            ]
        },
        plugins: [
            new VueLoaderPlugin()
        ]
    };
};