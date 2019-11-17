<html>
  <body>
    <form action="{{route('product_url')}}" method="post" enctype="multipart/form-data">
      @csrf
      <input type="text" name="firstName" />
      <input type="text" name="lastName" />
      <input type="file" name="photo"/>
      <input type="submit" value="OK"/>
  </body>
</html>
