teamcity-behat-2-formatter
========================

Behat 2.x tests formatter for TeamCity

behat.xml:

<pre>
default:
  formatter:
    name: Behat\TeamCity\TeamCityFormatter
</pre>

or use the --format / -f option:

<pre>
behat -f "Behat\TeamCity\TeamCityFormatter"
behat --format="Behat\TeamCity\TeamCityFormatter"
</pre>
