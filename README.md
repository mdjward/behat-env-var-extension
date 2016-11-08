# Behat environment variable extension #

[![Build Status](https://scrutinizer-ci.com/g/mdjward/behat-env-var-extension/badges/build.png?b=master)](https://scrutinizer-ci.com/g/mdjward/behat-env-var-extension/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mdjward/behat-env-var-extension/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mdjward/behat-env-var-extension/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/mdjward/behat-env-var-extension/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/mdjward/behat-env-var-extension/?branch=master)

An extension to [Behat](http://behat.org/) to support the ingestion of environment variables into container parameters, for use in behat configuration.

## Example usage ##

Configure the extension as follows under Behat:

```yml
  extensions:
    Mdjward\Behat\EnvVarExtension:
      prefix: env
```

Any environment variables passed through to Behat will - as a consequence - be registered in the service container as parameters in the form:

`env.environment_variable_name`

...where `environment_variable_name` is the lower-case form of a given environment variable.  For example, a variable `MY_TEST_ENV` will be registered as `env.my_test_env`.

The `prefix` parameter is entirely optional, and will default to 'env' if not specified.
