@if(isset($title))
    <title>{{ str_replace('_', ' ',config("APP_NAME","Lider_Book")) }} - {{$title}}</title>
    @else
    <title>{{ str_replace('_', ' ',config("APP_NAME","Lider_Book")) }} - Login</title>
@endif
