<html>
  <head>
    <meta charset="utf-8">

  </head>
  <body>
    <b>Sender Name: </b>{{$name}}<br/>
    <b>Sender Phone: </b>{{$phone}}<br/>
    @if(!empty($company))
    <b>Company: </b>{{$company}}<br/>
    @endif
    <b>Comment: </b>{{$comment}}<br/>
  </body>
</html>
