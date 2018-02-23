# Twig Tools by [Basalt](http://basalt.io)

```bash
composer require basaltinc/twig-tools
```

## Twig Functions

### `get_data( path )`

Takes the path to a `.json`, `.yml`, or `.yaml` file and returns the data for use in Twig. 

#### Parameters
- `path` {string} Either absolute path, relative path from CWD, or Twig Namespace path like `@namespace/file.json`.

#### Example
```twig
{% set schema = get_data('@namespace/foobar.schema.yml') %}
```


### `validate_data_schema( path, _self )`

Takes the path to a `.json`, `.yml`, or `.yaml` data schema file and validates the data being used by the twig template file in which the validate function is included. As a standard, this should be the last thing included in a twig template file.


#### Parameters
- `path` {string} Either absolute path, relative path from CWD, or Twig Namespace path like `@bolt-components-foo/foo.schema.json`.
<!--@todo Salem or Evan, not sure how we should document the second parameter "_self". Can this be changed, or is it just a required input?-->

#### Example
```twig
{{ validate_data_schema('@namesapce/foobar.schema.yml', _self) }}
```


### `console_log( data )`

Outputs data to the browser's console log. 

#### Parameters
- `data` Any data you would like to log to the console from a twig template.

#### Example
```twig
{{ console_log(page.meta) }}
```

