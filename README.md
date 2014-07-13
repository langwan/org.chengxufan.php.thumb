Langwan PHP Thumb
=================

A powerful image thumb library for php

Example Usage
=============

Firstly, make your cache directory is writable, then access the script like so:

```html
<img src="img.php?uri=name_f-0-200" />
```
Query Parameters
================

<table>
    <tr>
        <th>Key</th>
        <th>Example Value</th>
        <th>Description</th>
    </tr>
    <tr>
        <td>f</td>
        <td>img.php?uri=name_f-{width}-{height}</td>
        <td>fixed width or height, zero is auto.`f-0-200` is auto width and fixed height, `f-200-0` is auto height and fixed width.</td>
    </tr>
    <tr>
        <td>a</td>
        <td>img.php?uri=name_a-{width}-{height}-{color}</td>
        <td>scaled down fill the background, `a-200-400-cccccc` image size is 200x400 background color is #cccccc.</td>
    </tr>
    <tr>
        <td>c</td>
        <td>img.php?uri=name_c-{width}-{height}</td>
        <td>cut off the excess part.</td>
    </tr>        
    <tr>
        <td>r</td>
        <td>img.php?uri=name_r-{width}-{height}</td>
        <td>resize image drawing this.</td>
    </tr>
</table>


