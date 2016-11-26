# Sevent
Sevent: Server-Sent Events PHP &amp; JQuery Plugin

### HTML & js
```html
<!DOCTYPE html>
<html>
<head>
	<title>hello</title>
</head>
<body>
<script src="path/to/jquery.js"></script>
<script src="sevent.js"></script>
<script type="text/javascript">
		
	$(document).ready(function() {

		$.sevent.init({
			url: 'http://your-project/sevent.php',
		});

		$.sevent.on('open', function(event) {

			console.log('open'); 
		});

		$.sevent.on('message', function(response) {

			// response is a server response
			console.log('server response :' + response.data);
		});
		
	});	
</script>
</body>
</html>
```

### PHP 
```php 
<?php
// sevent.php

require_once('Sevent.class.php');

$event = new Sevent();

$sevent->header();

$event->response(function() use ($event) {
     
     // conditions and code here
		
    $event->message('hello world'); // sent a response message
});

```

## Custom Events

### Js
```javascript
$(document).ready(function() {

		$.sevent.init({
			url: 'http://your-project/sevent.php',
		});

		$.sevent.on('message', function(response) {
    
			// response is a server response
			console.log(response.data);
		});
    
    	$.sevent.on('news', function(response) {
    
			// your code here for ex: 
      	$('#news').append(response.data);
			console.log(response);
		});
    
    	$.sevent.on('newComment', function(response) {
    
			// your code here for ex: 
      	$('#comments').append(response.data);
			console.log(response);
		});
    
    	$.sevent.on('anythingBlaBla', function(data) {
    
			// anything code data is a server response
		});
		
});	
```
### PHP 
```php 

<?php
// sevent.php

require_once('Sevent.class.php');

$event = new Sevent();

$sevent->header();


$event->response(function() use ($event) {
     
     // conditions and code here
     
     $db = new mysqli('host', 'user', 'pass', 'db');
     
     $event->news('news conents');
     
     $blabla = $db->query('SELECT * FROM BlaBla');
     
     if ($blabla->num_rows > 0) {
        
        $event->anythingBlaBla('content here');
     }
		
    //if ( message true ) {
    
     // $event->message('hello world'); // sent a response message
   //}
   
   // if (newComment true) {

      // $event->newComment(' new comments conetnt here');
       
    //}   
   
});
```

## IE Not Supported :)

```javascript

$(document).ready(function() {

	$.sevent.init({
		url: 'http://your-project/sevent.php',

		// if browser not supported EventSource
		notSupported: function () {
			// your code 
			alert('your browser not supported, please download xName browser');
		}
	});
		
});

```

## How to Close Event

```javascript

$.sevent.exit();

```

### Sevent And JSON

#### php 

```php

<?php
// sevent.php

require_once('Sevent.class.php');

$event = new Sevent();

$sevent->header();

$event->response(function() use ($event) {
     
     // conditions and code here
     
     $yourCond = true;

     if ($yourCond === true) {

     	$response = new \stdClass;

     	$response->type = 'like';
     	$response->text = 'Mohamed like your image';
     	$response->url  = '/images/id/1111';

     	$event->notification( json_encode($response) );

     }
   
});

```

#### js
```javascript
$(document).ready(function() {

		$.sevent.init({
			url: 'http://your-project/sevent.php',
			notSupported: function () {
				alert('your browser not supported');
			}
		});

    
    	$.sevent.on('notification', function(response) {
    		
    		data = $.sevent.json(response);

    		if (data !== false) {

    			if (data.type === 'like') {

    				$('#notificationId').append('<a herf="'+ data.url +'"> ' + data.text + ' </a>');
    			
    			} else if (data.type === 'comment') {

    				// code
    			}
    		
    		}

		});
		
});	
```

#### Custom Headers

```php

require_once('Sevent.class.php');

$event = new Sevent();


$sevent->header(array(
	'Cache-Control' => 'no-cache',
	'Connection' 	=> 'Keep-alive', 
	// ...
));

```

#### Custom Response Options

```php 
require_once('Sevent.class.php');

$event = new Sevent();

$sevent->header();

//$event->eventName(string data, array options);

$event->notification('data', array(
	'id'    => 'ssss',
	'retry' => 5000, // 5sc
));

```





