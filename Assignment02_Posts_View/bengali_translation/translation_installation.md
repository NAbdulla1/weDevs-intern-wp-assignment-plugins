First create a pot file with the command:

`wp i18n <plugin-root-dir> <pot-file-destination-file-name> [other options if necessary]`
(here `wp` is the alias of `wp-cli`)

Then open file with **PoEdit** or other software and do translation.
save the translation files `*.po` and `*.mo` extension.

rename the files to `text-domanin-of-plugin-{local}.po` and `text-domanin-of-plugin-{local}.mo`.
In our case: `a02_posts_view_textdomain-bn_BD.po` and `a02_posts_view_textdomain-bn_BD.mo`.
Then place these two files into `wp-content/languages/plugins` directory.

We have defined the text domain `a02_posts_view_textdomain` into the header section of the plugin base file.
