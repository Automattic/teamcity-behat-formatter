teamcity-behat-2-formatter
========================

Behat 2.x tests formatter for TeamCity

To use in your project, add the vcs repository, as well as the dependency to your composer.json:

```
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/Automattic/teamcity-behat-2-formatter"
    }
],
"require": {
   "automattic/teamcity-behat-2-formatter": "~1.0"
}
```

Once installed (`composer update`), you can either hardcore the formatter in behat.xml:

```
default:
  formatter:
    name: Behat\TeamCity\TeamCityFormatter
```

eventually combine with multiple formatters:

```
default:
  formatter:
    name: Behat\TeamCity\TeamCityFormatter,pretty
```

or use the formatter via --format / -f params:

````
behat -f "Behat\TeamCity\TeamCityFormatter"
behat --format="Behat\TeamCity\TeamCityFormatter"
```
