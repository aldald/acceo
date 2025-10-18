# WordPress Churchill Theme with Gulp and Bootstrap

A Wordpress theme based on Bootstrap 5 and ACF


## Development and Production Process

1. Place source files in a theme folder on your WordPress install.


2. Navigate via terminal to the theme folder and run `npm i` to install dependencies.


2. Install **Gulp CLI**.

   If you don't already have Gulp CLI installed globally, you can install it via `npm i --global gulp-cli`.


3. To start the dev build process, either run the command `gulp` or use the `dev` command script in `package.json`
   (`npm run dev`). Both of these run the default gulp task which compiles, auto-prefixes, and minifies the Sass files,
   transpiles and minifies the JavaScript, and starts a Browsersync server which reloads the page on file change.

   *Note: source maps are only generated for development.*

   To build for production, run the command `gulp build --production`, or `npm run prod` for production-ready CSS
   and JavaScript.