# Symfony Flex Packs

This repository contains Symfony flex recipes to help you to build your apps quickly.

## Using in exist projects

Add the following to the `composer` `extra.symfony.endpoint` configuration:

```json
    "extra": {
        "symfony": {
            "allow-contrib": false,
            "require": "7.2.*",
            "endpoint": [
                "https://raw.githubusercontent.com/monofony/recipes/refs/heads/flex/main/index.json",
                "flex://defaults"
            ]
        }
    }
```
