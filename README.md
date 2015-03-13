# Fluid Content Elements
## TYPO3 Extension

A handy way to create new TYPO3 content elements.


### Why?

[Fluid Powered TYPO3](https://fluidtypo3.org/) is great and very powerful and if some day if have understood it fully and have read the [documentation](https://fluidtypo3.org/documentation/templating-manual/introduction.html) I'll probably never use anything else anymore.
But until then I'll stick with this handy little extension that let's you create new TYPO3 content elements (rendered by fluid) in no time.

### How?

In your `ext_localconf.php`:

```php
\AppZap\FluidContentelements\ContentElement::addContentElementTyposcript($_EXTKEY, 'My New Element');
```

In your `ext_tables.php`:

```php
\AppZap\FluidContentelements\ContentElement::registerContentElement($_EXTKEY, 'My New Element');
```

In your TYPO3 extension create the following file `Resources/Private/ContentElements/MyNewElement.html` to render your content element. (The file name is the name of the element without spaces).

This is the minimum setup to create a new content element called "My New Element".

### Documentation

#### `addContentElementTyposcript()`

Parameters:

* `$extensionKey`: Provide the key of the extension you create your content elements with (will be available as `$_EXTKEY` in your `ext_localconf.php`)
* `$title`: The name of your new content element. Convention: Make it human readable (english) with uppercase first letters.
  * **Do**: *Author Profile*, *Slider*, *Full Fledged Banner Ad*
  * **Don't**: *content_element_1*, *some mysterious slider*, *Neues Inhaltselement*
* `$standardHeader`: *boolean* (default: `true`). If `true` TYPO3 renders the header field with `lib.stdheader`.

#### `registerContentElement()`

Parameters:

* `$extensionKey`: See above
* `$title`: See above
* `$showItemList`: The *showitem* configuration for the new element. Refer to the [TCAReference](http://docs.typo3.org/typo3cms/TCAReference/Reference/Types/Index.html#showitem) for more information. By default the *showitem* configuration of the "Text with Image" element will be used.

#### Labels

You can localize your content element in the TYPO3 backend with the file `Resources/Private/Language/locallang_contentelements.xlf`

You can use the following keys:

* `tx_myext_my_new_element.title`: Name of the content element
* `tx_myext_my_new_element.description`: Description of the content element in the new content element wizard.

#### Icon

If you want add an icon file at: `Resources/Public/Icons/ContentElements/MyNewElement.png`
