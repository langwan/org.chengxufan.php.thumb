Langwan PHP Thumb
=================

一个基于URL生成缩略图的Yii扩展，当前版本v2.0.0。

原始图片
=======

```html
<img src="http://langwan.08mi.com/site/img/langwanphpthumb" />
```

![](http://langwan.08mi.com/site/img/langwanphpthumb)

宽度固定高度自适应（会被拉伸）
========================

如果你想创建一个宽度为400px的图片，你需要传递"fw_400"这个指令，如果你原始图片的宽度不够，图片会被拉伸，这样方式的好处是让你的图片完全适应你的设计。

```html
<img src="http://langwan.08mi.com/site/img/langwanphpthumb,fw_400" />
```

![](http://langwan.08mi.com/site/img/langwanphpthumb,fw_400)

设置最大宽度高度自适应
===================

如果你想创建一个宽度为400px的图片，你需要传递"mw_400"这个指令，如果你原始图片的宽度不够，会把原始图片输出到屏幕，这样图片不会被放大而难看。

```html
<img src="http://langwan.08mi.com/site/img/langwanphpthumb,mw_400" />
```

![](http://langwan.08mi.com/site/img/langwanphpthumb,mw_400)

拉伸图片
=======

如果你想得到一张400px * 300px的图片，你需要传递"r_400x300"这个指令，如果你想拉伸出一个正方形的图片，你也可以传递"r_400"。

```html
<img src="http://langwan.08mi.com/site/img/langwanphpthumb,r_400x300" />
<br />
<img src="http://langwan.08mi.com/site/img/langwanphpthumb,r_400" />
```

![](http://langwan.08mi.com/site/img/langwanphpthumb,r_400x300)

![](http://langwan.08mi.com/site/img/langwanphpthumb,r_400)

自适应（可能被放大）
================

如果你想得到一张400px * 400px的图片，你需要传递"s_400x300x555555"这个指令，图片不会被拉伸，但是空白的地方会被颜色填充，如果原图片的高度和宽度比你想得到的图片要小，图片会被放大。

```html
<img src="http://langwan.08mi.com/site/img/langwanphpthumb,s_400x400x555555" />
```

![](http://langwan.08mi.com/site/img/langwanphpthumb,s_400x400x555555)

自适应（不会被放大）
================

如果你想得到一张400px * 400px的图片，你需要传递"sm_400x300x555555"这个指令，图片不会被拉伸，但是空白的地方会被颜色填充，如果原图片的高度和宽度比你想得到的图片要小，会按照原始宽度和高度填充背景色。

```html
<img src="http://langwan.08mi.com/site/img/langwanphpthumb,sm_400x400x555555" />
```

![](http://langwan.08mi.com/site/img/langwanphpthumb,sm_400x400x555555)

组合指令
=======

如果你想让图片先自适应，然后再缩小到100px*100px，你可以使用两个指令组合"s_400x400x555555,r_100"，指令会从左到右依次执行

```html
<img src="http://langwan.08mi.com/site/img/langwanphpthumb,s_400x400x555555,r_100" />
```

![](http://langwan.08mi.com/site/img/langwanphpthumb,s_400x400x555555,r_100)

强制更新图片
==========

如果你发现图片没有正确生成，你希望在后台系统重新生成缩略图，你有两种办法，第一种办法是在{destDirectory}当中清除那个图片，或者你在后台调用代码覆盖这张缩略图。

```php
	
$uri = 'langwanphpthumb,fw_100';

$thumb = new LangwanThumb;
$thumb->setSrcDirectory($this->srcDirectory)
	->setKey($uri)
	->setDestDirectory($this->destDirectory)
	->setForce(true)
	->execute();

```

其中setForce(true)是希望每次调用强制覆盖缩略图。

清理的缩略图
==========

如果你的磁盘空间有限，你可以定期清理{$destDirectory}目录的缩略图，它们会重新生成。

扩展指令
=======

如果你想扩展出新的指令，你可以继承LangwanThumbCommand类实现自己的指令。

```
class CommandX extends LangwanThumbCommand {
	public function run($sfile, $dfile, $dmine, $value) {
		
	}
}
```

* $sfile - 原始图片的文件路径，如果你使用了组合指令，第二个指令以后$sfile等于$dfile。
* $dfile - 缩略图生成的文件路径。
* $dmine - 需要生成的文件格式
* $value - 指令的值

调用方法
=======

1. 配置Yii

```php
'aliases' => array(
	...
	'langwanthumb' => 'application.vendors.langwanthumb',
	...
),

'urlManager'=>array(
        'urlFormat'=>'path',
        'showScriptName' => false,
        'rules'=>array(
        	...
                'site/img/<uri:[\w_,-]+>' => 'site/img'
                ...
        ),
),

```

2. 配置Action

```php
public function actions()
{
	return array(
        'img'=>array(
            'class'=>'langwanthumb.LangwanThumbAction',
            'srcDirectory' =>Yii::app()->getBasePath()."/../resource/upload/",
            'destDirectory' => Yii::app()->getBasePath()."/../resource/thumb/"
        ),
	);
}
```

LangwanThumb设置
===============

＊ 表示必须设置的方法。

<table>
	<tr>
		<th>方法</th>
		<th>默认值</th>
		<th>说明</th>
	</tr>
	<tr>
		<td>* setKey($key)</td>
		<td>null</td>
		<td>一般key是例子当中全部uri的部分，可以用$_GET['uri']来获取，你也可以用其它形式来赋值。</td>
	</tr>
	<tr>
		<td>* setDestDirectory($destDirectory)</td>
		<td>null</td>
		<td>缩略图的存放路径。</td>
	</tr>
	<tr>
		<td>* setSrcDirectory($srcDirectory)</td>
		<td>null</td>
		<td>原始图片的存放路径。</td>
	</tr>
	<tr>
		<td>setForce($force)</td>
		<td>true</td>
		<td>false表示强制更新图片，true相反。</td>
	</tr>
	<tr>
		<td>setMine($mine)</td>
		<td>image/png</td>
		<td>你希望缩略图的生成格式，默认是png图。</td>
	</tr>
</table>
