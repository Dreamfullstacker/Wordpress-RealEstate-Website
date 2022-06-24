# RealHomes Theme

## Requirements
1. We recommend using [Local WP](https://localwp.com/) for local development.
2. Make sure your local installation for RealHomes has the `realhomes.local` URL, As during development this will be used as proxy by npm browserSync plugin.
3. Set *PHP* language level to version *7.0* in your IDE.
4. You need to have [Node.js](https://nodejs.org/en/) installed on your machine.

## Getting Started with Development
1. Clone this repository to `wp-content\themes` directory in you local WordPress install.
2. Go to the cloned directory through a *Terminal* app and run the command `sudo npm install` to install required npm plugins and related dependencies.

## Gulp Commands
- `gulp development` - To get started with theme development.
- `gulp styles` - To build all styles (classic, modern, common, vendors).
- `gulp classicStyles` - To build only classic styles.
- `gulp modernStyles` - To build only modern styles.
- `gulp commonStyles` - To build only common styles.
- `gulp vendorsStyles` - To produce a unified vendors.css file.
- `gulp vendorsJS` - To produce a unified vendors.js file.
- `gulp themeZip` - To produce theme zip.