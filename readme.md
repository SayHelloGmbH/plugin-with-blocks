# Plugin with blocks

The code in this repository is intended as a copy-paste resource for adding
custom blocks to the WordPress block editor using the block.json registration technique.

This code should be copied into a plugin, according to the standardized file structure
in place for Say Hello Plugins and Themes for WordPress.

The general base of such a Plugin is at https://github.com/WPSwitzerland/plugin-boilerplate-psr.

The general base of such a Theme is at https://github.com/sayhellogmbh/hello-fse.

## Placeholder in this code

The placeholders `PLUGIN_NAME` and `PLUGIN_NAME_PASCAL_CASE` appear throughout this code.
Replace them with the actual plugin slugs -- e.g. `shp_myfirstblock` or `shp_clientblocks` --
and the pascal-cased versions of the name -- e.g. `ShpMyfirstblock` -- before starting work.

## Adding a new block

Each block should receive its own subfolder within the _src_ folder, as per the
contents of the example _MyFirstBlock_ folder.

The _block.json_ file contains the configuration for each block, which WordPress
uses in order to register the block.

The block registration happens through the `register_block_type` call in the Block package, which
gets called on the `init` hook. The example uses server-side rendering, which takes place
through the `renderBlock` method in the Block package.

The individual Block packages are loaded from the `loadClasses` method in the `Plugin` class.
The base code contains an autoloader which will find the appropriate files. Add an entry for each
block in this loader.

e.g.: `Blocks\MyFirstBlock\Block::class`, maps to src/Blocks/MyFirstBlock/Block.php.

Use the namespace namespace SayHello\PLUGIN_NAME_PASCAL_CASE\Blocks\MyFirstBlock; in the block files.

### Saving JSX-generated content

If you want to render the content directly in the editor using JSX, and save this content
to the database directly, add the `save` method to the _src/Blocks/MyFirstBlock/assets/src/scripts/editor/index.js_ file.

In this case, remove the `render_callback` from the Block package.

## Assets

The block.json file defines which scripts and style files are to be loaded. The editor JavaScript
file is essential: without this, the block cannot appear in the block editor.

### Compilation

The SCSS files and the Javascript files are compiled by a Gulp process, with Webpack compilation
for the JavaScript files. This is essential, so that the JavaScript source files can be written
using JSX. The compiled files (.css and .js) are loaded from the _assets/dist_ folder. The source files
are within the _assets/src_ folder.

The Gulp task files are in the _.build/gulp_ folder. Thes differ from the regular task files in the [Hello FSE Theme](https://github.com/SayHelloGmbH/hello-fse/tree/main/.build/gulp),
but largely follow the same basic premise. The tasks -- in particular the script task -- is specifically
customised for use with this file structure.

In order to start the compilation watch process, run `npm install` and then `npm start`. This
will start the watcher, which will re-compile the available files when they are saved.

### Asset loading

The files from e.g. _src/MyFirstBlock/assets/src/styles_ will be saved to _src/MyFirstBlock/assets/dist/styles_. The
_dist_ path should be used in the block.json file, thus: `"editorScript": "file:./assets/dist/scripts/editor.js"`.

Each block has its own block.json, _src_ and _dist_ files. Depending on the configuration, these files may be merged by
WordPress core or loaded inline. In some cases, the frontend assets might only be loaded if the block is placed
in the content of the page being viewed.

This code does not need to load any assets: that is taken care of by WordPress core.

## Gitignore

The dist folder is excluded from this repository by a rule in the _.gitignore_ file. They must not be
excluded from a plugin using this code base!

## Author

Mark Howells-Mead, Say Hello GmbH
mark@sayhello.ch

Since 9.9.2022
