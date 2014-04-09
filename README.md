# Lemonstand Clean-up
---

### How to install

1. Create a `cleanup` directory in `/modules` and navigate to it `$ cd /modules/cleanup`
2. Pull the repo into the current directory `$ git clone git@github.com:GreatPotato/ls-module-cleanup.git .`
3. Login to the backend of LemonStand and configure your options (**Settings** > **System** > **Clean-up**)
4. Create a cron job (once an hour works well) that loads http://yoursite.com/cleanup E.g. `0 * * * * wget http://yoursite.com/cleanup`