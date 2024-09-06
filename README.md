## Inactive plugins checker

A WordPress `mu-plugin` to check for inactive plugins in a multisite setup.

#### Inspiration

In single site installation checking inactive plugins is a easy task from the plugin list admin page.
But the same thing in a multisite installation is not so much easy. If you have many sites, in that case you have to find the active plugins in all of the sites and then combine those plugins and consider all the unique plugins. Apart from that you also have to consider the network activated plugin.

> "Hey, hold on! I will just use `wp plugin list` command. Without the `--url` parameter will it not give us a summary of all the sites?"

The answer is unfortunately no. When you use `wp plugin list` command without the `--url` parameter, it just considers the main site and displays the active or inactive status according to that. So, for example you have a plugin named `xyz` which is activated on your main site, but deactivated on your other sites, it will give the value as `true`. Which seems good, because that's what we want right? But if you activate the same plugin on some other site and deactivate it on this site, then it displays `false`! Oh no! 🙁

And here comes this small mu-plugin to your rescue! 🎉 -

It create a custom [wp-cli](https://wp-cli.org/) command to list all the inactive plugins for the multisite.

This will be specially useful for sites having lot of plugins, which is difficult to manage manually.

🤫 This was actually created when managing a multisite with four active sites and around 160 plugins in total.

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
