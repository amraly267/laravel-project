<form action="{{url('upload-file')}}" method="post" enctype="multipart/form-data">
    @csrf()
    <input type="file" name="image" >
    <input type="submit" value="upload">

</form>
