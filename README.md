Langwan PHP Thumb
=================

A url based image transformation php library.


Firstly, make your cache directory is writable, then access the script like so:

```html
<img src="img.php?uri=name_f-0-200" />
```

Original image
==============

![](http://langwan.08mi.com/site/img?uri=D649A288-D8BA-3BFA-895C-22B3D3D02AE0)

Resize by width:
================

The fllowing URL points to a 300px width dynamically created image, pass the 'f' parameter by 'f-300-0':

```html
<img src="img.php?uri=name_f-300-0" />
```

![](http://langwan.08mi.com/site/img?uri=D649A288-D8BA-3BFA-895C-22B3D3D02AE0_f-300-0)

Resize by height:
=================

The following URL points to a 300px width dynamically created image, pass the 'f' parameter by 'f-0-300':

```html
<img src="img.php?uri=name_f-0-300" />
```

![](http://langwan.08mi.com/site/img?uri=D649A288-D8BA-3BFA-895C-22B3D3D02AE0_f-0-300)

Crop
====

Crop use 'c' as parameter, will get a 100px * 200px image cropping from center of the image

```html
<img src="img.php?uri=name_c-100-200" />
```

![](http://langwan.08mi.com/site/img?uri=D649A288-D8BA-3BFA-895C-22B3D3D02AE0_c-100-200)

Scaled Down
===========

use 'a' as parameter, will get a 100px * 200px image, default background is white

```
<img src="img.php?uri=name_a-100-200-555555" />
```

![](http://langwan.08mi.com/site/img?uri=D649A288-D8BA-3BFA-895C-22B3D3D02AE0_a-100-200-555555)

Stretch
=======

use 'r' as parameter, will get a 100px * 200px image
```
<img src="img.php?uri=name_r-100*200" />
```

![](http://langwan.08mi.com/site/img?uri=D649A288-D8BA-3BFA-895C-22B3D3D02AE0_r-100-200)

Version
=======
2014.07.13.17.00
