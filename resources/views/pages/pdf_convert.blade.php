<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title>{{ $title }}</title>
</head>
<body>
  <div>
    <div class="row">
      <p class="col-md-12">{{ $content }}</p>
      <span class="col-md-12">{{ $date }}</span>
    </div>
    <div class="">
      <img style="max-width:100%;" src="{{ public_path('images/'.$image.'') }}" alt="image">
    </div>

  </div>
</body>
</html>
