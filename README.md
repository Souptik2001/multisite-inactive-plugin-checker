## Inactive plugins checker

A WordPress `mu-plugin` to check for inactive plugins in a multisite setup.

#### Inspiration

In single site installation checking inactive plugins is a easy task from the plugin list admin page.
But the same thing in a multisite installation is not so much easy. If you have many sites, in that case you have to find the active plugins in all of the sites and then combine those plugins and consider all the unique plugins. Apart from that you also have to consider the network activated plugin.
This mu-plugin creates a custom [wp-cli](https://wp-cli.org/) command to list all the inactive plugins for the multisite.

#### Usage instruction

- Place this script in the `wp-content/mu-plugins` directory.
- Then run the wp-cli command - `wp sd-inactive-plugin-checker`. And for getting extra logs - `wp sd-inactive-plugin-checker --extra-logs=true`.

#### Extra :tada:

This also provides a bash script called `remove-plugins.sh` inside `utils` folder, which you can use post getting the list of all the plugins from the wp-cli command. It will delete that plugin from your code base and raise a PR for that change in branches named `remove/<plugin_slug>`. This uses GH cli, so please install GH cli and login to GH cli.

**Usage instruction -**
- Place this script in your `wp-content` directory.
- Put the slugs of the plugins to be deleted in the array `pluginsToBeRemoved` like this -

```
pluginsToBeRemoved=("slug-1" "slug-2" "slug-3")
```
- Login to GH cli using `gh auth login`.
- Just run the script as `./remove-plugins.sh`.

*This is not a mistake! `,` should not present between elements.*
**The PRs will be raised against the master branch by default. Change the `baseBranch` variable to something else to raise the PRs against that branch.**