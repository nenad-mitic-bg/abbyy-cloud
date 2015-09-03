abbyy-cloud
===========

Interface for communication with ABBYY cloud OCR

### Usage ###

First, you have to register with ABBYY Cloud: https://cloud.ocrsdk.com/Account/Register

##### 1. Init

```PHP
use ShoneZlo\AbbyyCloud\AbbyyClient;
$abbyy = new AbbyyClient('my app name', 'my-app-key');
```

##### 2. Submit image (and wait for a while)

```PHP
$imagePath = '/absolute/path/to-image.jpg';
$text = $abbyy->performOcr($imagePath);
```

##### 3. Results!

```PHP
echo $text;
```